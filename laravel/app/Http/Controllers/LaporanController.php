<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absensi;
use Carbon\CarbonPeriod;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    //

    protected $totalPegawai=0;
    protected $sudahAbsenMasuk=0;
    protected $belumAbsenMasuk=0;
    protected $sudahAbsenPulang=0;
    protected $belumAbsenPulang=0;
    public function ambilDataAbsenHarian($id, $tanggal)
    {
        $data = Absensi::select('absensis.id as idabsen','users.id', 'users.name', 'users.nip', 'absensis.jam_masuk', 'absensis.jam_pulang', 'absensis.foto_masuk', 'absensis.foto_pulang', 'absensis.foto_izin')
            ->join('users', 'absensis.user_id', '=', 'users.id')
            ->whereDate('absensis.created_at', $tanggal)
            ->where('user_id', $id)
            ->get()->toArray();

        // $data=Absensi::with('user')
        //             ->where('user_id',$id)
        //             ->whereDate('created_at',$tanggal)
        //             ->get()->toArray();
        // dd($data);
        
        return $data;
    }
    public function laporanHarian(Request $request): View
    {
        $tanggal = Carbon::parse($request['tanggal']);
        $this->hitungYangSudahAbsen($tanggal);
        $allUsers = User::select('id', 'name', 'nip')
            ->where('role', 'user')
            ->orderBy('name')
            ->get()
            ->toArray();
      
        foreach ($allUsers as $au) {

            if (!blank($this->ambilDataAbsenHarian($au['id'], $tanggal))) {
                $dataAbsenHarian[] = $this->ambilDataAbsenHarian($au['id'], $tanggal);
            } else {
                $dataBlank = array(
                    "idabsen"=>null,
                    "id" => $au['id'],
                    "name" => $au['name'],
                    "nip" => $au['nip'],
                    "jam_masuk" => "0",
                    "jam_pulang" => "0",
                    "foto_masuk" => "0",
                    "foto_pulang" => "0",
                    "foto_izin" => "0"
                );
                $dataAbsenHarian[] = array($dataBlank);
            }
        }
        // dd($dataAbsenHarian);
        return view('admin.laporan.harian', [
            "title" => "Laporan Harian :".$tanggal->isoFormat('D MMMM Y'),
            "dataAbsenHarian" => $dataAbsenHarian,
            "tanggal" => $tanggal->isoFormat('dddd,D MMMM Y'),
            "sudahAbsenMasuk"=>$this->sudahAbsenMasuk,
            "belumAbsenMasuk"=>$this->belumAbsenMasuk,
            "sudahAbsenPulang"=>$this->sudahAbsenPulang,
            "belumAbsenPulang"=>$this->belumAbsenPulang,
            "daftarNamaHadir"=>$this->summaryHadir($tanggal),
            "daftarNamaDL"=>$this->summaryDinasLuar($tanggal),
            "daftarNamaIzin"=>$this->summaryIzin($tanggal),
            "daftarNamaSakit"=>$this->summarySakit($tanggal),
            "daftarNamaBelumHadir"=>$this->summaryBelumHadir($tanggal)

        ]);
    }

    public function pilihTanggalLH(): View
    {
        return view('admin.laporan.pilihtanggallh', [
            "title" => "Laporan Harian"
        ]);
    }

    public function pilihTanggalLM(): View
    {
        return view('admin.laporan.pilihtanggallm', [
            "title" => "Laporan Mingguan"
        ]);
    }

    public function laporanMingguan(Request $request): View
    {
        $tanggal = $request['tanggal'];
        $period = CarbonPeriod::create(Carbon::parse($tanggal)->startOfWeek(Carbon::SUNDAY), Carbon::parse($tanggal)->endOfWeek(Carbon::SATURDAY));

        $all_Users = User::select('id', 'name', 'nip')
            ->where('role', 'user')
            ->orderBy('name')
            ->get()
            ->toArray();

        $header = array("Nama");
        foreach ($period as $date) {
            $header[] = $date->isoFormat('D/MM');
        }
        foreach ($all_Users as $au) {
            $jam_kerja_per_minggu=0;
            $jam_Kerja_Per_Hari=0;
            
            foreach ($period as $date) {
                
                $data = Absensi::select('jam_masuk', 'jam_pulang')
                    ->where('user_id', $au['id'])
                    ->whereDate('created_at', $date)
                    ->get()->toArray();
                if (!blank($data)) {
                    $data_absen_per_orang[] = $data[0];
                    //hitung jumlah jam kerja
                    if (strlen($data[0]['jam_masuk']) > 3 and strlen($data[0]['jam_pulang']) > 3) {
                        $jam_Kerja_Per_Hari = strtotime($data[0]['jam_pulang']) - strtotime($data['0']['jam_masuk']);
                    } else {
                        $jam_Kerja_Per_Hari = 0;
                    }

                } else {
                    $data = array("jam_masuk" => "0", "jam_pulang" => "0");
                    $data_absen_per_orang[] = $data;
                    $jam_Kerja_Per_Hari=0;
                }
                $jam_kerja_per_minggu+=$jam_Kerja_Per_Hari;
            }
            $jam=(int) floor($jam_kerja_per_minggu/3600);
            $menit=(int) floor(($jam_kerja_per_minggu-($jam*3600))/60);
            $detik=(int) $jam_kerja_per_minggu-(($jam*3600)+($menit*60));
            $string_Jam_Kerja_Per_Minggu=$jam.' Jam '.$menit.' menit '.$detik.' detik ';

            $data_lengkap_per_orang = array("nama" => $au['name'], "nip" => $au['nip']);
            $data_lengkap_per_orang['absen'] = $data_absen_per_orang;
            $data_lengkap_per_orang['total_jam_kerja_per_minggu']=$string_Jam_Kerja_Per_Minggu;
            $seluruh_data[]=$data_lengkap_per_orang;
            unset($data_absen_per_orang);
        }

        $header[] = 'Total';

        // dd($seluruh);

        $string_Tahun=Carbon::parse($tanggal)->year;
        return view('admin.laporan.mingguan', [
            "title" => "Laporan Mingguan <br> Tahun:".$string_Tahun,
            "header" => $header,
            "data"=>$seluruh_data
        ]);
    }

    public function pilihBulanTahun():View
    {
        return view('admin.laporan.pilihbulantahun',[
            "title"=>"Laporan Bulanan"
        ]);
    }

    public function laporanBulanan(Request $request):View
    {
        $bulan=$request['tanggal'];
        $normal_hari=$request['normal_hari'];
        $tanggal_Awal=Carbon::parse($bulan)->startOfMonth();
        $tanggal_Akhir=Carbon::parse($bulan)->endOfMonth();
        $period=CarbonPeriod::create($tanggal_Awal,$tanggal_Akhir);

        $all_Users = User::select('id', 'name', 'nip')
        ->where('role', 'user')
        ->orderBy('name')
        ->get()
        ->toArray();

        $header = array("Nama");
        foreach ($period as $date) {
            $header[] = $date->isoFormat('D');
        }

        foreach ($all_Users as $au) {
           
            foreach ($period as $date) {
                $data = Absensi::select('jam_masuk', 'jam_pulang')
                    ->where('user_id', $au['id'])
                    ->whereDate('created_at', $date)
                    ->get()->toArray();
                if (!blank($data)) {
                    $data_absen_per_orang[] = $data[0];
                } else {
                    $data = array("jam_masuk" => "0", "jam_pulang" => "0");
                    $data_absen_per_orang[] = $data;
                }
                
            }
          

            $data_lengkap_per_orang = array("nama" => $au['name'], "nip" => $au['nip']);
            $data_lengkap_per_orang['absen'] = $data_absen_per_orang;
        
            $seluruh_data[]=$data_lengkap_per_orang;
            unset($data_absen_per_orang);
        }
      
            




        $string_Bulan=Carbon::parse($bulan)->monthName;
        $string_Tahun=Carbon::parse($bulan)->year;
        // dd($string_Tahun);

        foreach ($all_Users as $au) {
            $jam_kerja_per_bulan=0;
            $jam_Kerja_Per_Hari=0;
            $tidak_hadir=0;
            $riil_hari=0.0;
            $absen_hari=0;
            $izin=0;
            $izin_jam=0;
            $sakit=0;
            $sakit_jam=0;
            $dinas_luar=0;
            $scan=0;
            
            $data_rekap_per_orang=array("nama"=>$au['name'],"nip"=>$au['nip']);
            foreach ($period as $date) {
                $data = Absensi::select('jam_masuk', 'jam_pulang')
                    ->where('user_id', $au['id'])
                    ->whereDate('created_at', $date)
                    ->get()->toArray();

                    if (!blank($data)) {
                        // hitung riil hari
                    //    dd($data[0]['jam_masuk']);
                       if (strlen($data[0]['jam_masuk']) > 3 and strlen($data[0]['jam_pulang']) > 3) {
                            $riil_hari+=1;
                            
                        } else if(strlen($data[0]['jam_masuk']) > 3 and ($data[0]['jam_pulang']=='0')){
                            $riil_hari=$riil_hari+0.5;
                        }else if(($data[0]['jam_masuk']=='0') and strlen($data[0]['jam_pulang']) > 3){
                            $riil_hari=$riil_hari+0.5;
                        }

                        //hitung absen hari
                        if (strlen($data[0]['jam_masuk']) > 3 or strlen($data[0]['jam_pulang']) > 3) {
                            $absen_hari+=1;
                            
                        }
                        //hitung izin
                        if($data[0]['jam_masuk']=='I'){
                            $izin+=1;
                        }
                        $izin_jam=$izin*6.25;

                           //hitung sakit
                           if($data[0]['jam_masuk']=='S'){
                            $sakit+=1;
                        }
                        $sakit_jam=$sakit*6.25;
                        
                           //hitung dinas luar
                        if($data[0]['jam_masuk']=='DL'){
                            $dinas_luar+=1;
                        }
                          //hitung jumlah jam kerja
                        if (strlen($data[0]['jam_masuk']) > 3 and strlen($data[0]['jam_pulang']) > 3) {
                            $jam_Kerja_Per_Hari = strtotime($data[0]['jam_pulang']) - strtotime($data['0']['jam_masuk']);
                        } else {
                            $jam_Kerja_Per_Hari = 0;
                        }
                        
                    } else {
                        $tidak_hadir+=1;
                }
            $jam_kerja_per_bulan+=$jam_Kerja_Per_Hari;
            }
            $total_jam_kerja_per_bulan=(int) floor($jam_kerja_per_bulan/3600);
            $data_rekap_per_orang+=["normal_hari"=>$normal_hari,
                                                        "riil_hari"=>$riil_hari,
                                                        "absen_hari"=>$absen_hari+$dinas_luar,
                                                        "tidak_hadir"=>$tidak_hadir,
                                                        "jml_izin"=>$izin,
                                                        "izin_jam"=>$izin_jam,
                                                        "sakit_jam"=>$sakit_jam,
                                                        "dinas_luar"=>$dinas_luar,
                                                        "total_jam_kerja_bulan"=>$total_jam_kerja_per_bulan+($dinas_luar*7),
                                                        "rata2"=>round(($riil_hari+$dinas_luar)/$normal_hari*100)
                                                    ];
            $rekap_data[]=$data_rekap_per_orang;
            unset($data_rekap_per_orang);
            
}

        return view('admin.laporan.bulanan',[
            "title"=>"Laporan Bulanan <br>Bulan:$string_Bulan <br>Tahun:$string_Tahun",
            "header"=>$header,
            "data"=>$seluruh_data,
            "rekap"=>$rekap_data
        ]);
    }

    public function hitungYangSudahAbsen($tanggal)
{

    $this->totalPegawai=User::where('role','user')->count();
    $this->sudahAbsenMasuk=Absensi::whereDate('created_at',$tanggal)->count('user_id');
    $this->belumAbsenMasuk=$this->totalPegawai-$this->sudahAbsenMasuk;
    $this->sudahAbsenPulang=Absensi::whereDate('created_at',$tanggal)->where('jam_pulang','<>','0')->count('user_id');
    $this->belumAbsenPulang=$this->totalPegawai-$this->sudahAbsenPulang;
}

public function summaryHadir($tanggal){
    
    $pegawaiHadir=Absensi::select('user_id')
                                ->whereRaw('LENGTH(jam_masuk)>3')
                                ->whereDate('created_at',$tanggal)
                                ->get();
    // dd($pegawaiHadir);                                
    return $pegawaiHadir;
}

public function summaryIzin($tanggal){

    $pegawaiIzin=Absensi::select('user_id')
                                ->where('jam_masuk','I')
                                ->whereDate('created_at',$tanggal)
                                ->get();
    
    return $pegawaiIzin;
}

public function summarySakit($tanggal){

    $pegawaiSakit=Absensi::select('user_id')
                                ->where('jam_masuk','S')
                                ->whereDate('created_at',$tanggal)
                                ->get();
    
    return $pegawaiSakit;
}

public function summaryDinasLuar($tanggal){

    $pegawaiDL=Absensi::select('user_id')
                                ->where('jam_masuk','DL')
                                ->whereDate('created_at',$tanggal)
                                ->get();
    
    return $pegawaiDL;
}

public function summaryBelumHadir($tanggal){

    $pegawaiBH=array();
    $allUser=User::select('id','name')->where('role','user')->orderBy('name')->get();
    foreach($allUser as $au){
        $data=Absensi::where('user_id',$au['id'])->whereDate('created_at',$tanggal)->get();
        if(blank($data)){
            $pegawaiBH[]=$au['name'];
        }
    }
    return $pegawaiBH;
}

public function edit_absen($id):View
{
    $data=Absensi::with('user')
                    ->where('id',$id)
                    ->get();
    // dd($data);
    return view('admin.laporan.editabsen',[
         "title" => "Ubah Absen",
        "data"=>$data,
        "id"=>$id
    ]);
}

public function update_absen(Request $request,$id):RedirectResponse
{
    $validasi=$request->validate([
        "jam_masuk"=>"required",
        "jam_pulang"=>"required",
        "foto_masuk"=>"image|file|max:10240",
        "foto_pulang"=>"image|file|max:10240"
    ],[
        "foto_masuk.max"=>"Ukuran Foto Maksimal adalah 10MB",
        "foto_pulang.max"=>"Ukuran Foto Maksimal adalah 10MB"
    ]);

    if($request->file('foto_masuk')){
        $validasi['foto_masuk']=$request->file('foto_masuk')->store('fotomasuk');
    }

    if($request->file('foto_pulang')){
        $validasi['foto_pulang']=$request->file('foto_pulang')->store('fotopulang');
    }

    Absensi::where('id',$id)->update($validasi);
    return redirect()->route('pilihtanggallh')->with('success','Data Absen Berhasil Diubah');
}

}
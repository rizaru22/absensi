<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absensi;
use Carbon\CarbonPeriod;
use Illuminate\View\View;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    //
    public function ambilDataAbsenHarian($id, $tanggal)
    {
        $data = Absensi::select('users.id', 'users.name', 'users.nip', 'absensis.jam_masuk', 'absensis.jam_pulang', 'absensis.foto_masuk', 'absensis.foto_pulang', 'absensis.foto_izin')
            ->join('users', 'absensis.user_id', '=', 'users.id')
            ->whereDate('absensis.created_at', $tanggal)
            ->where('user_id', $id)
            ->get()->toArray();

        return $data;
    }
    public function laporanHarian(Request $request): View
    {
        $tanggal = Carbon::parse($request['tanggal']);
        // dd($tanggal);
        $allUsers = User::select('id', 'name', 'nip')
            ->where('role', 'user')
            ->orderBy('name')
            ->get()
            ->toArray();
        // dd($allUsers[0]['id']);
        foreach ($allUsers as $au) {

            if (!blank($this->ambilDataAbsenHarian($au['id'], $tanggal))) {
                $dataAbsenHarian[] = $this->ambilDataAbsenHarian($au['id'], $tanggal);
            } else {
                $dataBlank = array(
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

        // $stringTitle=$tanggal->isoFormat('D MMMM Y');
        // dd($stringTitle);

        return view('admin.laporan.harian', [
            "title" => "Laporan Harian :".$tanggal->isoFormat('D MMMM Y'),
            "dataAbsenHarian" => $dataAbsenHarian,
            "tanggal" => $tanggal->isoFormat('dddd,D MMMM Y')
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

        return view('admin.laporan.bulanan',[
            "title"=>"Laporan Bulanan <br>Bulan:$string_Bulan <br>Tahun:$string_Tahun",
            "header"=>$header,
            "data"=>$seluruh_data
        ]);
    }
}

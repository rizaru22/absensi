<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absensi;
use Carbon\CarbonPeriod;
use Illuminate\View\View;
use App\Models\Pengaturan;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class DashboardPegawaiController extends Controller
{
    //
    public function index()
    {
        $tanggal = Carbon::now()->isoFormat('dddd,D MMMM Y');
        $pengaturan= Pengaturan::limit(1)->get();
        $period = CarbonPeriod::create(Carbon::now('Asia/Jakarta')->startOfWeek(Carbon::SUNDAY), Carbon::now('Asia/Jakarta')->endOfWeek(Carbon::SATURDAY));
        $jamKerjaPerHari=0;
        $jamKerjaPerMinggu=0;
        foreach ($period as $date) {
            $data= Absensi::select('created_at', 'jam_masuk', 'jam_pulang')
                ->whereDate('created_at', $date)
                ->where('user_id', Auth::user()->id)
                ->get()
                ->toArray();

                if($data==null){
                    $data=array([
                        'created_at'=>$date->toDateTimeString(),
                        'jam_masuk'=>'0',
                        'jam_pulang'=>'0',
                    ]);
                    $jamKerjaPerHari=0;
                }else{
                    if(strlen($data[0]['jam_masuk'])>3 and strlen($data[0]['jam_pulang'])>3){
                        $jamKerjaPerHari=strtotime($data[0]['jam_pulang'])-strtotime($data['0']['jam_masuk']);
                    }else{
                        $jamKerjaPerHari=0;
                    }
                }
            $dataAbsen[]=$data;
            $jamKerjaPerMinggu=$jamKerjaPerMinggu+$jamKerjaPerHari;
         
        }

        $jam=(int) floor($jamKerjaPerMinggu/3600);
        $menit=(int) floor(($jamKerjaPerMinggu-($jam*3600))/60);
        $detik=(int) $jamKerjaPerMinggu-(($jam*3600)+($menit*60));
        $stringJamKerjaPerMinggu=$jam.' Jam '.$menit.' menit '.$detik.' detik ';
  

        $jam_masuk_hari_ini=Absensi::select('jam_masuk')
            ->whereDate('created_at', Carbon::now('Asia/Jakarta')->toDateString())
            ->where('user_id', Auth::user()->id)
            ->get()
            ->toArray();

            if(empty($jam_masuk_hari_ini) || $jam_masuk_hari_ini[0]['jam_masuk'] === '0'){
                $jamMasukHariIni = 'Belum Absen';
            } else {
                $jamMasukHariIni = $jam_masuk_hari_ini[0]['jam_masuk'];
            }


        $jam_pulang_hari_ini = Absensi::select('jam_pulang')
            ->whereDate('created_at', Carbon::now('Asia/Jakarta')->toDateString())
            ->where('user_id', Auth::user()->id)
            ->get()
            ->toArray();

        if(empty($jam_pulang_hari_ini) || $jam_pulang_hari_ini[0]['jam_pulang'] === '0'){
            $jamPulangHariIni = 'Belum Absen';
        } else {
            $jamPulangHariIni = $jam_pulang_hari_ini[0]['jam_pulang'];
        }

        //buat nama tombol aja ribetnya, gara-gara translate browser
    
        $jam_sekarang = strtotime(Carbon::now('Asia/Jakarta')->isoFormat('HH:mm:ss'));
        $waktuMasuk = strtotime($pengaturan[0]->jam_masuk);
        $waktuMaksimalMasuk = strtotime($pengaturan[0]->jam_maksimal_masuk);
        $waktuPulang = strtotime($pengaturan[0]->jam_pulang);
        $waktuMaksimalPulang = strtotime($pengaturan[0]->jam_maksimal_pulang);

        if ($jam_sekarang > $waktuMasuk and $jam_sekarang < $waktuMaksimalMasuk) {
            $nama_tombol="Masuk";
        } elseif ($jam_sekarang > $waktuPulang and $jam_sekarang < $waktuMaksimalPulang) {
            $nama_tombol="Pulang";
           
        } elseif($jam_sekarang>$waktuMaksimalPulang){
            $nama_tombol="Lewat";
        }else{
            $nama_tombol="Belum";
        }

        return view('pegawai.dashboard', [
            "tanggal" => $tanggal,
            "pengaturan" => $pengaturan,
            "dataAbsen" => $dataAbsen,
            "jamKerjaPerMinggu"=>$stringJamKerjaPerMinggu,
            "jamPulangHariIni" => $jamPulangHariIni,
            "jamMasukHariIni" => $jamMasukHariIni,
            "nama_tombol"=>$nama_tombol,
        ]);
            

    }

    public function faq()
    {
        $data=Pengaturan::all();

        return view('pegawai.faq',[
            "pengaturan"=>$data
        ]);
    }

    public function lihatAkun(): View
    {
        $dataUser = User::select('name', 'nip', 'username', 'email')->where('id', Auth::user()->id)->get();
        // dd($dataUser[0]);
        return view('pegawai.akun', [
            "data" => $dataUser[0],
            "pengaturan"=> Pengaturan::limit(1)->get()
        ]);
    }

    public function updateAkun(Request $request): RedirectResponse
    {
        $validasi = $request->validate([
            "password" => "required"
        ]);

        $validasi['password'] = Hash::make($validasi['password']);
        User::where('id', Auth::user()->id)->update($validasi);


        return redirect()->route('pegawai')->with('success', 'Password telah diubah');
    }
}

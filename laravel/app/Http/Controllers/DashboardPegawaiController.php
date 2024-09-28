<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Pengaturan;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardPegawaiController extends Controller
{
    //
    public function index()
    {
        $tanggal = Carbon::now()->isoFormat('dddd,D MMMM Y');
        // $tanggal = Carbon::parse('2024-09-20')->isoFormat('dddd,D MMMM Y');
        // dd($tanggal);
        $pengaturan= Pengaturan::limit(1)->get();
        // $date=Carbon::now('Asia/Jakarta');
        $period = CarbonPeriod::create(Carbon::now('Asia/Jakarta')->startOfWeek(Carbon::SUNDAY), Carbon::now('Asia/Jakarta')->endOfWeek(Carbon::SATURDAY));
        $jamKerjaPerHari=0;
        $jamKerjaPerMinggu=0;
        foreach ($period as $date) {
            $data= Absensi::select('created_at', 'jam_masuk', 'jam_pulang')
                ->whereDate('created_at', $date)
                ->where('user_id', Auth::user()->id)
                ->get()
                ->toArray();
                // $a=json_decode($data);
                // dd($data);

                if($data==null){
                    $data=array([
                        'created_at'=>$date->toISOString(),
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
        // $jamKerjaPerMinggu=strtotime('12:15:30')-strtotime('07:30:20');
        $jam=(int) floor($jamKerjaPerMinggu/3600);
        $menit=(int) floor(($jamKerjaPerMinggu-($jam*3600))/60);
        $detik=(int) $jamKerjaPerMinggu-(($jam*3600)+($menit*60));
        $stringJamKerjaPerMinggu=$jam.' Jam '.$menit.' menit '.$detik.' detik ';
        // dd($stringJamKerjaPerMinggu);



        return view('pegawai.dashboard', [
            "tanggal" => $tanggal,
            "pengaturan" => $pengaturan,
            "dataAbsen" => $dataAbsen,
            "jamKerjaPerMinggu"=>$stringJamKerjaPerMinggu
        ]);

    }

    public function faq()
    {
        $data=Pengaturan::all();

        return view('pegawai.faq',[
            "data"=>$data
        ]);
    }
}

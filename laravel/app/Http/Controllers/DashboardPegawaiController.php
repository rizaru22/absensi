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
        $date=Carbon::now('Asia/Jakarta');
        $period = CarbonPeriod::create(Carbon::now('Asia/Jakarta')->startOfWeek(Carbon::MONDAY), Carbon::now('Asia/Jakarta')->endOfWeek(Carbon::SATURDAY));
        
        // dd($period);
        // $dataAbsen= Absensi::select('created_at', 'jam_masuk', 'jam_pulang')
        //         ->whereDate('created_at', $date)
        //         ->where('user_id', Auth::user()->id)
        //         ->get()
        //         ->toArray();
        //     dd($dataAbsen);
  
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
                }
            $dataAbsen[]=$data;
        }
        // dd($dataAbsen);




        return view('pegawai.dashboard', [
            "tanggal" => $tanggal,
            "pengaturan" => $pengaturan,
            "dataAbsen" => $dataAbsen
        ]);
    }
}

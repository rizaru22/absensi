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
        $tanggal = Carbon::now('Asia/Jakarta')->isoFormat('dddd,D MMMM Y');
        $data = Pengaturan::limit(1)->get();

        $period = CarbonPeriod::create(Carbon::now('Asia/Jakarta')->startOfWeek(Carbon::MONDAY), Carbon::now('Asia/Jakarta')->endOfWeek(Carbon::SATURDAY));
        foreach ($period as $date) {
            $dataAbsen[]= Absensi::select('created_at', 'jam_masuk', 'jam_pulang')
                ->whereDate('created_at', $date)
                ->where('user_id', Auth::user()->id)
                ->get();
                // ->toArray();
        }



        return view('pegawai.dashboard', [
            "tanggal" => $tanggal,
            "data" => $data,
            "dataAbsen" => $dataAbsen
        ]);
    }
}

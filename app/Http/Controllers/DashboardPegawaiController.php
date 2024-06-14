<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardPegawaiController extends Controller
{
    //
    public function index(){
        $tanggal=Carbon::now()->isoFormat('dddd,D MMMM Y');
        
        return view('pegawai.dashboard',[
            "tanggal"=>$tanggal
        ]);
    }
}

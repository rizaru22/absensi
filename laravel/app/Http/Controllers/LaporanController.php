<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    //
    public function ambilDataAbsenHarian($id,$tanggal)
    {
        $data=Absensi::select('users.id','users.name','users.nip','absensis.jam_masuk','absensis.jam_pulang','absensis.foto_masuk','absensis.foto_pulang','absensis.foto_izin')
        ->join('users','absensis.user_id','=','users.id')
        ->whereDate('absensis.created_at',$tanggal)
        ->where('user_id',$id)
        ->get()->toArray();
    
        return $data;
    }
    public function laporanHarian(Request $request):View
    {
        $tanggal=Carbon::parse($request['tanggal']);
        // dd($tanggal);
        $allUsers=User::select('id','name','nip')
                                    ->where('role','user')
                                    ->orderBy('name')
                                    ->get()
                                    ->toArray();
        // dd($allUsers[0]['id']);
        foreach ($allUsers as $au){
            
            if(!blank($this->ambilDataAbsenHarian($au['id'],$tanggal))){
                $dataAbsenHarian[]=$this->ambilDataAbsenHarian($au['id'],$tanggal);
            }else{
                $dataBlank=array(
                    "id"=>$au['id'],
                    "name"=>$au['name'],
                    "nip"=>$au['nip'],
                    "jam_masuk"=>"0",
                    "jam_pulang"=>"0",
                    "foto_masuk"=>"0",
                    "foto_pulang"=>"0",
                    "foto_izin"=>"0"
                );
                $dataAbsenHarian[]=array($dataBlank);
            }
        }
        // dd($dataAbsenHarian);



        return view('admin.laporan.harian',[
            "title"=>"Laporan Harian",
            "dataAbsenHarian"=>$dataAbsenHarian
        ]);
    }

    public function pilihTanggalLH():View
    {
        return view('admin.laporan.pilihtanggallh',[
            "title"=>"Laporan Harian"
        ]);
    }

}

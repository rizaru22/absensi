<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardAdminController extends Controller
{
    //
    public function index():View
    {
        $sudahAbsen=0;
        $belumAbsen=0;
        $tanggal = Carbon::now();
       
        $allUsers = User::select('id', 'name', 'nip')
            ->where('role', 'user')
            ->orderBy('name')
            ->get()
            ->toArray();
      
        foreach ($allUsers as $au) {

            if (!blank($this->ambilDataAbsenHarian($au['id'], $tanggal))) {
                $dataAbsenHarian[] = $this->ambilDataAbsenHarian($au['id'], $tanggal);
                $sudahAbsen+=1;
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
                $belumAbsen+=1;
            }
        }
  

        return view('admin.dashboard',[
            "title" => "Dashboard",
            "dataAbsenHarian" => $dataAbsenHarian,
            "tanggal" => $tanggal->isoFormat('dddd,D MMMM Y'),
            "sudah"=>$sudahAbsen,
            "belum"=>$belumAbsen
        ]);
    }

    public function ambilDataAbsenHarian($id, $tanggal)
    {
        $data = Absensi::select('users.id', 'users.name', 'users.nip', 'absensis.jam_masuk', 'absensis.jam_pulang', 'absensis.foto_masuk', 'absensis.foto_pulang', 'absensis.foto_izin')
            ->join('users', 'absensis.user_id', '=', 'users.id')
            ->whereDate('absensis.created_at', $tanggal)
            ->where('user_id', $id)
            ->get()->toArray();

        return $data;
    }

    public function ubahPassword():View
    {
        $dataUser = User::select('name', 'nip', 'username', 'email')->where('id', Auth::user()->id)->get();

        return view('admin.akun',[
                "title"=>"Update Account",
                "data"=>$dataUser[0]
        ]);
    }

    public function updatePassword(Request $request)
    {
       
        $validasi = $request->validate([
            "password" => "required"
        ]);

        $validasi['password'] = Hash::make($validasi['password']);
        User::where('id', Auth::user()->id)->update($validasi);


        return redirect()->route('admin');
    }
    
}

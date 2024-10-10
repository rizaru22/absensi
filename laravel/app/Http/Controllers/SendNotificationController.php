<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\Http\Request;

class SendNotificationController extends Controller
{
    //
    public function notifikasiMasuk(){
        $tanggal = Carbon::now();
        $nama=array();
        $user = User::select('id', 'name')
            ->where('role', 'user')->orderBy('name')
            ->get()->toArray();
        foreach ($user as $us) {
            $absensi = Absensi::select('jam_masuk')->where('user_id', $us['id'])->whereDate('created_at', $tanggal)->get();
            // dd($absensi,$us['name'],$tanggal);
            if (blank($absensi)) {
                $nama[] = $us['name'];
            }
        }
        $data['title'] = "Yang Belum Absen Masuk";
        $data['nama'] = $nama;
    }

    public function notifikasiPulang(){
        $tanggal = Carbon::now();
        $nama=array();
        $user = User::select('id', 'name')
            ->where('role', 'user')->orderBy('name')
            ->get()->toArray();
        foreach ($user as $us) {
            $absensi = Absensi::select('jam_pulang')->where('user_id', $us['id'])->whereDate('created_at', $tanggal)->get()->toArray();
            // dd($absensi[0]->jam_pulang,$us['name'],$tanggal);
            if (blank($absensi)) {
                $nama[] = $us['name'];
            } elseif ($absensi[0]['jam_pulang'] == '0') {
                $nama[] = $us['name'];
            }
        }
        $data['title'] = "Yang Belum Absen Pulang";
        $data['nama'] = $nama;

    }
}

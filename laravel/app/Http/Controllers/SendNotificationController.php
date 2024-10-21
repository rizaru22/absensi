<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\Support\Facades\Http;

class SendNotificationController extends Controller
{
    //
    public function notifikasiMasuk()
    {
        $no=1;
        $nama2='';
        $tanggal = Carbon::now();
        $user = User::select('id', 'name')
            ->where('role', 'user')->orderBy('name')
            ->get()->toArray();
        foreach ($user as $us) {
            $nama='';
            $absensi = Absensi::select('jam_masuk')->where('user_id', $us['id'])->whereDate('created_at', $tanggal)->get();
            if (blank($absensi)) {
                $nama ="\r\n".$us['name'];
            }

            $nama2.=$nama;
            $no++;
        }

        $this->apiPesan("Belum Absen Masuk " . $tanggal->isoFormat('DD MMMM Y').': '.$nama2);

    }

    public function notifikasiPulang()
    {
        $no=1;
        $nama2='';
        $tanggal = Carbon::now();
       
        $user = User::select('id', 'name')
            ->where('role', 'user')->orderBy('name')
            ->get()->toArray();
        foreach ($user as $us) {
            $nama='';
            $absensi = Absensi::select('jam_pulang')->where('user_id', $us['id'])->whereDate('created_at', $tanggal)->get()->toArray();
            // dd($absensi[0]->jam_pulang,$us['name'],$tanggal);
            if (blank($absensi)) {
                $nama ="\r\n".$us['name'];
            } elseif ($absensi[0]['jam_pulang'] == '0') {
                $nama ="\r\n".$us['name'];
            }
            
            $nama2.=$nama;
            $no++;
            
        }

        $this->apiPesan("Belum Absen Pulang " . $tanggal->isoFormat('DD MMMM Y').': '.$nama2);
    }

    public function apiPesan($pesan)
    {
        Http::post('https://api.telegram.org/bot7241376794:AAHTp6dr5SywEgFVktN5LB3UPm2apn7hmqQ/sendMessage?', [
            'chat_id' => '-1002344798403',
            'text' => $pesan
        ]);
    }
}

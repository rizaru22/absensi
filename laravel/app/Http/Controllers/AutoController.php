<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Libur;
use Illuminate\Http\Request;

class AutoController extends Controller
{
    //
    public function minggu()
    {
        $dt = Carbon::now();
        if ($dt->dayOfWeek() == Carbon::SUNDAY) { // cek apakah hari minggu

            //ambil data dari user
            $User_Ids = User::select('id')
                ->where('role', 'user')
                ->get()
                ->toArray();

            foreach ($User_Ids as $user_id) {
                $data['user_id'] = $user_id['id'];
                $data['jam_masuk'] = 'M';
                $data['jam_pulang'] = 'M';
                // isi data absensi ke hari minggu
                Absensi::create($data);
            }
        }
    }

    public function libur()
    {
        $dt = Carbon::now();

        //cari tanggal hari ini di tabel libur
        $libur=Libur::select('kode')->whereDate('tanggal',$dt)->get();
        //jika ketemu
        if (!blank($libur)) { 
            //ambil data dari user
            $User_Ids = User::select('id')
                ->where('role', 'user')
                ->get()
                ->toArray();

            foreach ($User_Ids as $user_id) {
                $data['user_id'] = $user_id['id'];
                $data['jam_masuk'] = $libur[0]->kode;
                $data['jam_pulang'] = $libur[0]->kode;
                // isi data absensi jadi hari libur
                Absensi::create($data);
            }
        }
    }
}

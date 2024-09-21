<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absensi;
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
}

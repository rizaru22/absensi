<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\View\View;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
// use Intervention\Image\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\ImageManagerStatic as Image;

class AbsenController extends Controller
{

    public function absen()
    {


        //cek apakah saat ini masuk ke waktu absen masuk atau absen pulang
        $Pengaturan = Pengaturan::select('*')
            ->limit(1)
            ->get();

        $waktuMasuk = $Pengaturan[0]->jam_masuk;
        $waktuMaksimalMasuk = $Pengaturan[0]->jam_maksimal_masuk;
        $waktuPulang = $Pengaturan[0]->jam_pulang;
        $waktuMaksimalPulang = $Pengaturan[0]->jam_maksimal_pulang;
        $jam_sekarang = Carbon::now('Asia/Jakarta')->isoFormat('H:mm:ss');

        $jam_sekarang = strtotime($jam_sekarang);
        $waktuMasuk = strtotime($waktuMasuk);
        $waktuMaksimalMasuk = strtotime($waktuMaksimalMasuk);
        $waktuPulang = strtotime($waktuPulang);
        $waktuMaksimalPulang = strtotime($waktuMaksimalPulang);

        if ($jam_sekarang > $waktuMasuk and $jam_sekarang < $waktuMaksimalMasuk) {
            //cek apakah sudah melakukan absen masuk
            if ($this->cekAbsensi() == false) {
                return redirect()->route('pegawai')->with('error', 'Anda sudah melakukan absensi/cuti');
            }

            return view('pegawai.fotomasuk', [
                "pengaturan" => Pengaturan::limit(1)->get()
            ]);
        } elseif ($jam_sekarang > $waktuPulang and $jam_sekarang < $waktuMaksimalPulang) {

            //cek apakah sudah melakukan absen pulang
            $cekAbsensi = Absensi::select("jam_pulang")
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('created_at', Carbon::today())
            ->get();
            
            if (!blank($cekAbsensi) && $cekAbsensi[0]->jam_pulang != 0) {
                return redirect()->route('pegawai')->with('error', 'Anda sudah melakukan absensi pulang');
            }
            return view('pegawai.fotopulang', [
                "pengaturan" => Pengaturan::limit(1)->get()
            ]);
        } elseif ($jam_sekarang < $waktuMasuk) {
            return redirect()->route('pegawai')->with('error', 'Anda belum dapat absen masuk');
        } elseif ($jam_sekarang > $waktuMaksimalPulang) {
            return redirect()->route('pegawai')->with('error', 'Anda sudah melewati waktu absen pulang');
        } else {
            return redirect()->route('pegawai')->with('error', 'Anda berada diluar waktu yang ditentukan untuk melakukan absen');
        }
    }


    public function kirimfotomasuk(Request $request): RedirectResponse
    {
        // dd(public_path(''));

        $validasi = $request->validate([
            "foto_masuk" => "required"
        ]);

        if (base64_decode($validasi['foto_masuk'])) {
            $imageParts = explode(";base64,", $validasi['foto_masuk']);
            $imageTypeAux = explode("image/", $imageParts[0]);
            $imageType = $imageTypeAux[1];

            $imageBase64 = base64_decode($imageParts[1]);
            $fileName = uniqid() . '.' . $imageType;
            Storage::disk('public')->put('fotomasuk/' . $fileName, $imageBase64);
        } else {
            return redirect()->route('pegawai')->with('error', 'Anda mengirimkan data yang tidak diizinkan');
        }


        $validasi["user_id"] = Auth::user()->id;
        $validasi["jam_masuk"] = Carbon::now('Asia/Jakarta')->isoFormat('HH:mm:ss');
        $validasi["jam_pulang"] = "0";
        $validasi["foto_pulang"] = "";
        $validasi['foto_masuk'] = 'fotomasuk/' . $fileName;


        if ($this->cekAbsensi() == true) {
            Absensi::create($validasi);
            return redirect()->route('pegawai')->with('success', 'Anda berhasil melakukan absensi');
        } else {
            return redirect()->route('pegawai')->with('error', 'Anda sudah melakukan absensi/cuti');
        }
    }



    public function kirimfotopulang(Request $request): RedirectResponse
    {

        $validasi = $request->validate([
            "foto_pulang" => "required"
        ]);


        if (base64_decode($validasi['foto_pulang'])) {
            $imageParts = explode(";base64,", $validasi['foto_pulang']);
            $imageTypeAux = explode("image/", $imageParts[0]);
            $imageType = $imageTypeAux[1];

            $imageBase64 = base64_decode($imageParts[1]);
            $fileName = uniqid() . '.' . $imageType;
            Storage::disk('public')->put('fotopulang/' . $fileName, $imageBase64);
        } else {
            return redirect()->route('pegawai')->with('error', 'Anda mengirimkan data yang tidak diizinkan');
        }

        $validasi["user_id"] = Auth::user()->id;
        $validasi["jam_pulang"] = Carbon::now('Asia/Jakarta')->isoFormat('HH:mm:ss');
        $validasi['foto_pulang'] = 'fotopulang/' . $fileName;

        // dd($validasi);

        if ($this->cekAbsensi()) {
            $absen = new Absensi;
            $absen->jam_pulang = $validasi["jam_pulang"];
            $absen->foto_masuk = '-';
            $absen->jam_masuk = '0';
            $absen->user_id = Auth::user()->id;
            $absen->foto_pulang = $validasi['foto_pulang'];
            $absen->save();
            return redirect()->route('pegawai')->with('success', 'Anda berhasil melakukan absensi');
        }

        $cekAbsensi = Absensi::select("jam_pulang")
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('created_at', Carbon::today())
            ->get();
        // dd($cekAbsensi);
        if (!blank($cekAbsensi)) {
        
            if ($cekAbsensi[0]->jam_pulang != 0) {
                return redirect()->route('pegawai')->with('error', 'Anda sudah melakukan absensi pulang');
            } else {

                Absensi::where('user_id', Auth::user()->id)->whereDate('created_at', Carbon::today())->update($validasi);

                return redirect()->route('pegawai')->with('success', 'Anda berhasil melakukan absensi');
            }
        }
    }
    public function izin()
    {

        if ($this->cekAbsensi() == false) {
            return redirect()->route('pegawai')->with('error', 'Anda sudah melakukan absensi/cuti');
        }
        return view('pegawai.cuti', [
            "pengaturan" => Pengaturan::limit(1)->get()
        ]);
    }

    public function kirimizin(Request $request): RedirectResponse
    {
        $validasi = $request->validate([
            "foto_izin" => "image|file|max:10240",
            "jam_masuk" => "required"
        ], [
            "foto_izin.max" => "Ukuran Foto Maksimal adalah 10MB"
        ]);

        if ($request->file('foto_izin')) {
            $validasi['foto_izin'] = $request->file('foto_izin')->store('fotoizin');
        } else {
            $validasi['foto_izin'] = '-';
        }

        $validasi["user_id"] = Auth::user()->id;
        $validasi["jam_pulang"] = $validasi['jam_masuk'];
        $validasi["foto_masuk"] = '-';
        $validasi["foto_pulang"] = '-';

        // dd($validasi);
        if ($this->cekAbsensi() == false) {
            return redirect()->route('pegawai')->with('error', 'Anda sudah melakukan absensi/cuti');
        }
        Absensi::create($validasi);
        return redirect()->route('pegawai')->with('success', 'Anda berhasil melakukan izin cuti');
    }



    public function cekAbsensi()
    {
        //query untuk mengambil data user apakah sudah pernah melakukan absensi masuk hari ini
        $cekAbsensi = Absensi::select("id")
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('created_at', Carbon::today())
            ->get();


        //mengecek absensi apakah sudah melakukan absensi masuk pada hari ini
        if (!blank($cekAbsensi)) {
            return false;
        } else {
            return true;
        }
    }
}

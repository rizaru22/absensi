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

    public function masuk(Request $request): RedirectResponse
    {
        $request->validate([
            "inputJarak" => "required"
        ],[
            'inputJarak.required'=>"Data lokasi masih kosong, silahkan aktifkan GPS, pastikan anda sudah berada di dalam area absensi dengan membuka Maps. Tutup aplikasi HadirIn kemudian jalankan kembali aplikasi HadirIn. Lalu coba kembali lakukan proses Absensi."
        ]);
        $jarak = $request->inputJarak;

        //query mengambil data setingan
        $Pengaturan = Pengaturan::select('*')
            ->limit(1)
            ->get();
        $jarakMaksimal = $Pengaturan[0]->jarak_maksimal;
        $waktuMasuk = $Pengaturan[0]->jam_masuk;
        $waktuMaksimalMasuk = $Pengaturan[0]->jam_maksimal_masuk;
        $jam_sekarang = Carbon::now('Asia/Jakarta')->isoFormat('H:mm:ss');

        if ($this->cekAbsensi()==false) {
            return redirect()->route('pegawai')->with('error', 'Anda sudah melakukan absensi/cuti');
        }

        //cek apakah waktu abseni berada dalam rentang waktu yang diizinkan untuk absen masuk

        $jam_sekarang = strtotime($jam_sekarang);
        $waktuMasuk = strtotime($waktuMasuk);
        $waktuMaksimalMasuk = strtotime($waktuMaksimalMasuk);

        // dd( $jam_sekarang,$waktuMaksimalMasuk);
        if ($jam_sekarang > $waktuMasuk and $jam_sekarang < $waktuMaksimalMasuk) {
            //cek apakah berada dalam lingkup area yang diizinkan untuk absen
            if ($jarak <= $jarakMaksimal) {
                return redirect()->route('fotomasuk');
            } else {
                return redirect()->route('pegawai')->with('error', 'Anda berada di luar area sekolah');
            }
        } else {
            return redirect()->route('pegawai')->with('error', 'Anda berada diluar waktu yang ditentukan untuk melakukan absen');
        }
    }

    public function kirimfotomasuk(Request $request): RedirectResponse
    {
        // dd(public_path(''));

        $validasi = $request->validate([
            "foto_masuk" => "required|image"
        ]);

        if ($request->file('foto_masuk')) {
            // $validasi['foto_masuk'] = $request->file('foto_masuk')->store('fotomasuk');
            $image=$request->file('foto_masuk');
            $filename=uniqid().'.'.$request->file('foto_masuk')->extension();
            $img=Image::make($image->path());
            $img->resize(900, 900, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->encode('jpg',100);
            Storage::disk('public')->put('fotomasuk/'.$filename,$img);
        }

        $validasi["user_id"] = Auth::user()->id;
        $validasi["jam_masuk"] = Carbon::now('Asia/Jakarta')->isoFormat('H:mm:ss');
        $validasi["jam_pulang"] = "0";
        $validasi["foto_pulang"] = "";
        $validasi['foto_masuk']='fotomasuk/'.$filename;


        if ($this->cekAbsensi()==true) {
            Absensi::create($validasi);
            return redirect()->route('pegawai')->with('success', 'Anda berhasil melakukan absensi');
        }else{
            return redirect()->route('pegawai')->with('error', 'Anda sudah melakukan absensi/cuti');
        }

    }

    public function pulang(Request $request): RedirectResponse
    {

        $request->validate([
            "inputJarakPulang" => "required"
        ],[
            "inputJarakPulang.required"=>"Data lokasi masih kosong, silahkan aktifkan GPS, pastikan anda sudah berada di dalam area absensi dengan membuka Maps. Tutup aplikasi HadirIn kemudian jalankan kembali aplikasi HadirIn. Lalu coba kembali lakukan proses Absensi."
        ]);
        $jarak = $request->inputJarakPulang;
        //query mengambil data setingan
        $Pengaturan = Pengaturan::select('*')
            ->limit(1)
            ->get();
        $jarakMaksimal = $Pengaturan[0]->jarak_maksimal;
        $waktuPulang = $Pengaturan[0]->jam_pulang;
        $waktuMaksimalPulang = $Pengaturan[0]->jam_maksimal_pulang;
        $jam_sekarang = Carbon::now('Asia/Jakarta')->isoFormat('H:mm:ss');

        $jam_sekarang = strtotime($jam_sekarang);
        $waktuPulang = strtotime($waktuPulang);
        $waktuMaksimalPulang = strtotime($waktuMaksimalPulang);

        if ($jam_sekarang > $waktuPulang and $jam_sekarang < $waktuMaksimalPulang) {
            //cek apakah berada dalam lingkup area yang diizinkan untuk absen
            if ($jarak <= $jarakMaksimal) {
                //cek tabel absensi
                
                //jika record sudah ada maka lakukan update di fotopulang
                if ($this->cekAbsensi()==false) {
                    $jamPulang = Absensi::select('jam_pulang')
                        ->whereDate('created_at', Carbon::today())
                        ->where('user_id', Auth::user()->id)
                        ->get();
                    if ($jamPulang[0]->jam_pulang != 0) {
                        return redirect()->route('pegawai')->with('error', "Anda sudah melakukan absen pulang atau mengajukan cuti");
                    } else {
                        return redirect()->route('fotopulang');
                    }
                }
                //jika record belum ada maka  kirim pesan error
                else {
                    return redirect()->route('pegawai')->with('error', 'Anda belum melakukan absen masuk');
                }
            } else {
                return redirect()->route('pegawai')->with('error', 'Anda berada di luar area sekolah');
            }
        } else {
            return redirect()->route('pegawai')->with('error', 'Anda berada diluar waktu yang ditentukan untuk melakukan absen');
        }
    }

    public function kirimfotopulang(Request $request): RedirectResponse
    {

        $validasi = $request->validate([
            "foto_pulang" => "required|image"
        ]);

        if ($request->file('foto_pulang')) {
            // $validasi['foto_pulang'] = $request->file('foto_pulang')->store('fotopulang');
            $image=$request->file('foto_pulang');
            $filename=uniqid().'.'.$request->file('foto_pulang')->extension();
            $img=Image::make($image->path());
            $img->resize(900, 900, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->encode('jpg',100);
            Storage::disk('public')->put('fotopulang/'.$filename,$img);
        }

        $validasi["user_id"] = Auth::user()->id;
        $validasi["jam_pulang"] = Carbon::now('Asia/Jakarta')->isoFormat('H:mm:ss');
        $validasi['foto_pulang']='fotopulang/'.$filename;


     

        $cekAbsensi = Absensi::select("jam_pulang")
        ->where('user_id', '=', Auth::user()->id)
        ->whereDate('created_at', Carbon::today())
        ->get();
        if($cekAbsensi[0]->jam_pulang!=0){
            return redirect()->route('pegawai')->with('error', 'Anda sudah melakukan absensi pulang');
        }else{
            Absensi::where('user_id', Auth::user()->id)->whereDate('created_at', Carbon::today())->update($validasi);
            return redirect()->route('pegawai')->with('success', 'Anda berhasil melakukan absensi');
        }

    }
    public function izin()
    {
  
        if ($this->cekAbsensi()==false) {
            return redirect()->route('pegawai')->with('error', 'Anda sudah melakukan absensi/cuti');
        }
        return view('pegawai.cuti');
    }

    public function kirimizin(Request $request): RedirectResponse
    {
        $validasi = $request->validate([
            "foto_izin" =>"image|file|max:10240",
            "jam_masuk" => "required"
        ],[
            "foto_izin.max"=>"Ukuran Foto Maksimal adalah 10MB"
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
        if ($this->cekAbsensi()==false) {
            return redirect()->route('pegawai')->with('error', 'Anda sudah melakukan absensi/cuti');
        }
        Absensi::create($validasi);
        return redirect()->route('pegawai')->with('success', 'Anda berhasil melakukan izin cuti');
    }

    public function lihatAkun(): View
    {
        $dataUser = User::select('name', 'nip', 'username', 'email')->where('id', Auth::user()->id)->get();
        // dd($dataUser[0]);
        return view('pegawai.akun', [
            "data" => $dataUser[0]
        ]);
    }

    public function updateAkun(Request $request): RedirectResponse
    {
        $validasi = $request->validate([
            "password" => "required"
        ]);

        $validasi['password'] = Hash::make($validasi['password']);
        User::where('id', Auth::user()->id)->update($validasi);


        return redirect()->route('pegawai')->with('success', 'Password telah diubah');
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
        }else{
            return true;
        }
    }
}

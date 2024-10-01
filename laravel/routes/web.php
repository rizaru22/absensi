<?php

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\AutoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardPegawaiController;
use App\Http\Controllers\LaporanController;
use App\Http\Middleware\IsPegawai;

Route::controller(LoginController::class)->group(function(){
    Route::get('/', 'index')->name('login');
    Route::post('/login', 'authenticate')->name('postlogin');
    Route::post('/logout',  'logout')->name('logout');
});

Route::get('/restricted', function () {
    return view('admin.restricted');
})->name('restricted');


Route::middleware(['auth',IsAdmin::class])->group(function () {
    
    Route::resource('/pengguna', UserController::class);

    Route::get('/admin', function () {
        return view('admin.dashboard', [
            "title" => "Dashboard"
        ]);
    })->name('admin');

    Route::controller(LaporanController::class)->group(function(){
        Route::get('/pilihtanggallh','pilihTanggalLH')->name('pilihtanggallh');
        Route::post('/laporanharian','laporanHarian')->name('laporanharian');
    
        Route::get('/pilihtanggallm','pilihTanggalLM')->name('pilihtanggallm');
        Route::post('/laporanmingguan','laporanMingguan')->name('laporanmingguan');
        
        Route::get('/pilihbulantahun','pilihBulanTahun')->name('pilihbulantahun');
        Route::post('/laporanbulanan','laporanBulanan')->name('laporanbulanan');
    
    });


});

Route::middleware(['auth',IsPegawai::class])->group(function () {


    Route::controller(DashboardPegawaiController::class)->group(function () {
        Route::get('/pegawai',  'index')->name('pegawai');
        Route::get('/faq',  'faq')->name('faq');
    });

    Route::get('/fotomasuk', function () {
        return view('pegawai.fotomasuk');
    })->name('fotomasuk');

    Route::get('/fotopulang', function () {
        return view('pegawai.fotopulang');
    })->name('fotopulang');

    Route::controller(AbsenController::class)->group(function () {
        Route::post('/kirimfotomasuk', 'kirimfotomasuk')->name('kirimfotomasuk');
        Route::post('/kirimfotopulang', 'kirimfotopulang')->name('kirimfotopulang');
        Route::post('/masuk', 'masuk')->name('masuk');
        Route::post('/pulang',  'pulang')->name('pulang');
        Route::get('/izin',  'izin')->name('izin');
        Route::post('/kirimizin', 'kirimizin')->name('kirimizin');
        Route::get('/akun', 'lihatAkun')->name('akun');
        Route::put('/updateAkun', 'updateAkun')->name('updateAkun');
    });
});

Route::controller(AutoController::class)->group(function () {
    Route::get('/autoMinggu',  'minggu');
    Route::get('/autoLibur',  'libur');
});

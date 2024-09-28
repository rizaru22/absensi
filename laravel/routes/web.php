<?php

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\AutoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardPegawaiController;
use App\Http\Controllers\LaporanController;

Route::controller(LoginController::class)->group(function(){
    Route::get('/', 'index')->name('login');
    Route::post('/login', 'authenticate')->name('postlogin');
});

Route::get('/restricted', function () {
    return view('admin.restricted');
})->name('restricted');

Route::middleware(IsAdmin::class)->group(function () {
    Route::resource('/pengguna', UserController::class);

    Route::get('/admin', function () {
        return view('admin.dashboard', [
            "title" => "Dashboard"
        ]);
    })->name('admin');

    Route::get('/pilihtanggallh',[LaporanController::class,'pilihTanggalLH'])->name('pilihtanggallh');
    Route::post('/laporanharian',[LaporanController::class,'laporanHarian'])->name('laporanharian');

    Route::get('/pilihtanggallm',[LaporanController::class,'pilihTanggalLM'])->name('pilihtanggallm');
    Route::post('/laporanmingguan',[LaporanController::class,'laporanMingguan'])->name('laporanmingguan');

});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

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

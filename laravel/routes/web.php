<?php

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\AutoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardPegawaiController;


Route::get('/generate', function(){
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    echo 'ok';
 });

Route::get('/',[LoginController::class,'index'])->name('login');
Route::post('/login',[LoginController::class,'authenticate'])->name('postlogin');

Route::get('/restricted',function(){
    return view('admin.restricted');
})->name('restricted');

Route::resource('/pengguna',UserController::class)->middleware(IsAdmin::class);

Route::get('/admin',function(){
    return view('admin.dashboard',[
        "title"=>"Dashboard"
    ]);
})->name('admin')->middleware(IsAdmin::class);


Route::post('logout',[LoginController::class,'logout'])->name('logout')->middleware('auth');

Route::get('/pegawai',[DashboardPegawaiController::class,'index'])->name('pegawai')->middleware('auth');

Route::get('/fotomasuk',function(){
    return view('pegawai.fotomasuk');
})->name('fotomasuk')->middleware('auth');
Route::post('/kirimfotomasuk',[AbsenController::class,'kirimfotomasuk'])->name('kirimfotomasuk')->middleware('auth');

Route::get('/fotopulang',function(){
    return view('pegawai.fotopulang');
})->name('fotopulang')->middleware('auth');

Route::post('/kirimfotopulang',[AbsenController::class,'kirimfotopulang'])->name('kirimfotopulang')->middleware('auth');

Route::post('/masuk',[AbsenController::class,'masuk'])->name('masuk')->middleware('auth');
Route::post('/pulang',[AbsenController::class,'pulang'])->name('pulang')->middleware('auth');

Route::get('/izin',[AbsenController::class,'izin'])->name('izin')->middleware('auth');
Route::post('/kirimizin',[AbsenController::class,'kirimizin'])->name('kirimizin')->middleware('auth');



Route::get('/autoMinggu',[AutoController::class,'minggu']);
Route::get('/autoLibur',[AutoController::class,'libur']);

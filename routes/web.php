<?php

use App\Http\Controllers\DashboardPegawaiController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsPegawai;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;

Route::get('/login',[LoginController::class,'index']);
Route::post('/login',[LoginController::class,'authenticate'])->name('login');


Route::resource('pengguna',UserController::class)->middleware(IsAdmin::class);
Route::get('/admin',function(){
    return view('admin.dashboard');
})->name('admin')->middleware(IsAdmin::class);
Route::post('logout',[LoginController::class,'logout'])->name('logout')->middleware('auth');

Route::get('/',[DashboardPegawaiController::class,'index'])->name('pegawai')->middleware('auth');


Route::get('/restricted',function(){
    return view('admin.restricted');
})->name('restricted');

// Route::get('/', function () {
//     return view('layouts.template');
// });

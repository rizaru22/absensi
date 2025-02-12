<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    //
    public function index():View
    {
        $pengaturan=Pengaturan::findOrFail(1);

        return view('admin.pengaturan.index',[
            "title"=>"Pengaturan",
            "data"=>$pengaturan
        ]);
    }

    public function update(Request $request, $id):RedirectResponse
    {
        $pengaturan=Pengaturan::findOrFail($id);
        $pengaturan->nama_instansi=$request->nama_instansi;
        $pengaturan->latitude=$request->latitude;
        $pengaturan->longitude=$request->longitude;
        $pengaturan->jarak_maksimal=$request->jarak_maksimal;
        $pengaturan->jam_masuk=$request->jam_masuk;
        $pengaturan->jam_maksimal_masuk=$request->jam_maksimal_masuk;
        $pengaturan->jam_pulang=$request->jam_pulang;
        $pengaturan->jam_maksimal_pulang=$request->jam_maksimal_pulang;
        $pengaturan->group_wa_id=$request->group_wa_id;
        $pengaturan->token=$request->token;
        $pengaturan->save();
        return redirect()->route('pengaturan.index')->with('success', 'Berhasil ubah data ');
    }
}

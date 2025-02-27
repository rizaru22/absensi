<?php

namespace App\Http\Controllers;

use App\Models\Libur;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LiburnasionalController extends Controller
{
    //
    public function index():View
    {
        $date=Carbon::now();
        // dd($date->year);
        $liburnasional=Libur::whereYear('tanggal',$date->year)
                                    ->orderBy('tanggal','asc')
                                    ->get();
        return view ('admin.liburnasional.index',[
            "title"=>"Libur Nasional",
            "data"=>$liburnasional
        ]);
    }
    public function create():View
    {
        return view('admin.liburnasional.create',[
            "title"=>"Libur Nasional"
        ]);
    }

    public function store(Request $request):RedirectResponse
    {
        $request->validate([
            'tanggal'=>"required",
            "kode"=>'required'
        ]);

        if(Libur::create($request->all())){
            return redirect()->route('liburnasional.index')->with('success','Berhasil menambahkan data');
        }else{
            return redirect()->route('liburnasional.index')->with('error','Gagal menambahkan data');
        }
    }

    public function edit(string $id) : View
    {
        $liburnasional=Libur::findOrFail($id);
        return view('admin.liburnasional.edit',[
            "title"=>"Libur Nasional",
            "data"=>$liburnasional
        ]);
    }

    public function update(Request $request,string $id):RedirectResponse
    {
        $libur=Libur::findOrFail($id);
        $libur->tanggal=$request->tanggal;
        $libur->kode=$request->kode;
        $libur->keterangan=$request->keterangan;

        if($libur->save()){
            return redirect()->route('liburnasional.index')->with('success','Berhasil merubah data');
        }else{
            return redirect()->route('liburnasional.index')->with('error','Gagal merubah data');
        }
    }

    public function destroy($id):RedirectResponse
    {

        if(Libur::where('id',$id)->delete()){
            return redirect()->route('liburnasional.index')->with('success','Berhasil hapus data');
        }else{
            return redirect()->route('liburnasional.index')->with('error','Gagal hapus data');
        }
    }

}

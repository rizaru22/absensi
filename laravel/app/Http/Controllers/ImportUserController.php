<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Promise\Each;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelReader;



class ImportUserController extends Controller
{
    public $data=array();
    //
    public function index():View
    {
        return view('admin.user.upload',[
            "title"=>"Pegawai",
        ]);
    }

    public function import(Request $request):RedirectResponse
    {
        $valid=$request->validate([
            "file"=>[
                "required",
                File::types(['xlsx','xls','csv'])
                ]
        ]);
        if ($valid){

            $valid['file'] = $request->file('file')->store('upload');

            $lokasi=Storage::disk('public')->path($valid['file']);
          
            $rows=SimpleExcelReader::create($lokasi)->getRows();
            $rows->each(function(array $rowProperties){
                $this->data[]=$rowProperties;
            });
            
            foreach ($this->data as $dt){
                $user=new User;
                $user->name=$dt['nama'];
                $user->username=strstr($dt['email'],'@',true);
                $user->nip=$dt['nip'];
                $user->email=$dt['email'];
                $user->password=Hash::make('1234');
                $user->role='user';
                $user->save();
            }
        }
        return redirect()->route('pengguna.index')->with('success','Berhasil Import Data Pengguna');
    }
}

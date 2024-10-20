<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function index(){
        $user=User::where('role','user')->orderBy('name')->get();
        return view('admin.user.index',[
            "title"=>"Pegawai",
            "data"=>$user
        ]);
    }

    public function create():View{
        return view('admin.user.create',[
            "title"=>"Pegawai"
        ]);
    }

    public function store(Request $request):RedirectResponse{
        $request->validate([
            "name"=>"required",
            "nip"=>"nullable",
            "email"=>"required",
        ]);
        $username=strstr($request->email,'@',true);
        $password=Hash::make('1234');
        $role='user';

        $request->merge([
            "username"=>$username,
            "password"=>$password,
            "role"=>$role
        ]);
        // dd($request);
        User::create($request->all());

        return redirect()->route('pengguna.index');

    }

    public function edit(string $id):View
    {
        $user=User::findOrFail($id);
        // dd($user);
        return view('admin.user.edit',compact('user'),[
            "title"=>"Pegawai"
        ]);
    }

    public function update(Request $request,$id):RedirectResponse
    {
        $username=strstr($request->email,'@',true);
        $user=User::findOrFail($id);
        $user->name=$request->name;
        $user->nip=$request->nip;
        $user->email=$request->email;
        $user->username=$username;
        $user->save();
        return redirect()->route('pengguna.index')->with('success', 'Berhasil ubah data '.$user->name);
    }

    public function reset(string $id)
    {
        $user=user::findOrFail($id);
        $user->password=Hash::make('1234');
        $user->save();
        return redirect()->route('pengguna.index')->with('success', 'Berhasil reset password '.$user->name);
    }
    


}

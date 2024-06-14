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
        return view('admin.user.index',[
            "data"=>User::all()
        ]);
    }

    public function create():View{
        return view('admin.user.create');
    }

    public function store(Request $request):RedirectResponse{
        $request->validate([
            "name"=>"required",
            "username"=>"required",
            "nip"=>"nullable",
            "email"=>"nullable",
            "password"=>"required",
        ]);

        $password=Hash::make($request->password);
        $role='user';

        $request->merge([
            "password"=>$password,
            "role"=>$role
        ]);

        User::create($request->all());

        return redirect()->route('pengguna.index');

    }

    public function show($id){
        $user=User::find($id);
        // dd($user->password);
        dd(Hash::check('321',$user->password));
        
    }
}

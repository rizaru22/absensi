<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //
    public function index(){
        return view('login.index');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // dd(Auth::attempt($credentials)) ;
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if(Auth::user()->role==='admin'){
                return redirect()->intended('admin');
                }else{
                return redirect()->route('pegawai');
            }
        }
 
        return back()->with('loginError','Login Failed');
    }

    public function logout(Request $request):RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}

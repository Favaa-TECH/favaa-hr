<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request){

        $credentials = $request->validate([
            'email' => ['required', 'email:dns'],
            'password' => ['required'],
        ]);


        if (Auth::attempt($credentials)) {
             $request->session()->regenerate();
            if (Auth::user()->role == 'Administrator'){
                return redirect()->intended('/');
            }elseif (Auth::user()->role == 'Employee'){
                return redirect()->intended('/empl-presence');
            }
        }


        return back()->with('login-fail', 'email atau password salah, silahkan coba lagi');
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login');

    }
}

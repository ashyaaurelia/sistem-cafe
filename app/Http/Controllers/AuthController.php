<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //Menampilkan halaman login 
    public function login()
    {
        return view('login');
    }

    //Memproses login
    public function prosesLogin(Request $request)
    {
        $data = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($data)) {

            if (Auth::user()->role == 'manajer'){
                return redirect('/manajer/dashboard');
            }

            if (Auth::user()->role == 'kasir') {
                return redirect('/kasir/dashboard');
            }
        }

        return back()->with('error', 'Username atau password salah.');
    }

    //logout
    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }
}

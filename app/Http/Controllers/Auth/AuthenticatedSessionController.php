<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // ambil user berdasarkan username
        $user = User::where('username', $request->username)->first();

        // cek manual (PLAINTEXT)
        if (!$user || $user->password !== $request->password) {
            return back()->withErrors([
                'username' => 'Username atau password salah'
            ]);
        }

        // login manual
        Auth::login($user);
        $request->session()->regenerate();

        // redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'petugas') {
            return redirect()->route('petugas.dashboard');
        }

       if ($user->role === 'peminjam') {
    return redirect()->route('user.dashboard');
}


    }
}

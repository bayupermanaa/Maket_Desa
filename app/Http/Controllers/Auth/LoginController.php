<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginMasyarakat(Request $request)
    {
        $request->validate([
            'nik_email' => 'required|string',
            'password'  => 'required|string',
        ]);

        $credentials = [
            filter_var($request->nik_email, FILTER_VALIDATE_EMAIL) ? 'email' : 'nik' => $request->nik_email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role === 'masyarakat') {
                return redirect('/dashboard')->with('success', 'Selamat datang, Warga Desa Makét!');
            }
        }

        return back()->withErrors([
            'nik_email' => 'NIK/Email atau password salah.',
        ]);
    }

    public function loginAdmin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
            return redirect('/dashboard')->with('success', 'Selamat datang, Admin Desa!');
        }

        return back()->withErrors(['username' => 'Username atau password salah.']);
    }

    public function loginKepalaDesa(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
            return redirect('/dashboard')->with('success', 'Selamat datang, Bapak Kepala Desa!');
        }

        return back()->withErrors(['username' => 'Username atau password salah.']);
    }
}
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
            'nik' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'nik' => $request->nik,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role === 'masyarakat') {
                session([
                    'role' => 'masyarakat',
                    'user_name' => $user->name,
                ]);

                return redirect()->route('dashboard.masyarakat')->with('success', 'Selamat datang, Warga Desa Maket!');
            }

            Auth::logout();
        }

        return back()->withErrors([
            'nik' => 'NIK atau password salah.',
        ]);
    }

    public function loginAdmin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
            $user = Auth::user();
            if ($user->role === 'admin_desa') {
                session([
                    'role' => 'admin_desa',
                    'user_name' => $user->name,
                ]);

                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, Admin Desa!');
            }

            Auth::logout();
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
            $user = Auth::user();
            if ($user->role === 'kepala_desa') {
                session([
                    'role' => 'kepala_desa',
                    'user_name' => $user->name,
                ]);

                return redirect()->route('kepala.dashboard')->with('success', 'Selamat datang, Bapak/Ibu Kepala Desa!');
            }

            Auth::logout();
        }

        return back()->withErrors(['username' => 'Username atau password salah.']);
    }
}

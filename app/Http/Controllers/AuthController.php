<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function indexSiswa()
    {
        return view('auth.login_siswa');
    }

    public function indexStaf()
    {
        return view('auth.login_staf');
    }

    // LOGIN SISWA
    public function logSiswa(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {

            // cek role
            if (Auth::user()->role !== 'siswa') {
                Auth::logout();
                return back()->with('error', 'Maaf, Anda tidak punya akses sebagai siswa.');
            }

            // login sukses siswa
            return redirect('/dashboard');
        }

        return back()->with('error', 'Email atau password salah.');
    }

    // LOGIN STAF
    public function logStaf(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {

            // cek role
            if (Auth::user()->role !== 'staf') {
                Auth::logout();
                return back()->with('error', 'Maaf, Anda tidak punya akses sebagai staf.');
            }

            // login sukses staf
            return redirect('admin/dashboard');
        }

        return back()->with('error', 'Email atau password salah.');
    }

    public function logoutSiswa(Request $request)
    {
        if (Auth::check() && Auth::user()->role === 'siswa') {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('success', 'Berhasil logout');
        }

        return redirect()->back()->with('error', 'Aksi tidak diizinkan');
    }

    public function logoutStaf(Request $request)
    {
        // Pastikan yang logout adalah staf
        if (Auth::check() && Auth::user()->role === 'staf') {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('success', 'Berhasil logout');
        }

        return redirect()->back()->with('error', 'Aksi tidak diizinkan');
    }
}

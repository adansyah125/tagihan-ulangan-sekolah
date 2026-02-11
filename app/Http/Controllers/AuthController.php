<?php

namespace App\Http\Controllers;

use Svg\Tag\Rect;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    // Auth Siswa
    public function indexSiswa()
    {
        return view('auth.login_siswa');
    }

    public function logSiswa(LoginRequest $request, AuthService $authService)
    {
        return $authService->login(
            $request->validated(),
            'siswa',
            '/dashboard'
        );
    }
    public function logoutSiswa(Request $request, AuthService $authService)
    {
        return $authService->logout(
            $request,
            'siswa',
            'login'
        );
    }

    // Auth Staf
    public function indexStaf()
    {
        return view('auth.login_staf');
    }
    public function logStaf(LoginRequest $request, AuthService $authService)
    {
        return $authService->login(
            $request->validated(),
            'staf',
            '/admin/dashboard'
        );
    }

    public function logoutStaf(Request $request, AuthService $authService)
    {
        return $authService->logout(
            $request,
            'staf',
            'login'
        );
    }

    public function regis()
    {
        $kelas = Kelas::all();
        return view('auth.register', compact('kelas'));
    }

    public function PostRegis(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'nis' => 'required',
            'alamat' => 'required',
            'telp' => 'required',
            'kelas_id' => 'required',
            'role' => 'siswa'
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email ini sudah digunakan, silakan pakai email lain.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nis' => $request->nis,
            'alamat' => $request->alamat,
            'telp' => $request->telp,
            'password' => Hash::make($request->password),
            'kelas_id' => $request->kelas_id,
            'role' => 'siswa'
        ]);

        return redirect('/login/siswa')->with('success', 'Registrasi Berhasil');
    }
}

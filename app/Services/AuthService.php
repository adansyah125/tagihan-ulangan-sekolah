<?php

namespace App\Services;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login(array $credentials, string $role, string $redirect)
    {
        if (! Auth::attempt($credentials)) {
            return back()->with('error', 'Email atau password salah.');
        }

        $user = Auth::user();

        if ($user->role !== $role) {
            Auth::logout();

            return back()->with('error', "Maaf, Anda tidak punya akses sebagai {$role}.");
        }

        return redirect()->intended($redirect);
    }

    public function logout(Request $request, string $role, string $redirect)
    {
        if (!Auth::check() || Auth::user()->role !== $role) {
            return redirect()->back()
                ->with('error', 'Aksi tidak diizinkan');
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route($redirect)
            ->with('success', 'Berhasil logout');
    }
}

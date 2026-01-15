<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Svg\Tag\Rect;

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
}

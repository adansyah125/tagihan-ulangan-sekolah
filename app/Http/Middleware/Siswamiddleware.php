<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Siswamiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('log_siswa')
                ->with('error', 'Silakan login sebagai siswa');
        }

        if (Auth::user()->role !== 'siswa') {
            Auth::logout();
            return redirect()->back()
                ->with('error', 'Maaf, Anda tidak punya akses');
        }

        return $next($request);
    }
}

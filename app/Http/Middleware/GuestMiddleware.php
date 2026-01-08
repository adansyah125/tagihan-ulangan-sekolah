<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (Auth::check()) {
            if ($role === 'staf' && Auth::user()->role === 'staf') {
                return redirect('/admin/dashboard');
            }

            if ($role === 'siswa' && Auth::user()->role === 'siswa') {
                return redirect('/dashboard');
            }

            // Auth::logout();
            return redirect()->back()
                ->with('error', 'Maaf, Anda tidak punya akses');
        }

        return $next($request);
    }
}

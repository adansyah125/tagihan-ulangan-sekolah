<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Stafmiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('log_staf')
                ->with('error', 'Silakan login sebagai staf');
        }

        if (Auth::user()->role !== 'staf') {
            Auth::logout();
            return redirect()->back()
                ->with('error', 'Maaf, Anda tidak punya akses');
        }

        return $next($request);
    }
}

<?php

use App\Http\Middleware\GuestMiddleware;
use App\Http\Middleware\Siswamiddleware;
use App\Http\Middleware\Stafmiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'staf' => Stafmiddleware::class,
            'siswa' => Siswamiddleware::class,
            'guest.login' => GuestMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

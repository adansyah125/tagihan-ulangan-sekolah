<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/login/siswa', [AuthController::class, 'indexSiswa'])->name('log_siswa')->middleware('guest.login:siswa');
Route::post('/login/siswa', [AuthController::class, 'logSiswa'])->name('PostLoginSiswa');
Route::post('/logout', [AuthController::class, 'logoutSiswa'])->name('logout');

Route::get('/login/staf', [AuthController::class, 'indexStaf'])->name('log_staf')->middleware('guest.login:staf');
Route::post('/login/staf', [AuthController::class, 'logStaf'])->name('PostLoginStaf');
Route::post('/logout/staf', [AuthController::class, 'logoutStaf'])->name('logout.staf');


Route::middleware(['auth', 'siswa'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
    Route::get('/pembayaran', function () {
        return view('pembayaran');
    });
});

Route::middleware(['auth', 'staf'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
    Route::get('/admin/siswa', function () {
        return view('admin.siswa');
    });
    Route::get('/admin/tagihan/uts', function () {
        return view('admin.tagihan.uts');
    });
    Route::get('/admin/tagihan/uas', function () {
        return view('admin.tagihan.uas');
    });

    Route::get('/admin/laporan/keuangan', function () {
        return view('admin.laporan.keuangan');
    });
    Route::get('/admin/laporan/tagihan', function () {
        return view('admin.laporan.tagihan');
    });
});

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\siswa\PaymentController as PaymentController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TagihanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/login/siswa', [AuthController::class, 'indexSiswa'])->name('log_siswa')->middleware('guest.login:siswa');
Route::post('/login/siswa', [AuthController::class, 'logSiswa'])->name('PostLoginSiswa');
Route::post('/logout', [AuthController::class, 'logoutSiswa'])->name('logout');

Route::get('/login/staf', [AuthController::class, 'indexStaf'])->name('log_staf')->middleware('guest.login:staf');
Route::post('/login/staf', [AuthController::class, 'logStaf'])->name('PostLoginStaf');
Route::post('/logout/staf', [AuthController::class, 'logoutStaf'])->name('logout.staf');


Route::middleware(['auth', 'siswa'])->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/payment/{kd_tagihan}', [PaymentController::class, 'show'])->name('payment');
    Route::post('payment/detail/{kd_tagihan}/bayar', [PaymentController::class, 'bayar'])->name('detail.bayar');
    Route::post('/payment/{kd_tagihan}/lunas', [PaymentController::class, 'markAsLunas'])->name('spp.markAsLunas');
});

Route::middleware(['auth', 'staf'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/siswa', [SiswaController::class, 'index'])->name('admin.siswa');
    Route::get('/admin/siswa/{user}', [SiswaController::class, 'show'])->name('admin.siswa.show');
    Route::post('/admin/siswa/store', [SiswaController::class, 'store'])->name('admin.siswa.store');
    Route::put('/admin/siswa/{user}', [SiswaController::class, 'update'])->name('admin.siswa.update');
    Route::delete('/admin/siswa/{user}/delete', [SiswaController::class, 'destroy'])->name('admin.siswa.destroy');
    Route::get('/admin/tagihan/uts', [TagihanController::class, 'indexUTS'])->name('admin.tagihan.uts');
    Route::post('/admin/tagihan/uts', [TagihanController::class, 'storeUTS'])->name('admin.tagihan.uts.store');
    Route::get('/admin/tagihan/uas', [TagihanController::class, 'indexUAS'])->name('admin.tagihan.uas');
    Route::post('/admin/tagihan/uas', [TagihanController::class, 'storeUAS'])->name('admin.tagihan.uas.store');
    Route::get('/admin/laporan/keuangan', [LaporanController::class, 'indexKeuangan'])->name('admin.laporan.keuangan');
    Route::get('/admin/laporan/tagihan', [LaporanController::class, 'indexLaporan'])->name('admin.laporan.tagihan');
});

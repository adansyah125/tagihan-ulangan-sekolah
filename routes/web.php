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

Route::get('/login/siswa/register', [AuthController::class, 'regis'])->name('register');
Route::post('/login/siswa/register', [AuthController::class, 'PostRegis'])->name('PostRegisterSiswa');
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
    Route::get('/cetak/{kd_tagihan}', [PaymentController::class, 'cetak'])->name('cetak');
});

Route::middleware(['auth', 'staf'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    // siswa
    Route::get('/admin/siswa', [SiswaController::class, 'index'])->name('admin.siswa');
    Route::get('/admin/siswa/{user}', [SiswaController::class, 'show'])->name('admin.siswa.show');
    Route::post('/admin/siswa/store', [SiswaController::class, 'store'])->name('admin.siswa.store');
    Route::put('/admin/siswa/{user}', [SiswaController::class, 'update'])->name('admin.siswa.update');
    Route::delete('/admin/siswa/{user}/delete', [SiswaController::class, 'destroy'])->name('admin.siswa.destroy');

    // tagihan 
    Route::get('/admin/tagihan/uts', [TagihanController::class, 'index'])->name('admin.tagihan.uts');
    Route::post('/admin/tagihan/uts', [TagihanController::class, 'store'])->name('admin.tagihan.uts.store');
    Route::delete('/admin/tagihan/uts/{id}/destroy', [TagihanController::class, 'destroy'])->name('tagihan.destroy');
    Route::post('/admin/tagihan/uts/akses/{id}', [TagihanController::class, 'buatDetailTagihan'])->name('admin.tagihan.uts.aktif');
    Route::post('/admin/tagihan/{tagihan}/toggle-status', [TagihanController::class, 'toggleStatus'])->name('admin.tagihan.toggle-status');

    // monitor pembayaran
    Route::get('/admin/tagihan/monitor', [TagihanController::class, 'monitor'])->name('admin.tagihan.monitor');
    Route::post('/admin/tagihan/monitor/{tagihan}/update', [TagihanController::class, 'updateBayar'])->name('admin.tagihan.monitor.update');


    // laporan
    Route::get('/admin/laporan/keuangan', [LaporanController::class, 'indexKeuangan'])->name('admin.laporan.keuangan');
    Route::get('/admin/laporan/tagihan', [LaporanController::class, 'indexLaporan'])->name('admin.laporan.tagihan');
    Route::get('/admin/laporan/cetak/{id}', [LaporanController::class, 'cetak'])->name('admin.laporan.cetak');
});
Route::get('/test-email', function () {
    $detail = App\Models\TagihanDetail::first();
    return new App\Mail\TagihanNotification($detail);
});

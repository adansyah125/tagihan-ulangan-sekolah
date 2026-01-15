<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Models\TagihanDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\LaporanService;

class LaporanController extends Controller
{
    public function indexKeuangan(Request $request, LaporanService $laporanService)
    {
        $statistik = $laporanService->getStatistikKeuangan();

        return view('admin.laporan.keuangan', [
            'data'             => $laporanService->getLaporanKeuangan($request->all()),
            'users'            => $laporanService->getSiswaList(),
            'siswaLunas'       => $statistik['siswaLunas'],
            'totalLunas'       => $statistik['totalLunas'],
            'totalbelumLunas'  => $statistik['totalbelumLunas'],
            'totalPendapatan'  => $statistik['totalPendapatan'],
        ]);
    }

    public function cetak($kd_pembayaran, LaporanService $laporanService)
    {
        $pdf = $laporanService->cetakBukti($kd_pembayaran);

        return $pdf->stream('Bukti-Pembayaran-' . $kd_pembayaran . '.pdf');
    }

    public function indexLaporan(LaporanService $laporanService)
    {
        $statistik = $laporanService->getStatistikTagihan();

        return view('admin.laporan.tagihan', [
            'data'             => $laporanService->getLaporanTagihan(),
            'BelumLunas'       => $statistik['BelumLunas'],
            'Lunas'            => $statistik['Lunas'],
            'totalbelumLunas'  => $statistik['totalbelumLunas'],
        ]);
    }
}

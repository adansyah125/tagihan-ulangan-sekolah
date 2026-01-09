<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\TagihanDetail;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function indexKeuangan()
    {
        $data = Pembayaran::latest()->get();
        $siswaLunas = Pembayaran::where('status_pembayaran', 'lunas')->count();
        $totalLunas = Pembayaran::where('status_pembayaran', 'lunas')->sum('jumlah_bayar');
        $totalbelumLunas = TagihanDetail::where('status', 'belum lunas')->sum('nominal');
        $totalPendapatan = Pembayaran::sum('jumlah_bayar');
        return view('admin.laporan.keuangan', compact('data', 'siswaLunas', 'totalLunas', 'totalbelumLunas', 'totalPendapatan'));
    }

    public function indexLaporan()
    {
        $data = TagihanDetail::where('status', 'belum lunas')->latest()->get();
        $BelumLunas = TagihanDetail::where('status', 'belum lunas')->count();
        $Lunas = TagihanDetail::where('status', 'lunas')->count();
        $totalbelumLunas = TagihanDetail::where('status', 'belum lunas')->sum('nominal');
        return view('admin.laporan.tagihan', compact('data', 'BelumLunas', 'totalbelumLunas', 'Lunas'));
    }
}

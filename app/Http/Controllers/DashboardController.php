<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Models\TagihanDetail;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $tagihan = TagihanDetail::count();
        $siswa = User::where('role', 'siswa')->count();
        $pembayaran = Pembayaran::select(
            DB::raw('SUM(jumlah_bayar) as total'),
            DB::raw("DATE_FORMAT(created_at, '%M') as bulan"),
            DB::raw("MONTH(created_at) as bulan_angka")
        )
            ->where('status_pembayaran', 'lunas')
            ->whereYear('created_at', date('Y')) // Filter tahun berjalan
            ->groupBy('bulan_angka', 'bulan')
            ->orderBy('bulan_angka', 'asc')
            ->get();

        // 2. Siapkan array untuk Chart.js
        $bulanLabels = $pembayaran->pluck('bulan')->toArray(); // Contoh: ["January", "February"]
        $dataNominal = $pembayaran->pluck('total')->toArray(); // Contoh: [500000, 750000]
        return view('admin.dashboard', compact('bulanLabels', 'dataNominal', 'tagihan', 'siswa'));
    }
}

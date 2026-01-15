<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Models\TagihanDetail;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function indexKeuangan(Request $request)
    {
        $query = Pembayaran::with(['user', 'tagihan', 'tagihanDetail']);

        //  FILTER JENIS TAGIHAN (UTS / UAS)
        if ($request->filled('jenis')) {
            $query->where('jenis_tagihan', $request->jenis);
        }

        //  FILTER USER / SISWA
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $data = $query
            ->latest('tgl_bayar')
            ->get();
        $users = User::where('role', 'siswa')->latest('name')->get();
        $siswaLunas = Pembayaran::where('status_pembayaran', 'lunas')->count();
        $totalLunas = Pembayaran::where('status_pembayaran', 'lunas')->sum('jumlah_bayar');
        $totalbelumLunas = TagihanDetail::where('status', 'belum lunas')->sum('nominal');
        $totalPendapatan = Pembayaran::sum('jumlah_bayar');
        return view('admin.laporan.keuangan', compact('data', 'users', 'siswaLunas', 'totalLunas', 'totalbelumLunas', 'totalPendapatan'));
    }

    public function indexLaporan()
    {
        $data = TagihanDetail::where('status', 'belum lunas')->latest()->get();
        $data->each(function ($item) {
            $phone = preg_replace('/^0/', '62', $item->user->telp ?? '');

            $tglTagihan = Carbon::parse($item->tgl_tagihan)
                ->locale('id')
                ->translatedFormat('d F Y');

            $jatuhTempo = Carbon::parse($item->jatuh_tempo)
                ->locale('id')
                ->translatedFormat('d F Y');

            $item->wa_link = "https://wa.me/{$phone}?text=" . urlencode(
                "Halo {$item->user->name},\n\n" .
                    "Kami mengingatkan bahwa Anda memiliki tagihan dengan rincian berikut:\n\n" .
                    "Jenis Tagihan : {$item->jenis_tagihan}\n" .
                    "Nominal       : Rp " . number_format($item->nominal, 0, ',', '.') . "\n" .
                    "Periode       : {$tglTagihan} s/d {$jatuhTempo}\n\n" .
                    "Harap segera melakukan pembayaran sebelum tenggat waktu yang ditentukan.\n\n" .
                    "Terima kasih.\n\n" .
                    "Hormat kami,\n" .
                    "Admin Sistem Tagihan\n" .
                    "Sekolah Dharma Agung"
            );
        });

        $BelumLunas = TagihanDetail::where('status', 'belum lunas')->count();
        $Lunas = TagihanDetail::where('status', 'lunas')->count();
        $totalbelumLunas = TagihanDetail::where('status', 'belum lunas')->sum('nominal');
        return view('admin.laporan.tagihan', compact('data', 'BelumLunas', 'totalbelumLunas', 'Lunas'));
    }

    public function cetak($kd_pembayaran)
    {
        $tagihan = Pembayaran::with(['user', 'tagihan', 'kelas'])
            ->where('kd_pembayaran', $kd_pembayaran)
            ->firstOrFail();

        $pdf = Pdf::loadView('admin.pdf.bukti-pembayaran', compact('tagihan'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('Bukti-Pembayaran-' . $kd_pembayaran . '.pdf');
    }
}

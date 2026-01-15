<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Pembayaran;
use App\Models\TagihanDetail;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanService
{
    public function getLaporanKeuangan(array $filter)
    {
        $query = Pembayaran::with(['user', 'tagihan', 'tagihanDetail']);

        if (!empty($filter['jenis'])) {
            $query->where('jenis_tagihan', $filter['jenis']);
        }

        if (!empty($filter['user_id'])) {
            $query->where('user_id', $filter['user_id']);
        }

        return $query->latest('tgl_bayar')->get();
    }

    public function getSiswaList()
    {
        return User::where('role', 'siswa')
            ->latest('name')
            ->get();
    }

    public function getStatistikKeuangan(): array
    {
        return [
            'siswaLunas'       => Pembayaran::where('status_pembayaran', 'lunas')->count(),
            'totalLunas'       => Pembayaran::where('status_pembayaran', 'lunas')->sum('jumlah_bayar'),
            'totalbelumLunas'  => TagihanDetail::where('status', 'belum lunas')->sum('nominal'),
            'totalPendapatan'  => Pembayaran::sum('jumlah_bayar'),
        ];
    }

    public function cetakBukti(string $kd_pembayaran)
    {
        $tagihan = Pembayaran::with(['user', 'tagihan', 'kelas'])
            ->where('kd_pembayaran', $kd_pembayaran)
            ->firstOrFail();

        return Pdf::loadView('admin.pdf.bukti-pembayaran', compact('tagihan'))
            ->setPaper('A4', 'portrait');
    }

    public function getLaporanTagihan()
    {
        $data = TagihanDetail::with('user')
            ->where('status', 'belum lunas')
            ->latest()
            ->get();

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

        return $data;
    }

    public function getStatistikTagihan(): array
    {
        return [
            'BelumLunas'      => TagihanDetail::where('status', 'belum lunas')->count(),
            'Lunas'           => TagihanDetail::where('status', 'lunas')->count(),
            'totalbelumLunas' => TagihanDetail::where('status', 'belum lunas')->sum('nominal'),
        ];
    }
}

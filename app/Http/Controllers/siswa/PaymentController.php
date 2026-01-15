<?php

namespace App\Http\Controllers\siswa;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use App\Models\TagihanDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\MidtransService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function show()
    {
        $tagihan = TagihanDetail::where('user_id', Auth::id())->where('kd_tagihan', request('kd_tagihan'))->first();
        return view('pembayaran', compact('tagihan'));
    }

    protected MidtransService $midtrans_service;

    public function __construct(MidtransService $midtrans_service)
    {
        $this->midtrans_service = $midtrans_service;
    }

    public function bayar($kd_tagihan)
    {
        try {
            $snapToken = $this->midtrans_service->createSnapToken($kd_tagihan);

            return response()->json([
                'snapToken' => $snapToken
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function markAsLunas($kd_tagihan)
    {
        $this->midtrans_service->markAsLunas($kd_tagihan);

        return response()->json([
            'message' => 'Status diperbarui menjadi lunas'
        ]);
    }

    public function cetak($kd_tagihan)
    {
        $tagihan = TagihanDetail::with(['user', 'kelas'])
            ->where('kd_tagihan', $kd_tagihan)
            ->firstOrFail();

        $pdf = Pdf::loadView('pdf.bukti-pembayaran', compact('tagihan'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('Bukti-Pembayaran-' . $kd_tagihan . '.pdf');
    }
}

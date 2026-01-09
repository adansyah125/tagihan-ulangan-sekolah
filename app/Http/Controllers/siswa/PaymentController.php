<?php

namespace App\Http\Controllers\siswa;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use App\Models\TagihanDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function show()
    {
        $tagihan = TagihanDetail::where('user_id', Auth::id())->where('kd_tagihan', request('kd_tagihan'))->first();
        return view('pembayaran', compact('tagihan'));
    }

    public function bayar($kd_tagihan)
    {
        try {
            $tagihan = TagihanDetail::with('user')
                ->where('kd_tagihan', $kd_tagihan)
                ->firstOrFail();

            Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $tagihan->kd_tagihan . '-' . time(),
                    'gross_amount' => (int) $tagihan->nominal,
                ],
                'customer_details' => [
                    'first_name' => $tagihan->user->name,
                    'email' => $tagihan->user->email ?? 'noemail@example.com',
                    'phone' => '08123456789',
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'snapToken' => $snapToken
            ]);
        } catch (\Exception $e) {
            \Log::error('Midtrans Error', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }




    public function markAsLunas($kd_tagihan)
    {
        $tagihan = TagihanDetail::where('kd_tagihan', $kd_tagihan)->firstOrFail();
        $tagihan->status = 'lunas';
        $tagihan->save();

        return response()->json(['message' => 'Status diperbarui menjadi lunas']);
    }
}

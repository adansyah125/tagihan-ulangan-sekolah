<?php

namespace App\Services;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Pembayaran;
use App\Models\TagihanDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    public function createSnapToken(string $kd_tagihan): string
    {
        try {
            $tagihan = TagihanDetail::with('user')
                ->where('kd_tagihan', $kd_tagihan)
                ->firstOrFail();

            // Konfigurasi Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $tagihan->kd_tagihan . '-' . time(),
                    'gross_amount' => (int) $tagihan->nominal,
                ],
                'customer_details' => [
                    'first_name' => $tagihan->user->name,
                    'email' => $tagihan->user->email ?? 'noemail@example.com',
                    'phone' => $tagihan->user->no_telp ?? '08123456789',
                ],
            ];

            return Snap::getSnapToken($params);
        } catch (\Exception $e) {
            Log::error('Midtrans Error', [
                'kd_tagihan' => $kd_tagihan,
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public function markAsLunas(string $kd_tagihan): void
    {
        DB::transaction(function () use ($kd_tagihan) {

            $tagihan = TagihanDetail::where('kd_tagihan', $kd_tagihan)
                ->firstOrFail();

            // Update status tagihan
            $tagihan->update([
                'status' => 'lunas'
            ]);

            // Simpan pembayaran
            Pembayaran::create([
                'user_id'          => $tagihan->user_id,
                'tagihan_id'       => $tagihan->id,
                'kd_pembayaran'    => 'ORD' . rand(1000000, 9999999),
                'tgl_bayar'        => now(),
                'jenis_tagihan'    => $tagihan->jenis_tagihan,
                'jumlah_bayar'     => $tagihan->nominal,
                'status_pembayaran' => 'lunas',
            ]);
        });
    }
}

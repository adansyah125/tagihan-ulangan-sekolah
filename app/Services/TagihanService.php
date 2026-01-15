<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use Illuminate\Support\Str;
use App\Models\TagihanDetail;
use Illuminate\Support\Facades\DB;

class TagihanService
{

    public function storeUTS(array $data): void
    {
        Tagihan::create([
            'tahun_ajaran' => $data['tahun_ajaran'],
            'jenis_tagihan' => $data['jenis_tagihan'],
            'nominal' => $data['nominal'],
            'tgl_tagihan' => $data['tgl_tagihan'],
            'jatuh_tempo' => $data['jatuh_tempo'],
            'akses' => 'siswa',
            'status' => 'Tutup'
        ]);
    }



    public function buatTagihan(array $data): void
    {
        DB::transaction(function () use ($data) {

            // ❌ Cegah tagihan UTS dobel
            $exists = Tagihan::where('jenis_tagihan', 'UTS')
                ->where('tahun_ajaran', $data['tahun_ajaran'])
                ->where('akses', $data['akses'])
                ->when(
                    $data['akses'] === 'kelas',
                    fn($q) =>
                    $q->where('kelas_id', $data['kelas_id'])
                )
                ->when(
                    $data['akses'] === 'siswa',
                    fn($q) =>
                    $q->where('user_id', $data['user_id'])
                )
                ->exists();

            if ($exists) {
                throw new \DomainException('Tagihan UTS sudah dibuat.');
            }

            // 🧾 Buat tagihan utama
            $tagihan = Tagihan::create([
                'jenis_tagihan' => 'UTS',
                'akses'         => $data['akses'], // siswa | kelas | semua
                'kelas_id'      => $data['kelas_id'] ?? null,
                'user_id'       => $data['user_id'] ?? null,
                'nominal'       => $data['nominal'],
                'tahun_ajaran'  => $data['tahun_ajaran'],
                'tgl_tagihan'   => $data['tgl_tagihan'],
                'jatuh_tempo'   => $data['jatuh_tempo'],
                'status'        => 'Buka',
            ]);

            // 🔎 Tentukan target siswa
            $siswas = match ($data['akses']) {
                'siswa' => User::where('id', $data['user_id'])->get(),

                'kelas' => User::where('role', 'siswa')
                    ->where('kelas_id', $data['kelas_id'])
                    ->get(),

                'semua' => User::where('role', 'siswa')->get(),
            };

            if ($siswas->isEmpty()) {
                throw new \DomainException('Data siswa tidak ditemukan.');
            }

            // 🧾 Buat detail tagihan
            foreach ($siswas as $siswa) {
                TagihanDetail::create([
                    'tagihan_id'   => $tagihan->id,
                    'user_id'      => $siswa->id,
                    'kelas_id'     => $siswa->kelas_id,
                    'kd_tagihan'   => strtoupper(str()->random(12)),
                    'nominal'      => $data['nominal'],
                    'jenis_tagihan' => $data['jenis_tagihan'],
                    'tgl_tagihan'  => $data['tgl_tagihan'],
                    'jatuh_tempo'  => $data['jatuh_tempo'],
                    'status'       => 'belum lunas',
                ]);
            }
        });
    }

    public function updatePembayaran(TagihanDetail $tagihan): void
    {
        DB::transaction(function () use ($tagihan) {

            if ($tagihan->status === 'lunas') {

                // 🔴 BALIK KE BELUM LUNAS
                $tagihan->update([
                    'status' => 'belum lunas'
                ]);

                // Hapus data pembayaran
                Pembayaran::where('tagihan_id', $tagihan->id)
                    ->where('user_id', $tagihan->user_id)
                    ->delete();
            } else {

                // 🟢 JADI LUNAS
                $tagihan->update([
                    'status' => 'lunas'
                ]);

                // Simpan pembayaran
                Pembayaran::create([
                    'user_id'           => $tagihan->user_id,
                    'tagihan_id'        => $tagihan->id,
                    'kd_pembayaran'     => 'PAY-' . strtoupper(Str::random(8)),
                    'jenis_tagihan'     => $tagihan->jenis_tagihan,
                    'tgl_bayar'         => now(),
                    'jumlah_bayar'      => $tagihan->nominal,
                    'status_pembayaran' => 'lunas',
                ]);
            }
        });
    }
}

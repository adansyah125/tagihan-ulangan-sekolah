<?php

namespace App\Services;

use App\Models\Tagihan;
use App\Models\TagihanDetail;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TagihanService
{

    public function storeUTS(array $data): void
    {
        // DB::transaction(function () use ($data) {

        //     // 🔎 Ambil hanya user dengan role siswa
        //     $siswas = User::where('role', 'siswa')
        //         ->select('id')
        //         ->get();

        //     if ($siswas->isEmpty()) {
        //         throw new \DomainException('Tidak ada data siswa.');
        //     }

        //     // ❌ Cegah tagihan UTS dobel
        //     $exists = Tagihan::where('jenis_tagihan', 'UTS')
        //         ->where('tahun_ajaran', $data['tahun_ajaran'])
        //         ->exists();

        //     if ($exists) {
        //         throw new \DomainException(
        //             'Tagihan UTS untuk tahun ajaran ini sudah dibuka.'
        //         );
        //     }
        Tagihan::create([
            'tahun_ajaran' => $data['tahun_ajaran'],
            'jenis_tagihan' => $data['jenis_tagihan'],
            'nominal' => $data['nominal'],
            'tgl_tagihan' => $data['tgl_tagihan'],
            'jatuh_tempo' => $data['jatuh_tempo'],
            'akses' => 'siswa',
            'status' => 'Tutup'
        ]);

        // 🧾 Buat tagihan untuk seluruh siswa
        // foreach ($siswas as $siswa) {
        //     $tagihan = Tagihan::where('jenis_tagihan', 'UTS')->select('id')->first();
        //     TagihanDetail::create([
        //         'user_id' => $siswa->id, // siswa penerima tagihan
        //         'tagihan_id' => $tagihan->id,
        //         'kd_tagihan'  => str()->random(12),
        //         'jenis_tagihan' => 'UTS',
        //         'nominal' => $data['nominal'],
        //         'tahun_ajaran' => $data['tahun_ajaran'],
        //         'tgl_tagihan' => $data['tgl_tagihan'],
        //         'jatuh_tempo' => $data['jatuh_tempo'],
        //         'status' => 'belum lunas',
        //     ]);
        // }
        // });

        // buat tagihan untuk per kelas dari tabel user

        // buat tagihan untuk per siswa

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
}

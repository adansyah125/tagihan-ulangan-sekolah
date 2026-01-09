<?php

namespace App\Services;

use App\Models\Tagihan;
use App\Models\TagihanDetail;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TagihanService
{
    public function buatTagihanUTS(array $data): void
    {
        DB::transaction(function () use ($data) {

            // 🔎 Ambil hanya user dengan role siswa
            $siswas = User::where('role', 'siswa')
                ->select('id')
                ->get();

            if ($siswas->isEmpty()) {
                throw new \DomainException('Tidak ada data siswa.');
            }

            // ❌ Cegah tagihan UTS dobel
            $exists = Tagihan::where('jenis_tagihan', 'uts')
                ->where('tahun_ajaran', $data['tahun_ajaran'])
                ->exists();

            if ($exists) {
                throw new \DomainException(
                    'Tagihan UTS untuk tahun ajaran ini sudah dibuka.'
                );
            }
            Tagihan::create([
                'jenis_tagihan' => 'uts',
                'nominal' => $data['nominal'],
                'tahun_ajaran' => $data['tahun_ajaran'],
                'tgl_tagihan' => $data['tgl_tagihan'],
                'jatuh_tempo' => $data['jatuh_tempo'],
            ]);

            // 🧾 Buat tagihan untuk setiap siswa
            foreach ($siswas as $siswa) {
                $tagihan = Tagihan::where('jenis_tagihan', 'uts')->select('id')->first();
                TagihanDetail::create([
                    'user_id' => $siswa->id, // siswa penerima tagihan
                    'tagihan_id' => $tagihan->id,
                    'kd_tagihan'  => str()->random(12),
                    'jenis_tagihan' => 'uts',
                    'nominal' => $data['nominal'],
                    'tahun_ajaran' => $data['tahun_ajaran'],
                    'tgl_tagihan' => $data['tgl_tagihan'],
                    'jatuh_tempo' => $data['jatuh_tempo'],
                    'status' => 'belum lunas',
                ]);
            }
        });
    }

    public function buatTagihanUAS(array $data): void
    {
        DB::transaction(function () use ($data) {

            // 🔎 Ambil hanya user dengan role siswa
            $siswas = User::where('role', 'siswa')
                ->select('id')
                ->get();

            if ($siswas->isEmpty()) {
                throw new \DomainException('Tidak ada data siswa.');
            }

            // ❌ Cegah tagihan UTS dobel
            $exists = Tagihan::where('jenis_tagihan', 'uas')
                ->where('tahun_ajaran', $data['tahun_ajaran'])
                ->exists();

            if ($exists) {
                throw new \DomainException(
                    'Tagihan UAS untuk tahun ajaran ini sudah dibuka.'
                );
            }
            Tagihan::create([
                'jenis_tagihan' => 'uas',
                'nominal' => $data['nominal'],
                'tahun_ajaran' => $data['tahun_ajaran'],
                'tgl_tagihan' => $data['tgl_tagihan'],
                'jatuh_tempo' => $data['jatuh_tempo'],
            ]);

            // 🧾 Buat tagihan untuk setiap siswa
            foreach ($siswas as $siswa) {
                $tagihan = Tagihan::where('jenis_tagihan', 'uas')->select('id')->first();
                TagihanDetail::create([
                    'user_id' => $siswa->id, // siswa penerima tagihan
                    'tagihan_id' => $tagihan->id,
                    'kd_tagihan'  => str()->random(12),
                    'jenis_tagihan' => 'uas',
                    'nominal' => $data['nominal'],
                    'tahun_ajaran' => $data['tahun_ajaran'],
                    'tgl_tagihan' => $data['tgl_tagihan'],
                    'jatuh_tempo' => $data['jatuh_tempo'],
                    'status' => 'belum lunas',
                ]);
            }
        });
    }
}

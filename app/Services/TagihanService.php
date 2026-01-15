<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use DomainException;
use App\Models\Kelas;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use Illuminate\Support\Str;
use App\Models\TagihanDetail;
use App\Mail\TagihanNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TagihanService
{
    public function getTagihanList()
    {
        return Tagihan::query()
            ->select([
                'id',
                'jenis_tagihan',
                'tahun_ajaran',
                'nominal',
                'tgl_tagihan',
                'jatuh_tempo',
                'status',
            ])
            ->groupBy([
                'id',
                'jenis_tagihan',
                'tahun_ajaran',
                'nominal',
                'tgl_tagihan',
                'jatuh_tempo',
                'status',
            ])
            ->latest('tahun_ajaran')
            ->get();
    }

    public function getSiswaList()
    {
        return User::query()
            ->where('role', 'siswa')
            ->oldest('name')
            ->get();
    }

    public function getAllKelas()
    {
        return Kelas::all();
    }

    public function store(array $data): void
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

    public function buatDetailTagihan(int $tagihanId, array $data): int
    {
        return DB::transaction(function () use ($tagihanId, $data) {

            $tagihan = Tagihan::findOrFail($tagihanId);

            $siswas = $this->getTargetSiswa(
                $data['akses_pilihan'],
                $data['user_id'] ?? null,
                $data['kelas_id'] ?? null
            );

            if ($siswas->isEmpty()) {
                throw new DomainException('Tidak ada siswa ditemukan');
            }

            foreach ($siswas as $siswa) {
                $detail = TagihanDetail::updateOrCreate(
                    [
                        'tagihan_id' => $tagihan->id,
                        'user_id'    => $siswa->id,
                    ],
                    [
                        'kelas_id'      => $siswa->kelas_id,
                        'kd_tagihan'    => $this->generateKodeTagihan(),
                        'nominal'       => $tagihan->nominal,
                        'jenis_tagihan' => $tagihan->jenis_tagihan,
                        'tgl_tagihan'   => $tagihan->tgl_tagihan,
                        'jatuh_tempo'   => $tagihan->jatuh_tempo,
                        'status'        => 'belum lunas',
                    ]
                );

                $this->kirimEmailJikaAda($siswa->email, $detail);
            }

            return $siswas->count();
        });
    }

    private function getTargetSiswa(string $jangkauan, ?int $userId, ?int $kelasId)
    {
        $query = User::where('role', 'siswa');

        return match ($jangkauan) {
            'siswa' => $query->where('id', $userId)->get(),
            'kelas' => $query->where('kelas_id', $kelasId)->get(),
            default => $query->get(),
        };
    }

    private function generateKodeTagihan(): string
    {
        return 'TRX-' . strtoupper(Str::random(8));
    }

    private function kirimEmailJikaAda(?string $email, TagihanDetail $detail): void
    {
        if ($email) {
            Mail::to($email)->queue(new TagihanNotification($detail));
        }
    }

    public function toggleStatus(Tagihan $tagihan): string
    {
        $statusBaru = $tagihan->status === 'Buka' ? 'Tutup' : 'Buka';

        $tagihan->update([
            'status' => $statusBaru,
        ]);

        return $statusBaru;
    }


    public function getMonitorTagihan(?string $search, int $perPage = 10)
    {
        return TagihanDetail::with(['user', 'kelas'])
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('kd_tagihan', 'like', "%{$search}%")
                        ->orWhere('jenis_tagihan', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($u) use ($search) {
                            $u->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('kelas', function ($k) use ($search) {
                            $k->where('kelas', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
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

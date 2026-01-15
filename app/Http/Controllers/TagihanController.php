<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Tagihan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TagihanDetail;
use App\Services\TagihanService;
use App\Mail\TagihanNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreTagihanRequest;

class TagihanController extends Controller
{

    public function indexUTS()
    {
        $data = Tagihan::select(
            'id',
            'jenis_tagihan',
            'tahun_ajaran',
            'nominal',
            'tgl_tagihan',
            'jatuh_tempo',
            'status'
        )
            ->groupBy(
                'id',
                'jenis_tagihan',
                'tahun_ajaran',
                'nominal',
                'tgl_tagihan',
                'jatuh_tempo',
                'status'
            )
            ->latest('tahun_ajaran')
            ->get();
        $siswas = User::where('role', 'siswa')->oldest('name')->get();
        $kelas = Kelas::all();
        return view('admin.tagihan.tagihan', compact('data', 'siswas', 'kelas'));
    }

    public function storeUTS(StoreTagihanRequest $request, TagihanService $tagihanService)
    {
        try {
            $tagihanService->storeUTS($request->validated());

            return back()->with(
                'success',
                'Tagihan UTS berhasil dibuat'
            );
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function destroy(Tagihan $id)
    {
        Tagihan::where('id', $id->id)->delete();
        return back()->with('success', 'Tagihan berhasil dihapus');
    }

    public function buatDetailTagihan(Request $request, $id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $jangkauan = $request->akses_pilihan; // siswa | kelas | semua

        $querySiswa = User::where('role', 'siswa');

        if ($jangkauan === 'siswa') {
            $querySiswa->where('id', $request->user_id);
        } elseif ($jangkauan === 'kelas') {
            $querySiswa->where('kelas_id', $request->kelas_id);
        }

        $siswas = $querySiswa->get();

        if ($siswas->isEmpty()) {
            return back()->with('error', 'Tidak ada siswa ditemukan');
        }

        foreach ($siswas as $siswa) {
            $detail = TagihanDetail::updateOrCreate(
                [
                    'tagihan_id' => $tagihan->id,
                    'user_id'    => $siswa->id,
                ],
                [
                    'kelas_id'      => $siswa->kelas_id,
                    'kd_tagihan'    => 'TRX-' . strtoupper(Str::random(8)),
                    'nominal'       => $tagihan->nominal,
                    'jenis_tagihan' => $tagihan->jenis_tagihan,
                    'tgl_tagihan'   => $tagihan->tgl_tagihan,
                    'jatuh_tempo'   => $tagihan->jatuh_tempo,
                    'status'        => 'belum lunas',
                ]
            );

            if ($siswa->email) {
                Mail::to($siswa->email)->queue(new TagihanNotification($detail));
            }
        }

        return back()->with('success', 'Tagihan berhasil dibuat untuk ' . $siswas->count() . ' siswa');
    }



    public function toggleStatus(Tagihan $tagihan)
    {
        $tagihan->update([
            'status' => $tagihan->status === 'Buka' ? 'Tutup' : 'Buka'
        ]);

        return back()->with(
            'success',
            $tagihan->status === 'Buka'
                ? 'Tagihan berhasil dibuka'
                : 'Tagihan berhasil ditutup'
        );
    }


    //Monitor pembayaran
    public function monitor(Request $request)
    {
        $search = $request->search;

        $data = TagihanDetail::with(['user', 'kelas'])
            ->when($search, function ($q) use ($search) {
                $q->where('kd_tagihan', 'like', "%$search%")
                    ->orWhere('jenis_tagihan', 'like', "%$search%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    })
                    ->orWhereHas('kelas', function ($q) use ($search) {
                        $q->where('kelas', 'like', "%$search%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
        return view('admin.tagihan.monitor', compact('data'));
    }

    public function updateBayar(TagihanDetail $tagihan, TagihanService $service)
    {

        $service->updatePembayaran($tagihan);

        return back()->with('success', 'Pembayaran berhasil diperbarui');
    }
}

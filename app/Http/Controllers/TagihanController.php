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

    public function akses($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        return view('admin.tagihan.form', compact('tagihan'));
    }


    public function destroy(Tagihan $id)
    {
        Tagihan::where('id', $id->id)->delete();
        return back()->with('success', 'Tagihan berhasil dihapus');
    }

    // public function updateAkses(Request $request, $id)
    // {
    //     $tagihan = Tagihan::findOrFail($id);
    //     $statusBaru = $request->status; // 'Buka' atau 'Tutup'
    //     $jangkauan = $request->akses_pilihan; // 'siswa', 'kelas', atau 'semua'

    //     // 1. Update status dan jangkauan di tabel utama
    //     $tagihan->update([
    //         'status' => $statusBaru,
    //         'akses' => $jangkauan
    //     ]);

    //     // 2. Jika status dibuka, buat detail tagihan untuk siswa
    //     if ($statusBaru == 'Buka') {
    //         $querySiswa = User::where('role', 'siswa');

    //         if ($jangkauan == 'siswa') {
    //             $querySiswa->where('id', $tagihan->user_id);
    //         } elseif ($jangkauan == 'kelas') {
    //             $querySiswa->where('kelas_id', $tagihan->kelas_id);
    //         }

    //         $siswas = $querySiswa->get();

    //         foreach ($siswas as $siswa) {
    //             // Menggunakan updateOrCreate agar tidak terjadi duplikasi data
    //             TagihanDetail::updateOrCreate(
    //                 [
    //                     'tagihan_id' => $tagihan->id,
    //                     'user_id'    => $siswa->id
    //                 ],
    //                 // Jika belum ada/ingin diupdate, isi kolom-kolom berikut:
    //                 [
    //                     'kelas_id'      => $siswa->kelas_id, // Diambil dari data siswa
    //                     'kd_tagihan'    => Str::random(8), // Pastikan di Master ada kd_tagihan
    //                     'nominal'       => $tagihan->nominal,
    //                     'jenis_tagihan' => $tagihan->jenis_tagihan,
    //                     'tgl_tagihan'   => $tagihan->tgl_tagihan,
    //                     'jatuh_tempo'   => $tagihan->jatuh_tempo,
    //                     'status'        => 'belum lunas', // Status awal di level detail
    //                 ]
    //             );
    //         }

    //         return redirect()->back()->with('success', "Akses dibuka untuk " . $siswas->count() . " siswa.");
    //     }

    //     return redirect()->back()->with('success', "Akses tagihan telah ditutup.");
    // }

    public function updateAkses(Request $request, $id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $statusBaru = $request->status; // 'Buka' atau 'Tutup'
        $jangkauan = $request->akses_pilihan; // 'siswa', 'kelas', atau 'semua'

        // 1. Update status dan jangkauan di tabel utama
        $tagihan->update([
            'status' => $statusBaru,
            'akses' => $jangkauan
        ]);

        // 2. Jika status dibuka, buat detail tagihan untuk siswa
        if ($statusBaru == 'Buka') {
            $querySiswa = User::where('role', 'siswa');

            if ($jangkauan == 'siswa') {
                // AMBIL DARI REQUEST (HASIL PILIHAN SELECT DI MODAL)
                $querySiswa->where('id', $request->user_id);
            } elseif ($jangkauan == 'kelas') {
                // AMBIL DARI REQUEST (HASIL PILIHAN SELECT DI MODAL)
                $querySiswa->where('kelas_id', $request->kelas_id);
            }

            $siswas = $querySiswa->get();

            if ($siswas->isEmpty()) {
                return redirect()->back()->with('error', "Tidak ada siswa ditemukan.");
            }

            foreach ($siswas as $siswa) {
                $detail =  TagihanDetail::updateOrCreate(
                    [
                        'tagihan_id' => $tagihan->id,
                        'user_id'    => $siswa->id
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
                    sleep(2);
                }
            }

            return redirect()->back()->with('success', "Akses dibuka untuk " . $siswas->count() . " siswa.");
        }

        return redirect()->back()->with('success', "Akses tagihan telah ditutup.");
    }

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
}

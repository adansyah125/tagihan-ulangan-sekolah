<?php

namespace App\Http\Controllers;

use App\Models\User;
use DomainException;
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
    public function index(TagihanService $tagihanService)
    {
        return view('admin.tagihan.tagihan', [
            'data'   => $tagihanService->getTagihanList(),
            'siswas' => $tagihanService->getSiswaList(),
            'kelas'  => $tagihanService->getAllKelas(),
        ]);
    }

    public function store(StoreTagihanRequest $request, TagihanService $tagihanService)
    {
        try {
            $tagihanService->store($request->validated());

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

    public function buatDetailTagihan(Request $request, int $id, TagihanService $tagihanService)
    {
        try {
            $jumlah = $tagihanService->buatDetailTagihan($id, $request->all());

            return back()->with(
                'success',
                "Tagihan berhasil dibuat untuk {$jumlah} siswa"
            );
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function toggleStatus(Tagihan $tagihan, TagihanService $tagihanService)
    {
        $status =  $tagihanService->toggleStatus($tagihan);

        return back()->with(
            'success',
            $status === 'Buka'
                ? 'Tagihan berhasil dibuka'
                : 'Tagihan berhasil ditutup'
        );
    }

    //Monitor pembayaran
    public function monitor(Request $request, TagihanService $tagihanService)
    {
        return view('admin.tagihan.monitor', [
            'data' => $tagihanService->getMonitorTagihan($request->search),
        ]);
    }

    public function updateBayar(TagihanDetail $tagihan, TagihanService $service)
    {

        $service->updatePembayaran($tagihan);

        return back()->with('success', 'Pembayaran berhasil diperbarui');
    }
}

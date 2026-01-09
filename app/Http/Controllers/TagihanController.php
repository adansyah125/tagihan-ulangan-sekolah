<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use App\Services\TagihanService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTagihanRequest;

class TagihanController extends Controller
{
    public function indexUTS()
    {
        $data = Tagihan::select(
            'jenis_tagihan',
            'tahun_ajaran',
            'nominal',
            'tgl_tagihan',
            'jatuh_tempo',
        )
            ->where('jenis_tagihan', 'uts')
            ->groupBy(
                'jenis_tagihan',
                'tahun_ajaran',
                'nominal',
                'tgl_tagihan',
                'jatuh_tempo',
            )
            ->orderBy('tahun_ajaran', 'desc')
            ->get();
        return view('admin.tagihan.uts', compact('data'));
    }

    public function indexUAS()
    {
        $data = Tagihan::select(
            'jenis_tagihan',
            'tahun_ajaran',
            'nominal',
            'tgl_tagihan',
            'jatuh_tempo',
        )
            ->where('jenis_tagihan', 'uas')
            ->groupBy(
                'jenis_tagihan',
                'tahun_ajaran',
                'nominal',
                'tgl_tagihan',
                'jatuh_tempo',
            )
            ->orderBy('tahun_ajaran', 'desc')
            ->get();
        return view('admin.tagihan.uas', compact('data'));
    }

    public function storeUTS(StoreTagihanRequest $request, TagihanService $tagihanService)
    {
        try {
            $tagihanService->buatTagihanUTS($request->validated());

            return back()->with(
                'success',
                'Tagihan UTS berhasil dibuka & dikirim ke seluruh siswa'
            );
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function storeUAS(StoreTagihanRequest $request, TagihanService $tagihanService)
    {
        try {
            $tagihanService->buatTagihanUAS($request->validated());

            return back()->with(
                'success',
                'Tagihan UAS berhasil dibuka & dikirim ke seluruh siswa'
            );
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tagihan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TagihanDetail;
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
            'status'
        )
            ->where('jenis_tagihan', 'UTS')
            ->groupBy(
                'jenis_tagihan',
                'tahun_ajaran',
                'nominal',
                'tgl_tagihan',
                'jatuh_tempo',
                'status'
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
            ->where('jenis_tagihan', 'UAS')
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
                'Tagihan UTS berhasil dibuat'
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

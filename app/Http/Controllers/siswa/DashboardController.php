<?php

namespace App\Http\Controllers\siswa;

use App\Models\Tagihan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TagihanDetail;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $data = TagihanDetail::with('tagihan')
            ->where('user_id', auth::id())
            ->latest()
            ->get();
        $payment = TagihanDetail::with('tagihan')
            ->where('user_id', auth::id())
            ->where('status', 'belum lunas')
            ->latest()
            ->take(3)
            ->get();

        if ($request->filled('search')) {
            $data->where(function ($q) use ($request) {
                $q->where('jenis_tagihan', 'like', '%' . $request->search . '%')
                    ->orWhereHas('tagihan', function ($t) use ($request) {
                        $t->where('tahun_ajaran', 'like', '%' . $request->search . '%');
                    });
            });
        }

        // FILTER STATUS
        if ($request->filled('status')) {
            $payment->where('status', $request->status);
        }
        return view('dashboard', compact('data', 'payment'));
    }
}

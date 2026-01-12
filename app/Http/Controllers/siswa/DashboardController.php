<?php

namespace App\Http\Controllers\siswa;

use App\Models\Tagihan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TagihanDetail;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
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
        return view('dashboard', compact('data', 'payment'));
    }
}

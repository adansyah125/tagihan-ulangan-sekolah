<?php

namespace App\Http\Controllers\siswa;

use App\Models\Tagihan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $data = Tagihan::where('user_id', Auth::id())
            ->where('status', 'belum lunas')
            ->orderBy('jatuh_tempo')
            ->get();
        return view('dashboard', compact('data'));
    }
}

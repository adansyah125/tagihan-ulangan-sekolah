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
        $data = TagihanDetail::where('user_id', Auth::id())
            ->oldest('status')
            ->orderBy('jatuh_tempo')
            ->get();
        return view('dashboard', compact('data'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function indexKeuangan()
    {
        return view('admin.laporan.keuangan');
    }

    public function indexLaporan()
    {
        return view('admin.laporan.tagihan');
    }
}

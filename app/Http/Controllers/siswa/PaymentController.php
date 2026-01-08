<?php

namespace App\Http\Controllers\siswa;

use App\Models\Tagihan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function show(Tagihan $tagihan)
    {
        return view('pembayaran', compact('tagihan'));
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $fillable = [
        'tagihan_id',
        'tgl_bayar',
        'jumlah_bayar',
        'status_pembayaran'
    ];

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }
}

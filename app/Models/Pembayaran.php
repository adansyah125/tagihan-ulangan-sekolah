<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'tagihan_id',
        'kd_pembayaran',
        'tgl_bayar',
        'jenis_tagihan',
        'jumlah_bayar',
        'status_pembayaran'
    ];

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tagihanDetail()
    {
        return $this->belongsTo(TagihanDetail::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}

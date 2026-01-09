<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanDetail extends Model
{
    /** @use HasFactory<\Database\Factories\TagihanDetailFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'tagihan_id',
        'nominal',
        'jenis_tagihan',
        'status',
        'tgl_tagihan',
        'jatuh_tempo',
        'kd_tagihan'
    ];

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
}

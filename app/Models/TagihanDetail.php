<?php

namespace App\Models;

use App\Models\Tagihan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TagihanDetail extends Model
{
    /** @use HasFactory<\Database\Factories\TagihanDetailFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'kelas_id',
        'tagihan_id',
        'kd_tagihan',
        'nominal',
        'jenis_tagihan',
        'tgl_tagihan',
        'jatuh_tempo',
        'status',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }


    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}

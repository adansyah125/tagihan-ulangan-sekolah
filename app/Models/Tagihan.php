<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'tahun_ajaran',
        'jenis_tagihan',
        'nominal',
        'tgl_tagihan',
        'jatuh_tempo',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'kelas'
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }

    public function tagihanDetail()
    {
        return $this->hasMany(TagihanDetail::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
}

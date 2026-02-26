<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalAngsuran extends Model
{
    protected $table = 'jadwal_angsurans';
    protected $guarded = ['id'];

    // Relasi balik ke tabel Pinjaman Induk
    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class);
    }
}
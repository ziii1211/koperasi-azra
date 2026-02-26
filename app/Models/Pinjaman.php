<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    // Beritahu Laravel nama tabel aslinya agar tidak diubah jadi 'pinjamen'
    protected $table = 'pinjamans'; 
    
    protected $guarded = ['id'];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function jadwal_angsurans()
    {
        return $this->hasMany(JadwalAngsuran::class);
    }
}
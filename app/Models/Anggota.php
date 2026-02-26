<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    // Mengamankan nama tabel
    protected $table = 'anggotas';
    
    protected $guarded = ['id'];

    public function pinjamans()
    {
        return $this->hasMany(Pinjaman::class);
    }
}
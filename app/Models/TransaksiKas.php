<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiKas extends Model
{
    protected $table = 'transaksi_kas'; // Mengamankan nama tabel
    protected $guarded = ['id'];
}
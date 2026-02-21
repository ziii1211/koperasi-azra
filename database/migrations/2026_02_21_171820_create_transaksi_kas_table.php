<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('transaksi_kas', function (Blueprint $table) {
        $table->id();
        $table->date('tanggal');
        $table->enum('kategori_kas', ['Mutasi Rekening', 'Modal Kas']);
        $table->enum('jenis_transaksi', ['Pemasukan', 'Pengeluaran']);
        $table->string('sumber_transaksi')->nullable(); // Misal: 'Modal', 'Laba', 'Pinjaman Baru'
        $table->string('keterangan'); 
        $table->decimal('nominal', 15, 2);
        $table->decimal('saldo_berjalan', 15, 2);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_kas');
    }
};

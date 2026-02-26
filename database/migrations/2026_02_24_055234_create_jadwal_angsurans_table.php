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
        Schema::create('jadwal_angsurans', function (Blueprint $table) {
            $table->id();
            // Menyambungkan tagihan ini ke kontrak pinjaman induk
            $table->foreignId('pinjaman_id')->constrained('pinjamans')->cascadeOnDelete();
            
            $table->integer('angsuran_ke'); // Angsuran bulan ke-1, ke-2, dst
            $table->date('tanggal_jatuh_tempo'); // Tanggal harus bayar (Otomatis +1 bulan dari tgl pinjam)
            $table->decimal('nominal_tagihan', 15, 2); // Jumlah yang harus dibayar (Pokok + Jasa)
            
            // Status tagihan khusus untuk bulan tersebut
            $table->enum('status', ['Belum Bayar', 'Sudah Bayar'])->default('Belum Bayar');
            $table->date('tanggal_bayar')->nullable(); // Kapan admin klik tombol "Terima Bayar"
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_angsurans');
    }
};

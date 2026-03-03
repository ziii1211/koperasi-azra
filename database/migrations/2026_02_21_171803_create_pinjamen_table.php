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
        Schema::create('pinjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->constrained('anggotas')->cascadeOnDelete();
            
            // TAMBAHAN BARU: Kolom Tanggal Pinjaman
            $table->date('tanggal_pinjaman'); 
            
            $table->string('mulai_bulan');
            $table->integer('angsuran_jumlah');
            $table->integer('angsuran_ke');
            $table->integer('angsuran_sisa');
            
            $table->decimal('jumlah_pinjaman', 15, 2);
            $table->decimal('angsuran_pokok', 15, 2);
            $table->decimal('jasa_pinjaman', 15, 2);
            $table->decimal('jumlah_angsuran', 15, 2);
            $table->decimal('sisa_pinjaman', 15, 2);
            $table->decimal('sisa_pokok_pinjaman', 15, 2);
            $table->string('keterangan_jumlah')->nullable();
            
            $table->string('status')->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjamen');
    }
};

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
        $table->string('mulai_bulan'); // Contoh: "FEB/JUNI"
        $table->decimal('jumlah_pinjaman', 15, 2); 
        $table->integer('lama_angsuran'); 
        $table->decimal('angsuran_pokok', 15, 2);
        $table->decimal('jasa', 15, 2);
        $table->decimal('jumlah_angsuran', 15, 2); // Pokok + Jasa
        $table->decimal('sisa_pokok', 15, 2);
        $table->enum('status', ['Aktif', 'Lunas', 'Top Up'])->default('Aktif');
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

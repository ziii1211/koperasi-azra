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
    Schema::create('pembayarans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pinjaman_id')->constrained('pinjamans')->cascadeOnDelete();
        $table->integer('angsuran_ke');
        $table->date('tanggal_bayar');
        $table->decimal('bayar_pokok', 15, 2);
        $table->decimal('bayar_jasa', 15, 2); // Ini yang nanti ditarik jadi LABA
        $table->string('keterangan')->nullable(); // Contoh: "Potong Top Up" atau "Cash"
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};

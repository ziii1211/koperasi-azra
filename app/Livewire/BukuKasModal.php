<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TransaksiKas;

class BukuKasModal extends Component
{
    public function render()
    {
        // Menghitung metrik (Saat ini akan 0 karena DB masih kosong)
        $totalModal = TransaksiKas::where('jenis_transaksi', 'Pemasukan')->sum('nominal');
        $danaKeluar = TransaksiKas::where('jenis_transaksi', 'Pengeluaran')->sum('nominal');
        $sisaSaldo = $totalModal - $danaKeluar;

        // Mengambil riwayat transaksi terbaru
        $riwayatKas = TransaksiKas::orderBy('tanggal', 'desc')->get();

        return view('livewire.buku-kas-modal', [
            'totalModal' => $totalModal,
            'danaKeluar' => $danaKeluar,
            'sisaSaldo' => $sisaSaldo,
            'riwayatKas' => $riwayatKas
        ])->title('Buku Kas Modal');
    }
}
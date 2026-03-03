<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TransaksiKas;
use App\Models\JadwalAngsuran; 
use Carbon\Carbon;

class BukuKasModal extends Component
{
    public $isModalOpen = false;

    public $tanggal;
    public $kategori_kas = 'Modal Kas'; 
    public $jenis_transaksi = 'Pemasukan';
    public $keterangan;
    public $nominal;

    public function openModal()
    {
        $this->resetInput(); 
        $this->tanggal = Carbon::now()->format('Y-m-d'); 
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function resetInput()
    {
        $this->tanggal = '';
        $this->kategori_kas = 'Modal Kas';
        $this->jenis_transaksi = 'Pemasukan';
        $this->keterangan = '';
        $this->nominal = '';
    }

    public function simpanTransaksi()
    {
        $this->nominal = preg_replace('/[^0-9]/', '', $this->nominal);

        // VALIDASI DIPERBARUI: Dihapus Mutasi Rekening & Pengeluaran
        $this->validate([
            'tanggal' => 'required|date',
            'kategori_kas' => 'required|in:Modal Kas',
            'jenis_transaksi' => 'required|in:Pemasukan',
            'keterangan' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:1',
        ]);

        $lastTransaksi = TransaksiKas::orderBy('tanggal', 'desc')->orderBy('id', 'desc')->first();
        $currentSaldo = $lastTransaksi ? $lastTransaksi->saldo_berjalan : 0;
        
        $nominalInput = (float) $this->nominal;
        $newSaldo = $this->jenis_transaksi == 'Pemasukan' 
                    ? $currentSaldo + $nominalInput 
                    : $currentSaldo - $nominalInput;

        TransaksiKas::create([
            'tanggal' => $this->tanggal,
            'kategori_kas' => $this->kategori_kas,
            'jenis_transaksi' => $this->jenis_transaksi,
            'keterangan' => $this->keterangan,
            'nominal' => $nominalInput,
            'saldo_berjalan' => $newSaldo,
        ]);

        $this->closeModal();
        session()->flash('message', 'Transaksi berhasil dicatat ke sistem.');
    }

    public function refreshData()
    {
        sleep(1); 
    }

    public function render()
    {
        // 1. TOTAL PROFIT / JASA (Dihitung lebih dulu)
        $totalProfit = JadwalAngsuran::where('status', 'Sudah Bayar')
            ->with('pinjaman')
            ->get()
            ->sum(function($jadwal) {
                return $jadwal->pinjaman->jasa_pinjaman; 
            });

        // 2. SALDO KAS TERSEDIA (Modal Murni Saja)
        // Rumus: (Total Uang Masuk - Total Uang Keluar) DIKURANGI Total Profit
        $semuaPemasukan = TransaksiKas::where('jenis_transaksi', 'Pemasukan')->sum('nominal');
        $semuaPengeluaran = TransaksiKas::where('jenis_transaksi', 'Pengeluaran')->sum('nominal');
        
        // Data Profit dipotong agar tidak masuk ke Saldo Kas
        $sisaSaldo = ($semuaPemasukan - $semuaPengeluaran) - $totalProfit;

        // 3. MODAL KAS MURNI
        $modalMurni = TransaksiKas::where('jenis_transaksi', 'Pemasukan')
                                  ->where('kategori_kas', 'Modal Kas')
                                  ->sum('nominal');

        // 4. DANA DISALURKAN
        $danaKeluar = $semuaPengeluaran;

        $riwayatKas = TransaksiKas::orderBy('tanggal', 'desc')->orderBy('id', 'desc')->limit(5)->get();

        return view('livewire.buku-kas-modal', [
            'modalMurni' => $modalMurni,
            'danaKeluar' => $danaKeluar,
            'sisaSaldo'  => $sisaSaldo, // <-- Saldo yang dikirim sudah bersih dari profit
            'totalProfit'=> $totalProfit,
            'riwayatKas' => $riwayatKas
        ])
        ->title('Buku Kas Modal')
        ->layout('components.layouts.app');
    }
}
<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TransaksiKas;
use Carbon\Carbon;

class MutasiRekening extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 25; // Default tampilkan agak banyak (25 baris)
    
    public $bulanFilter;
    public $tahunFilter;

    public function mount()
    {
        $this->bulanFilter = Carbon::now()->month;
        $this->tahunFilter = Carbon::now()->year;
    }

    public function updatingSearch() { $this->resetPage(); }
    public function updatingBulanFilter() { $this->resetPage(); }
    public function updatingTahunFilter() { $this->resetPage(); }
    public function updatingPerPage() { $this->resetPage(); }

    public function render()
    {
        $mutasis = TransaksiKas::whereMonth('tanggal', $this->bulanFilter)
            ->whereYear('tanggal', $this->tahunFilter)
            ->where('keterangan', 'like', '%' . $this->search . '%')
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        // Menghitung Total Masuk & Keluar pada bulan yang difilter
        $totalMasuk = TransaksiKas::whereMonth('tanggal', $this->bulanFilter)
            ->whereYear('tanggal', $this->tahunFilter)
            ->where('jenis_transaksi', 'Pemasukan')
            ->sum('nominal');
            
        $totalKeluar = TransaksiKas::whereMonth('tanggal', $this->bulanFilter)
            ->whereYear('tanggal', $this->tahunFilter)
            ->where('jenis_transaksi', 'Pengeluaran')
            ->sum('nominal');

        return view('livewire.mutasi-rekening', [
            'mutasis' => $mutasis,
            'totalMasuk' => $totalMasuk,
            'totalKeluar' => $totalKeluar
        ])
        ->title('Mutasi Rekening')
        ->layout('components.layouts.app');
    }
}
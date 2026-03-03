<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pinjaman;
use App\Models\JadwalAngsuran; 
use App\Models\TransaksiKas;
use Carbon\Carbon;

class TagihanAngsuran extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    
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

    public function terimaPembayaran($jadwal_id)
    {
        $jadwal = JadwalAngsuran::with('pinjaman.anggota')->findOrFail($jadwal_id);
        
        if ($jadwal->status == 'Sudah Bayar') {
            session()->flash('error', 'Tagihan ini sudah dibayar sebelumnya.');
            return;
        }

        $jadwal->update([
            'status' => 'Sudah Bayar',
            'tanggal_bayar' => Carbon::now()->format('Y-m-d')
        ]);

        $pinjaman = $jadwal->pinjaman;
        
        if ($pinjaman->angsuran_ke < $pinjaman->angsuran_jumlah) {
            $pinjaman->angsuran_ke += 1;
        }
        
        $pinjaman->angsuran_sisa = max(0, $pinjaman->angsuran_sisa - 1);
        
        $pinjaman->sisa_pinjaman = max(0, $pinjaman->sisa_pinjaman - $jadwal->nominal_tagihan);
        $pinjaman->sisa_pokok_pinjaman = max(0, $pinjaman->sisa_pokok_pinjaman - $pinjaman->angsuran_pokok);
        
        if ($pinjaman->angsuran_sisa <= 0 || $pinjaman->angsuran_ke >= $pinjaman->angsuran_jumlah) {
            $pinjaman->status = 'Lunas';
            $pinjaman->angsuran_sisa = 0;
            $pinjaman->sisa_pinjaman = 0;
            $pinjaman->sisa_pokok_pinjaman = 0;
        } else {
            $masihNunggak = JadwalAngsuran::where('pinjaman_id', $pinjaman->id)
                ->where('status', 'Belum Bayar')
                ->where('tanggal_jatuh_tempo', '<', Carbon::now()->format('Y-m-d'))
                ->exists();
                
            $pinjaman->status = $masihNunggak ? 'Jatuh Tempo' : 'Aktif';
        }
        
        $pinjaman->save();

        $lastTransaksi = TransaksiKas::orderBy('tanggal', 'desc')->orderBy('id', 'desc')->first();
        $currentSaldo = $lastTransaksi ? $lastTransaksi->saldo_berjalan : 0;
        
        $nominalUangMasuk = $jadwal->nominal_tagihan;
        $newSaldo = $currentSaldo + $nominalUangMasuk;

        TransaksiKas::create([
            'tanggal' => Carbon::now()->format('Y-m-d'),
            'kategori_kas' => 'Mutasi Rekening', 
            'jenis_transaksi' => 'Pemasukan',
            'keterangan' => 'Angsuran Ke-' . $jadwal->angsuran_ke . ' A.n ' . strtoupper($pinjaman->anggota->nama),
            'nominal' => $nominalUangMasuk,
            'saldo_berjalan' => $newSaldo,
        ]);

        session()->flash('message', 'Sukses! Sisa hutang berkurang, Angsuran KE naik, dan Buku Kas bertambah.');
    }

    public function render()
    {
        // 1. QUERY UNTUK TABEL DATA BAWAH
        $tagihans = JadwalAngsuran::with(['pinjaman.anggota'])
            ->whereMonth('tanggal_jatuh_tempo', $this->bulanFilter)
            ->whereYear('tanggal_jatuh_tempo', $this->tahunFilter)
            ->whereHas('pinjaman.anggota', function($query) {
                $query->where('nama', 'like', '%' . $this->search . '%');
            })
            ->orderBy('tanggal_jatuh_tempo', 'asc') 
            ->orderBy('id', 'asc') 
            ->paginate($this->perPage);

        // 2. QUERY UNTUK 3 KOTAK STATISTIK ATAS (Hanya menghitung yang SUDAH BAYAR)
        $jadwalTerbayar = JadwalAngsuran::with('pinjaman')
            ->whereMonth('tanggal_jatuh_tempo', $this->bulanFilter)
            ->whereYear('tanggal_jatuh_tempo', $this->tahunFilter)
            ->where('status', 'Sudah Bayar')
            ->get();

        // LOGIKA PERHITUNGAN:
        // Pembayaran = Total Angsuran Pokok yang lunas bulan ini
        $totalPembayaran = $jadwalTerbayar->sum(function($jadwal) {
            return $jadwal->pinjaman->angsuran_pokok;
        });

        // Profit = Total Jasa Pinjaman yang lunas bulan ini
        $totalProfit = $jadwalTerbayar->sum(function($jadwal) {
            return $jadwal->pinjaman->jasa_pinjaman;
        });

        // Laba Bersih = Hasil penjumlahan Pembayaran + Profit
        $labaBersih = $totalPembayaran + $totalProfit;

        return view('livewire.tagihan-angsuran', [
            'tagihans' => $tagihans,
            'totalPembayaran' => $totalPembayaran,
            'totalProfit' => $totalProfit,
            'labaBersih' => $labaBersih, // Kirim 3 variabel ini ke desain tampilan
        ])
        ->title('Tagihan Angsuran Bulanan')
        ->layout('components.layouts.app');
    }
}
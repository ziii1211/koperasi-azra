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

        // 1. UPDATE STATUS BULAN INI
        $jadwal->update([
            'status' => 'Sudah Bayar',
            'tanggal_bayar' => Carbon::now()->format('Y-m-d')
        ]);

        // 2. UPDATE KONTRAK INDUK (MENGURANGI SISA SECARA TEPAT)
        $pinjaman = $jadwal->pinjaman;
        $pinjaman->angsuran_ke += 1;
        $pinjaman->angsuran_sisa -= 1;
        
        // Perbaikan: Hanya potong nominal 1 bulan, jadi datanya tidak tiba-tiba habis!
        $pinjaman->sisa_pinjaman = max(0, $pinjaman->sisa_pinjaman - $jadwal->nominal_tagihan);
        $pinjaman->sisa_pokok_pinjaman = max(0, $pinjaman->sisa_pokok_pinjaman - $pinjaman->angsuran_pokok);
        
        // 3. SET STATUS KONTRAK (LUNAS / AKTIF KEMBALI)
        if ($pinjaman->angsuran_sisa <= 0) {
            $pinjaman->status = 'Lunas';
        } else {
            // Cek apakah masih ada tunggakan lain di bulan sebelumnya?
            $masihNunggak = JadwalAngsuran::where('pinjaman_id', $pinjaman->id)
                ->where('status', 'Belum Bayar')
                ->where('tanggal_jatuh_tempo', '<', Carbon::now()->format('Y-m-d'))
                ->exists();
                
            // Jika sudah bayar bulan ini dan tidak ada tunggakan masa lalu, kembali "Aktif"
            $pinjaman->status = $masihNunggak ? 'Jatuh Tempo' : 'Aktif';
        }
        
        $pinjaman->save();

        // 4. MASUKKAN KE BUKU KAS
        $lastTransaksi = TransaksiKas::orderBy('tanggal', 'desc')->orderBy('id', 'desc')->first();
        $currentSaldo = $lastTransaksi ? $lastTransaksi->saldo_berjalan : 0;
        
        $nominalUangMasuk = $jadwal->nominal_tagihan;
        $newSaldo = $currentSaldo + $nominalUangMasuk;

        TransaksiKas::create([
            'tanggal' => Carbon::now()->format('Y-m-d'),
            'kategori_kas' => 'Mutasi Rekening', 
            'jenis_transaksi' => 'Pemasukan',
            'keterangan' => 'Angsuran Ke-' . $jadwal->angsuran_ke . ' A.n ' . $pinjaman->anggota->nama,
            'nominal' => $nominalUangMasuk,
            'saldo_berjalan' => $newSaldo,
        ]);

        session()->flash('message', 'Sukses! Sisa hutang berkurang dan Status otomatis diperbarui.');
    }

    public function render()
    {
        $tagihans = JadwalAngsuran::with(['pinjaman.anggota'])
            ->whereMonth('tanggal_jatuh_tempo', $this->bulanFilter)
            ->whereYear('tanggal_jatuh_tempo', $this->tahunFilter)
            ->whereHas('pinjaman.anggota', function($query) {
                $query->where('nama', 'like', '%' . $this->search . '%');
            })
            ->orderBy('tanggal_jatuh_tempo', 'asc') // Urutan jatuh tempo
            ->paginate($this->perPage);

        return view('livewire.tagihan-angsuran', [
            'tagihans' => $tagihans
        ])
        ->title('Tagihan Angsuran Bulanan')
        ->layout('components.layouts.app');
    }
}
<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Anggota;
use App\Models\Pinjaman;
use App\Models\JadwalAngsuran;
use App\Models\TransaksiKas; 
use Carbon\Carbon;

class DataPeminjam extends Component
{
    use WithPagination;

    public $search = '';
    public $isModalOpen = false;
    public $peminjam_id; 
    
    public $perPage = 10; 

    public $nama, $tanggal_pinjaman, $mulai_bulan;
    public $angsuran_jumlah, $angsuran_ke, $angsuran_sisa;
    public $jumlah_pinjaman, $angsuran_pokok, $jasa_pinjaman, $jumlah_angsuran;
    public $sisa_pinjaman, $sisa_pokok_pinjaman, $keterangan_jumlah;
    
    public $status = 'Aktif';

    public function updatingPerPage() { $this->resetPage(); }
    public function updatingSearch() { $this->resetPage(); }

    // FUNGSI CCTV: Otomatis menghitung SISA ANGSURAN
    public function updated($propertyName)
    {
        // Jika yang diketik adalah kolom JMLH atau KE
        if ($propertyName === 'angsuran_jumlah' || $propertyName === 'angsuran_ke') {
            $jmlh = (int) $this->angsuran_jumlah;
            $ke = (int) $this->angsuran_ke;
            
            // Logika: SISA = JMLH - KE
            if ($jmlh >= $ke) {
                $this->angsuran_sisa = $jmlh - $ke;
            } else {
                $this->angsuran_sisa = 0; // Cegah hasil minus
            }
        }
    }

    public function openModal() { 
        $this->resetInput(); 
        $this->isModalOpen = true; 
    }

    public function closeModal() { 
        $this->isModalOpen = false; 
    }

    public function resetInput() {
        $this->reset([
            'nama', 'tanggal_pinjaman', 'mulai_bulan', 'angsuran_jumlah', 'angsuran_ke', 'angsuran_sisa',
            'jumlah_pinjaman', 'angsuran_pokok', 'jasa_pinjaman', 'jumlah_angsuran',
            'sisa_pinjaman', 'sisa_pokok_pinjaman', 'keterangan_jumlah', 'peminjam_id'
        ]);
        $this->status = 'Aktif'; 
    }

    public function editPeminjam($id)
    {
        $pinjaman = Pinjaman::with('anggota')->findOrFail($id);
        
        $this->peminjam_id = $pinjaman->id;
        $this->nama = $pinjaman->anggota->nama;
        $this->tanggal_pinjaman = $pinjaman->tanggal_pinjaman; 
        $this->mulai_bulan = $pinjaman->mulai_bulan;
        $this->angsuran_jumlah = $pinjaman->angsuran_jumlah;
        $this->angsuran_ke = $pinjaman->angsuran_ke;
        $this->angsuran_sisa = $pinjaman->angsuran_sisa;
        $this->status = $pinjaman->status;
        
        $this->jumlah_pinjaman = number_format($pinjaman->jumlah_pinjaman, 0, '', '.');
        $this->angsuran_pokok = number_format($pinjaman->angsuran_pokok, 0, '', '.');
        $this->jasa_pinjaman = number_format($pinjaman->jasa_pinjaman, 0, '', '.');
        $this->jumlah_angsuran = number_format($pinjaman->jumlah_angsuran, 0, '', '.');
        $this->sisa_pinjaman = number_format($pinjaman->sisa_pinjaman, 0, '', '.');
        $this->sisa_pokok_pinjaman = number_format($pinjaman->sisa_pokok_pinjaman, 0, '', '.');
        $this->keterangan_jumlah = number_format($pinjaman->keterangan_jumlah, 0, '', '.');

        $this->isModalOpen = true;
    }

    public function hapusPeminjam($id)
    {
        $pinjaman = Pinjaman::findOrFail($id);
        Anggota::where('id', $pinjaman->anggota_id)->delete();
        session()->flash('message', 'Data peminjam berhasil dihapus.');
    }

    public function simpanPeminjam()
    {
        $clean = function($val) {
            if (empty($val)) return 0;
            return (float) preg_replace('/[^0-9]/', '', (string)$val);
        };

        $this->validate([
            'nama' => 'required|string|max:255',
            'tanggal_pinjaman' => 'required|date',
            'mulai_bulan' => 'required|string|max:50',
            'angsuran_jumlah' => 'required|numeric',
            'angsuran_ke' => 'required|numeric',
            'angsuran_sisa' => 'required|numeric',
            'jumlah_pinjaman' => 'required',
            'angsuran_pokok' => 'required',
            'jasa_pinjaman' => 'required',
            'jumlah_angsuran' => 'required',
            'sisa_pinjaman' => 'required',
            'sisa_pokok_pinjaman' => 'required',
            'keterangan_jumlah' => 'required',
            'status' => 'required|in:Aktif,Lunas,Jatuh Tempo', 
        ]);

        $dataPinjaman = [
            'tanggal_pinjaman' => $this->tanggal_pinjaman,
            'mulai_bulan' => strtoupper($this->mulai_bulan),
            'angsuran_jumlah' => $this->angsuran_jumlah,
            'angsuran_ke' => $this->angsuran_ke,
            'angsuran_sisa' => $this->angsuran_sisa,
            'jumlah_pinjaman' => $clean($this->jumlah_pinjaman),
            'angsuran_pokok' => $clean($this->angsuran_pokok),
            'jasa_pinjaman' => $clean($this->jasa_pinjaman),
            'jumlah_angsuran' => $clean($this->jumlah_angsuran),
            'sisa_pinjaman' => $clean($this->sisa_pinjaman),
            'sisa_pokok_pinjaman' => $clean($this->sisa_pokok_pinjaman),
            'keterangan_jumlah' => $clean($this->keterangan_jumlah),
            'status' => $this->status, 
        ];

        if ($this->peminjam_id) {
            $pinjaman = Pinjaman::findOrFail($this->peminjam_id);
            $pinjaman->anggota->update(['nama' => strtoupper($this->nama)]);
            $pinjaman->update($dataPinjaman);
            session()->flash('message', 'Data peminjam berhasil diperbarui.');
        } else {
            $anggota = Anggota::create(['nama' => strtoupper($this->nama)]);
            $dataPinjaman['anggota_id'] = $anggota->id;
            
            $pinjamanBaru = Pinjaman::create($dataPinjaman);
            
            $jumlahTenor = (int) $this->angsuran_jumlah;
            $tglPinjam = Carbon::parse($this->tanggal_pinjaman);
            
            for ($i = 1; $i <= $jumlahTenor; $i++) {
                JadwalAngsuran::create([
                    'pinjaman_id' => $pinjamanBaru->id,
                    'angsuran_ke' => $i,
                    'tanggal_jatuh_tempo' => $tglPinjam->copy()->addMonths($i)->format('Y-m-d'),
                    'nominal_tagihan' => $clean($this->jumlah_angsuran),
                    'status' => 'Belum Bayar'
                ]);
            }

            $lastTransaksi = TransaksiKas::orderBy('tanggal', 'desc')->orderBy('id', 'desc')->first();
            $currentSaldo = $lastTransaksi ? $lastTransaksi->saldo_berjalan : 0;
            
            $nominalCair = $clean($this->jumlah_pinjaman);
            $newSaldo = $currentSaldo - $nominalCair;

            TransaksiKas::create([
                'tanggal' => $this->tanggal_pinjaman,
                'kategori_kas' => 'Mutasi Rekening', 
                'jenis_transaksi' => 'Pengeluaran',
                'keterangan' => 'Pencairan Pinjaman A.n ' . strtoupper($this->nama),
                'nominal' => $nominalCair,
                'saldo_berjalan' => $newSaldo,
            ]);

            session()->flash('message', 'Sukses! Pinjaman berhasil dicatat, jadwal dibuat, dan Dana Kas otomatis dipotong.');
        }
        $this->closeModal();
    }

    public function render()
    {
        $pinjamans = Pinjaman::with('anggota')
            ->whereHas('anggota', function($query) {
                $query->where('nama', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'asc') 
            ->paginate($this->perPage); 

        foreach ($pinjamans as $pinjaman) {
            if ($pinjaman->status != 'Lunas' && $pinjaman->angsuran_sisa > 0) {
                $hasJatuhTempo = JadwalAngsuran::where('pinjaman_id', $pinjaman->id)
                    ->where('status', 'Belum Bayar')
                    ->where('tanggal_jatuh_tempo', '<', Carbon::now()->format('Y-m-d'))
                    ->exists();

                $statusSeharusnya = $hasJatuhTempo ? 'Jatuh Tempo' : 'Aktif';

                if ($pinjaman->status !== $statusSeharusnya) {
                    $pinjaman->update(['status' => $statusSeharusnya]);
                }
            }
        }

        return view('livewire.data-peminjam', [
            'pinjamans' => $pinjamans
        ])
        ->title('Data Peminjam')
        ->layout('components.layouts.app');
    }
}
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

    public $anggota_id;
    public $searchAnggota = '';
    public $namaAnggotaTerpilih = '';
    public $anggotaTerpilih = false;
    public $dropdownOpen = false; 

    public $tunjangan_anggota;
    public $rekening_anggota;

    public $tanggal_pinjaman, $mulai_bulan;
    public $angsuran_jumlah, $angsuran_ke, $angsuran_sisa;
    public $jumlah_pinjaman, $angsuran_pokok, $jasa_pinjaman, $jumlah_angsuran;
    public $sisa_pinjaman, $sisa_pokok_pinjaman, $keterangan_jumlah;
    
    public $status = 'Aktif';

    public function updatingPerPage() { $this->resetPage(); }
    public function updatingSearch() { $this->resetPage(); }

    public function toggleDropdown()
    {
        $this->dropdownOpen = !$this->dropdownOpen;
        if ($this->dropdownOpen) {
            $this->searchAnggota = ''; 
        }
    }

    public function closeDropdown()
    {
        $this->dropdownOpen = false;
    }

    public function getDaftarAnggota()
    {
        if (strlen($this->searchAnggota) > 0) {
            return Anggota::where('nama', 'like', '%' . $this->searchAnggota . '%')
                ->orWhere('nrp', 'like', '%' . $this->searchAnggota . '%')
                ->limit(50)->get();
        }
        return Anggota::limit(50)->get(); 
    }

    public function selectAnggota($id, $nama)
    {
        $this->anggota_id = $id;
        $this->namaAnggotaTerpilih = $nama;
        $this->anggotaTerpilih = true;
        $this->dropdownOpen = false; 
        $this->searchAnggota = ''; 

        $anggota = Anggota::find($id);
        if ($anggota) {
            $this->tunjangan_anggota = number_format($anggota->tunjangan, 0, ',', '.');
            $this->rekening_anggota = ($anggota->bank ?? 'Bank -') . ' / ' . ($anggota->rekening ?? '-');
        }
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['angsuran_jumlah', 'angsuran_ke', 'jumlah_pinjaman', 'jasa_pinjaman'])) {
            $this->hitungOtomatis();
        }
    }

    public function hitungOtomatis()
    {
        $clean = function($val) {
            if (empty($val)) return 0;
            return (float) preg_replace('/[^0-9]/', '', (string)$val);
        };

        $jmlhPinjaman = $clean($this->jumlah_pinjaman);
        $jasaPinjaman = $clean($this->jasa_pinjaman);
        $tenor = (int) $this->angsuran_jumlah;
        $ke = (int) $this->angsuran_ke;

        $sisaAngsuran = 0;
        if ($tenor >= $ke && $tenor > 0) {
            $sisaAngsuran = $tenor - $ke;
        }
        $this->angsuran_sisa = $sisaAngsuran;

        $angsuranPokok = 0;
        if ($tenor > 0) {
            $angsuranPokok = $jmlhPinjaman / $tenor;
        }
        $this->angsuran_pokok = number_format($angsuranPokok, 0, '', '.');

        $jumlahAngsuran = $angsuranPokok + $jasaPinjaman;
        $this->jumlah_angsuran = number_format($jumlahAngsuran, 0, '', '.');

        $sisaPokokPinjaman = $angsuranPokok * $sisaAngsuran;
        $this->sisa_pokok_pinjaman = number_format($sisaPokokPinjaman, 0, '', '.');

        $sisaPinjaman = $sisaPokokPinjaman + ($jasaPinjaman * $sisaAngsuran);
        $this->sisa_pinjaman = number_format($sisaPinjaman, 0, '', '.');
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
            'searchAnggota', 'anggota_id', 'namaAnggotaTerpilih', 'anggotaTerpilih', 'dropdownOpen',
            'tunjangan_anggota', 'rekening_anggota', 
            'tanggal_pinjaman', 'mulai_bulan', 'angsuran_jumlah', 'angsuran_ke', 'angsuran_sisa',
            'jumlah_pinjaman', 'angsuran_pokok', 'jasa_pinjaman', 'jumlah_angsuran',
            'sisa_pinjaman', 'sisa_pokok_pinjaman', 'keterangan_jumlah', 'peminjam_id'
        ]);
        $this->status = 'Aktif'; 
    }

    public function editPeminjam($id)
    {
        $pinjaman = Pinjaman::with('anggota')->findOrFail($id);
        
        $this->peminjam_id = $pinjaman->id;
        
        $this->anggota_id = $pinjaman->anggota_id;
        $this->namaAnggotaTerpilih = $pinjaman->anggota->nama;
        $this->anggotaTerpilih = true;
        
        $this->tunjangan_anggota = number_format($pinjaman->anggota->tunjangan, 0, ',', '.');
        $this->rekening_anggota = ($pinjaman->anggota->bank ?? 'Bank -') . ' / ' . ($pinjaman->anggota->rekening ?? '-');

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
        $this->keterangan_jumlah = $pinjaman->keterangan_jumlah;

        $this->isModalOpen = true;
    }

    public function hapusPeminjam($id)
    {
        Pinjaman::findOrFail($id)->delete();
        session()->flash('message', 'Data kontrak pinjaman berhasil dihapus.');
    }

    public function simpanPeminjam()
    {
        $clean = function($val) {
            if (empty($val)) return 0;
            return (float) preg_replace('/[^0-9]/', '', (string)$val);
        };

        $this->validate([
            'anggota_id' => 'required|exists:anggotas,id',
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
            'keterangan_jumlah' => 'required|string',
            'status' => 'required|in:Aktif,Lunas,Jatuh Tempo', 
        ]);

        $dataPinjaman = [
            'anggota_id' => $this->anggota_id,
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
            'keterangan_jumlah' => strtoupper($this->keterangan_jumlah), 
            'status' => $this->status, 
        ];

        if ($this->peminjam_id) {
            $pinjaman = Pinjaman::findOrFail($this->peminjam_id);
            $pinjaman->update($dataPinjaman);
            session()->flash('message', 'Data kontrak peminjam berhasil diperbarui.');
        } else {
            $pinjamanBaru = Pinjaman::create($dataPinjaman);
            
            $jumlahTenor = (int) $this->angsuran_jumlah;
            $tglPinjam = Carbon::parse($this->tanggal_pinjaman);
            
            // --- LOGIKA PINTAR BACA TEKS BULAN MULAI ---
            $bulanIndo = [
                'JANUARI' => 1, 'FEBRUARI' => 2, 'MARET' => 3, 'APRIL' => 4,
                'MEI' => 5, 'JUNI' => 6, 'JULI' => 7, 'AGUSTUS' => 8,
                'SEPTEMBER' => 9, 'OKTOBER' => 10, 'NOVEMBER' => 11, 'DESEMBER' => 12
            ];
            
            $mulaiBulanUpper = strtoupper($this->mulai_bulan);
            $startMonth = $tglPinjam->month; 
            $startYear = $tglPinjam->year;
            
            // 1. Coba deteksi tahun dari teks (misal admin ngetik "MARET 2026")
            if (preg_match('/\b(20\d{2})\b/', $mulaiBulanUpper, $matches)) {
                $startYear = (int) $matches[1];
            }

            // 2. Coba deteksi nama bulan dari teks (misal "MARET/SELESAI")
            $bulanDitemukan = false;
            foreach ($bulanIndo as $namaBulan => $angkaBulan) {
                if (strpos($mulaiBulanUpper, $namaBulan) !== false) {
                    $startMonth = $angkaBulan;
                    $bulanDitemukan = true;
                    
                    // Kalau admin nggak nulis tahun, kita pakai logika:
                    // Jika bulan mulai lebih KECIL dari bulan cair, otomatis berarti masuk tahun depan
                    if (!isset($matches[1]) && $startMonth < $tglPinjam->month) {
                        $startYear += 1;
                    }
                    break;
                }
            }

            // 3. Fallback jika admin salah ketik parah (misal ngetik: "ASDFG")
            if (!$bulanDitemukan) {
                $startMonth = $tglPinjam->copy()->addMonth()->month;
                $startYear = $tglPinjam->copy()->addMonth()->year;
            }

            // Menentukan tanggal jatuh tempo berdasarkan tanggal cair
            $tglJatuhTempo = $tglPinjam->day;
            if ($tglJatuhTempo > 28) $tglJatuhTempo = 28; // Mencegah eror di bulan Februari

            $startDate = Carbon::createFromDate($startYear, $startMonth, $tglJatuhTempo);
            
            // 4. Looping pembuatan jadwal angsuran
            for ($i = 0; $i < $jumlahTenor; $i++) {
                JadwalAngsuran::create([
                    'pinjaman_id' => $pinjamanBaru->id,
                    'angsuran_ke' => $i + 1,
                    // Tambah bulan dari start date yang sudah pintar di atas
                    'tanggal_jatuh_tempo' => $startDate->copy()->addMonths($i)->format('Y-m-d'),
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
                'keterangan' => 'Pencairan Pinjaman A.n ' . strtoupper($this->namaAnggotaTerpilih),
                'nominal' => $nominalCair,
                'saldo_berjalan' => $newSaldo,
            ]);

            session()->flash('message', 'Sukses! Pinjaman dicatat dan Jadwal Tagihan sukses masuk ke bulan yang ditentukan.');
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
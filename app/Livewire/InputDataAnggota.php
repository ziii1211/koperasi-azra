<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Anggota;
use App\Imports\AnggotaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;

class InputDataAnggota extends Component
{
    use WithFileUploads, WithPagination;

    public $file;
    
    // TAMBAHAN: Variabel untuk menyimpan teks pencarian
    public $search = ''; 

    // TAMBAHAN: Fungsi ini mereset halaman ke 1 setiap kali admin mengetik di kotak pencarian
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function importData()
    {
        $this->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new AnggotaImport, $this->file->getRealPath());
            session()->flash('sukses', 'Data anggota berhasil diimpor!');
            $this->reset('file'); 
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat impor: ' . $e->getMessage());
        }
    }

    public function hapusAnggota($id)
    {
        $anggota = Anggota::find($id);
        if ($anggota) {
            $anggota->delete();
            session()->flash('sukses', 'Data ' . $anggota->nama . ' berhasil dihapus!');
        }
    }

    public function hapusSemua()
    {
        Schema::disableForeignKeyConstraints();
        Anggota::truncate(); 
        Schema::enableForeignKeyConstraints();
        session()->flash('sukses', 'Semua data anggota berhasil dikosongkan!');
    }

    public function render()
    {
        // TAMBAHAN: Logika pencarian berdasarkan Nama atau NRP
        $anggotas = Anggota::where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('nrp', 'like', '%' . $this->search . '%')
                    ->latest()
                    ->paginate(10);
        
        return view('livewire.input-data-anggota', [
            'anggotas' => $anggotas
        ])->layout('components.layouts.app');
    }
}
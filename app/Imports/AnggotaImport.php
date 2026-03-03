<?php

namespace App\Imports;

use App\Models\Anggota;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AnggotaImport implements ToModel, WithHeadingRow
{
    // 1. TAMBAHKAN FUNGSI INI: Kasih tau sistem kalau judul kolom ada di Baris ke-5
    public function headingRow(): int
    {
        return 5;
    }

    public function model(array $row)
    {
        // Ambil data nama
        $nama = $row['nama'] ?? null;

        // Jika nama kosong, lewati baris tersebut
        if (empty($nama)) {
            return null;
        }

        // 2. BERSIHKAN TANDA KUTIP: Hilangkan tanda kutip (') di awal NRP dan Rekening jika ada
        $nrp = isset($row['nrp']) ? ltrim($row['nrp'], "'") : null;
        $rekening = isset($row['rekening']) ? ltrim($row['rekening'], "'") : null;

        // 3. Masukkan data ke database
        return new Anggota([
            'nama'      => $nama,
            'pangkat'   => $row['pangkat'] ?? null,
            'nrp'       => $nrp,
            
            // 4. SESUAIKAN HEADER: Pakai 'tunj_yg_dibayarkan' sesuai teks di Excel kamu
            'tunjangan' => $row['tunj_yg_dibayarkan'] ?? 0, 
            
            'bank'      => $row['bank'] ?? null,
            'rekening'  => $rekening,
        ]);
    }
}
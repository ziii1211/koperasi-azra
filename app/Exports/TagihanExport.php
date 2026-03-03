<?php

namespace App\Exports;

use App\Models\JadwalAngsuran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting; // <-- TAMBAHAN UTK FORMAT ANGKA
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat; // <-- TAMBAHAN UTK FORMAT ANGKA

// Tambahkan "WithColumnFormatting" di baris class ini
class TagihanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithColumnFormatting
{
    protected $namaBulan;
    protected $tahun;
    protected $bulanAngka;
    protected $no = 1;

    public function __construct($namaBulan, $tahun, $bulanAngka)
    {
        $this->namaBulan = $namaBulan;
        $this->tahun = $tahun;
        $this->bulanAngka = $bulanAngka;
    }

    public function collection()
    {
        return JadwalAngsuran::with('pinjaman.anggota')
            ->whereMonth('tanggal_jatuh_tempo', $this->bulanAngka)
            ->whereYear('tanggal_jatuh_tempo', $this->tahun)
            ->orderBy('id', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            ['LAPORAN TAGIHAN ANGSURAN BULAN: ' . strtoupper($this->namaBulan) . ' TAHUN: ' . $this->tahun], 
            [''],
            ['No', 'Nama', 'Tunjangan', 'Angsuran Pinjaman', 'Laba Bersih', 'Total Angsuran', 'Sisa Pengambilan', 'Norek']
        ];
    }

    public function map($tagihan): array
    {
        $tunjangan = $tagihan->pinjaman->anggota->tunjangan;
        $angsuran_pinjaman = $tagihan->pinjaman->angsuran_pokok;
        $laba_bersih = $tagihan->pinjaman->jasa_pinjaman;
        $total_angsuran = $tagihan->nominal_tagihan;
        $sisa_pengambilan = $tunjangan - $total_angsuran;

        // AKALAN SAKTI: Menambahkan 1 spasi kosong (' ') di depan norek biar Excel membacanya sebagai Teks, bukan Rumus Matematika (E+14)
        $norek = $tagihan->pinjaman->anggota->rekening ? ' ' . $tagihan->pinjaman->anggota->rekening : '-';

        return [
            $this->no++,
            strtoupper($tagihan->pinjaman->anggota->nama),
            $tunjangan,
            $angsuran_pinjaman,
            $laba_bersih,
            $total_angsuran,
            $sisa_pengambilan,
            $norek,
        ];
    }

    // FUNGSI BARU: Memberikan Titik Ribuan Otomatis ke Kolom Uang
    public function columnFormats(): array
    {
        return [
            'C' => '#,##0', // Kolom Tunjangan
            'D' => '#,##0', // Kolom Angsuran Pinjaman
            'E' => '#,##0', // Kolom Laba Bersih
            'F' => '#,##0', // Kolom Total Angsuran
            'G' => '#,##0', // Kolom Sisa Pengambilan
            'H' => NumberFormat::FORMAT_TEXT, // Kolom Norek dipaksa jadi teks
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();

        // 1. GABUNGKAN (MERGE) JUDUL & RATA TENGAH
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // 2. HEADER KOLOM (BARIS 3) JADI BOLD & RATA TENGAH
        $sheet->getStyle('A3:H3')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // 3. SEMUA DATA (BARIS 4 SAMPAI BAWAH) RATA TENGAH
        $sheet->getStyle('A4:H' . $highestRow)->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // 4. TAMBAHKAN GARIS TABEL (BORDER) DARI BARIS 3 SAMPAI BAWAH
        $sheet->getStyle('A3:H' . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        return [];
    }
}
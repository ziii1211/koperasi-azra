<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalAngsuran;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TagihanExport;

class LaporanController extends Controller
{
    public function tagihanPdf(Request $request)
    {
        $bulanAngka = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $daftarBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $namaBulan = $daftarBulan[(int)$bulanAngka] ?? $bulanAngka;

        $tagihans = JadwalAngsuran::with('pinjaman.anggota')
            ->whereMonth('tanggal_jatuh_tempo', $bulanAngka)
            ->whereYear('tanggal_jatuh_tempo', $tahun)
            ->orderBy('id', 'asc')
            ->get();

        // RUMUS KALKULASI TOTAL KESELURUHAN (Untuk Baris Paling Bawah)
        $totalTunjangan = $tagihans->sum(function($t) { return $t->pinjaman->anggota->tunjangan; });
        $totalTotalAngsuran = $tagihans->sum('nominal_tagihan'); // Pokok + Jasa
        $totalAngsuranPinjaman = $tagihans->sum(function($t) { return $t->pinjaman->angsuran_pokok; }); // Pokok saja
        $totalSisaPengambilan = $tagihans->sum(function($t) { 
            return $t->pinjaman->anggota->tunjangan - $t->nominal_tagihan; 
        });
        $totalLaba = $tagihans->sum(function($t) { return $t->pinjaman->jasa_pinjaman; }); // Jasa saja

        $pdf = Pdf::loadView('pdf.tagihan', compact(
            'tagihans', 'namaBulan', 'tahun', 
            'totalTunjangan', 'totalTotalAngsuran', 'totalAngsuranPinjaman', 
            'totalSisaPengambilan', 'totalLaba'
        ));
        
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Laporan_Tagihan_Bulan_'.$namaBulan.'_Tahun_'.$tahun.'.pdf');
    }

    public function tagihanExcel(Request $request)
    {
        $bulanAngka = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $daftarBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $namaBulan = $daftarBulan[(int)$bulanAngka] ?? $bulanAngka;

        return Excel::download(new TagihanExport($namaBulan, $tahun, $bulanAngka), 'Laporan_Tagihan_Bulan_'.$namaBulan.'_Tahun_'.$tahun.'.xlsx');
    }
}
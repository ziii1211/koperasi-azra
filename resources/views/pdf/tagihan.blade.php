<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Tagihan</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11px; color: #000; }
        
        .kop-surat { width: 100%; margin-bottom: 25px; border-collapse: collapse; }
        .kop-surat td { border: none; padding: 0; }
        
        .judul-kop { text-align: center; }
        .judul-kop h2 { margin: 0; padding: 0; font-size: 24px; text-transform: uppercase; font-weight: bold; letter-spacing: 1px; }
        .judul-kop p { margin: 5px 0 0 0; font-size: 13px; }
        
        .tabel-data { border-collapse: collapse; width: 100%; }
        .tabel-data th, .tabel-data td { 
            border: 1px solid #000; 
            padding: 8px 5px; 
            text-align: left; 
            background-color: transparent !important; 
        }
        .tabel-data th { font-weight: bold; text-align: center; text-transform: uppercase; font-size: 10px; }
        .tabel-data td { font-size: 10px; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .total-row td { font-weight: bold; font-size: 11px; text-transform: uppercase; }
    </style>
</head>
<body>

    <table class="kop-surat">
        <tr>

            <td width="70%" class="judul-kop" style="vertical-align: top; padding-top: 20px;">
                <h2>KOPERASI AZRA</h2>
                <p>LAPORAN KEUANGAN ANGSURAN ANGGOTA</p>
                <p><strong>PERIODE: BULAN {{ strtoupper($namaBulan) }} TAHUN {{ $tahun }}</strong></p>
            </td>
            
            <td width="20%"></td>
        </tr>
    </table>

    <table class="tabel-data">
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="20%">Nama</th>
                <th width="12%">Tunjangan</th>
                <th width="13%">Angsuran Pinjaman</th>
                <th width="10%">Laba Bersih</th>
                <th width="13%">Total Angsuran</th>
                <th width="13%">Sisa Pengambilan</th>
                <th width="15%">Norek</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tagihans as $index => $tagihan)
            @php
                $tunjangan = $tagihan->pinjaman->anggota->tunjangan;
                $angsuran_pinjaman = $tagihan->pinjaman->angsuran_pokok;
                $laba_bersih = $tagihan->pinjaman->jasa_pinjaman;
                $total_angsuran = $tagihan->nominal_tagihan;
                $sisa_pengambilan = $tunjangan - $total_angsuran;
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ strtoupper($tagihan->pinjaman->anggota->nama) }}</td>
                <td class="text-right">{{ number_format($tunjangan, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($angsuran_pinjaman, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($laba_bersih, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($total_angsuran, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($sisa_pengambilan, 0, ',', '.') }}</td>
                <td class="text-center">{{ $tagihan->pinjaman->anggota->rekening ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center" style="padding: 20px;">Tidak ada data tagihan pada bulan ini.</td>
            </tr>
            @endforelse
            
            <tr class="total-row">
                <td colspan="2" class="text-right">TOTAL KESELURUHAN:</td>
                <td class="text-right">Rp {{ number_format($totalTunjangan, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($totalAngsuranPinjaman, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($totalLaba, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($totalTotalAngsuran, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($totalSisaPengambilan, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>

</body>
</html>
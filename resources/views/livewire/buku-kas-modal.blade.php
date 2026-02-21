<div>
    <h2 class="text-2xl font-bold mb-6 text-slate-700">Buku Kas Modal</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 border-l-4 border-l-blue-500">
            <p class="text-sm text-slate-500 font-medium">Total Modal Keseluruhan</p>
            <h3 class="text-3xl font-bold text-slate-800 mt-2">Rp {{ number_format($totalModal, 0, ',', '.') }}</h3>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 border-l-4 border-l-orange-500">
            <p class="text-sm text-slate-500 font-medium">Total Dana Keluar (Pinjaman)</p>
            <h3 class="text-3xl font-bold text-slate-800 mt-2">Rp {{ number_format($danaKeluar, 0, ',', '.') }}</h3>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 border-l-4 border-l-emerald-500">
            <p class="text-sm text-slate-500 font-medium">Sisa Saldo Kas Kasir</p>
            <h3 class="text-3xl font-bold text-slate-800 mt-2">Rp {{ number_format($sisaSaldo, 0, ',', '.') }}</h3>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
            <h3 class="font-semibold text-slate-700">Riwayat Pergerakan Kas</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50">
                    <tr>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Keterangan</th>
                        <th class="px-6 py-3 text-right">Debit (Masuk)</th>
                        <th class="px-6 py-3 text-right">Kredit (Keluar)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($riwayatKas as $kas)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($kas->tanggal)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 font-medium text-slate-700">{{ $kas->keterangan }}</td>
                            <td class="px-6 py-4 text-right text-emerald-600 font-medium">
                                {{ $kas->jenis_transaksi == 'Pemasukan' ? '+ Rp ' . number_format($kas->nominal, 0, ',', '.') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-right text-orange-600 font-medium">
                                {{ $kas->jenis_transaksi == 'Pengeluaran' ? '- Rp ' . number_format($kas->nominal, 0, ',', '.') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-500">Belum ada data transaksi kas modal.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
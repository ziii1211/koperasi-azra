<div class="relative pb-10">
    <style>
        @keyframes fadeUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up { animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-fade-up-delay { animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; animation-delay: 0.1s; opacity: 0; }
    </style>

    <div class="animate-fade-up flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-6">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Mutasi Rekening</h2>
            <p class="text-sm font-semibold text-slate-500 mt-1">Riwayat aliran dana masuk (Debit) dan keluar (Kredit).</p>
        </div>
    </div>

    <div class="animate-fade-up grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-[2rem] p-6 shadow-lg shadow-emerald-200 flex items-center gap-6 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10 group-hover:bg-white/20 transition-colors duration-500"></div>
            <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white shrink-0 border border-white/20 shadow-inner">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
            </div>
            <div class="relative z-10 text-white">
                <p class="text-sm font-bold text-emerald-100 uppercase tracking-wider mb-1">Total Masuk Bulan Ini</p>
                <h3 class="text-3xl font-extrabold tracking-tight">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="bg-gradient-to-br from-orange-500 to-red-500 rounded-[2rem] p-6 shadow-lg shadow-orange-200 flex items-center gap-6 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10 group-hover:bg-white/20 transition-colors duration-500"></div>
            <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white shrink-0 border border-white/20 shadow-inner">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
            </div>
            <div class="relative z-10 text-white">
                <p class="text-sm font-bold text-orange-100 uppercase tracking-wider mb-1">Total Keluar Bulan Ini</p>
                <h3 class="text-3xl font-extrabold tracking-tight">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <div class="animate-fade-up-delay flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
        
        <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
            
            <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-2xl px-4 py-2.5 shadow-sm w-full sm:w-auto">
                <span class="text-sm font-bold text-slate-500 hidden sm:inline">Tampilkan</span>
                <select wire:model.live="perPage" class="bg-transparent text-slate-800 font-bold text-sm focus:outline-none cursor-pointer w-full sm:w-auto">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-sm font-bold text-slate-500 hidden sm:inline">Data</span>
            </div>

            <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-2xl px-3 py-2 shadow-sm w-full sm:w-auto">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <select wire:model.live="bulanFilter" class="bg-transparent text-slate-700 font-bold text-sm focus:outline-none cursor-pointer pr-2">
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
                <div class="w-px h-4 bg-slate-300 mx-1"></div>
                <select wire:model.live="tahunFilter" class="bg-transparent text-slate-700 font-bold text-sm focus:outline-none cursor-pointer">
                    <option value="{{ date('Y') - 1 }}">{{ date('Y') - 1 }}</option>
                    <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                    <option value="{{ date('Y') + 1 }}">{{ date('Y') + 1 }}</option>
                </select>
            </div>
        </div>

        <div class="relative w-full md:w-72">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            <input type="text" wire:model.live.debounce.500ms="search" class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500 outline-none shadow-sm transition-all" placeholder="Cari keterangan mutasi...">
        </div>
    </div>

    <div class="animate-fade-up-delay bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase text-center w-14">NO</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase">TANGGAL</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase">KETERANGAN TRANSAKSI</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase text-center">KATEGORI</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-emerald-600 uppercase text-right w-40">DANA MASUK (DEBIT)</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-orange-600 uppercase text-right w-40">DANA KELUAR (KREDIT)</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-700 uppercase text-right w-44 bg-slate-50/50">SALDO BERJALAN</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($mutasis as $mutasi)
                        <tr class="hover:bg-blue-50/30 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-400 text-center">{{ ($mutasis->currentPage() - 1) * $mutasis->perPage() + $loop->iteration }}</td>
                            
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($mutasi->tanggal)->format('d/m/Y') }}</span>
                                <span class="block text-[10px] font-semibold text-slate-400 mt-0.5">{{ \Carbon\Carbon::parse($mutasi->created_at)->format('H:i') }}</span>
                            </td>
                            
                            <td class="px-6 py-4 font-bold text-slate-800 whitespace-normal min-w-[200px]">{{ $mutasi->keterangan }}</td>
                            
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 bg-slate-100 text-slate-600 text-[10px] font-extrabold rounded-md uppercase tracking-wider">{{ $mutasi->kategori_kas }}</span>
                            </td>

                            <td class="px-6 py-4">
                                @if($mutasi->jenis_transaksi == 'Pemasukan')
                                    <div class="flex justify-between items-center w-full font-bold text-emerald-600 text-base">
                                        <span class="text-[10px] text-emerald-300 mr-2">Rp</span>
                                        <span>{{ number_format($mutasi->nominal, 0, ',', '.') }}</span>
                                    </div>
                                @else
                                    <div class="text-center font-bold text-slate-300">-</div>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                @if($mutasi->jenis_transaksi == 'Pengeluaran')
                                    <div class="flex justify-between items-center w-full font-bold text-orange-600 text-base">
                                        <span class="text-[10px] text-orange-300 mr-2">Rp</span>
                                        <span>{{ number_format($mutasi->nominal, 0, ',', '.') }}</span>
                                    </div>
                                @else
                                    <div class="text-center font-bold text-slate-300">-</div>
                                @endif
                            </td>

                            <td class="px-6 py-4 bg-slate-50/30">
                                <div class="flex justify-between items-center w-full font-extrabold text-slate-700 text-lg">
                                    <span class="text-[10px] text-slate-400 mr-2">Rp</span>
                                    <span>{{ number_format($mutasi->saldo_berjalan, 0, ',', '.') }}</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mx-auto mb-3">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <p class="text-slate-600 font-bold text-lg">Tidak Ada Mutasi</p>
                                <p class="text-sm font-semibold text-slate-400">Belum ada riwayat transaksi pada bulan dan tahun ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-50">
            {{ $mutasis->links() }}
        </div>
    </div>
</div>
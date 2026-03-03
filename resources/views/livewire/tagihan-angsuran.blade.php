<div class="space-y-6 pb-10">
    <style>
        @keyframes fadeUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up { animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    </style>

    @if (session()->has('message'))
        <div class="animate-fade-up p-4 mb-6 text-sm text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-2xl font-semibold flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="animate-fade-up p-4 mb-6 text-sm text-red-700 bg-red-50 border border-red-200 rounded-2xl font-semibold flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="animate-fade-up flex flex-col xl:flex-row justify-between items-start xl:items-end gap-5 mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Tagihan Bulanan</h2>
            <p class="text-sm font-semibold text-slate-500 mt-1">Pantau pembayaran angsuran dan cetak laporan bulanan.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3 w-full xl:w-auto">
            
            <select wire:model.live="bulanFilter" class="bg-white border border-slate-200 text-slate-700 font-bold text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm cursor-pointer hover:border-indigo-300 transition-colors">
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

            <select wire:model.live="tahunFilter" class="bg-white border border-slate-200 text-slate-700 font-bold text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm cursor-pointer hover:border-indigo-300 transition-colors">
                @for($y = 2024; $y <= \Carbon\Carbon::now()->year + 5; $y++)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endfor
            </select>

            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input type="text" wire:model.live.debounce.500ms="search" class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 outline-none shadow-sm transition-all" placeholder="Cari nama peminjam...">
            </div>

            <div class="hidden sm:block w-px h-8 bg-slate-200 mx-1"></div>

            <a href="{{ route('export.tagihan.pdf', ['bulan' => $bulanFilter, 'tahun' => $tahunFilter]) }}" target="_blank" class="bg-red-50 border border-red-200 text-red-600 hover:bg-red-600 hover:text-white px-4 py-2.5 rounded-xl text-sm font-extrabold transition-all shadow-sm flex items-center gap-2 group">
                <svg class="w-5 h-5 group-hover:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                PDF
            </a>

            <a href="{{ route('export.tagihan.excel', ['bulan' => $bulanFilter, 'tahun' => $tahunFilter]) }}" class="bg-emerald-50 border border-emerald-200 text-emerald-600 hover:bg-emerald-600 hover:text-white px-4 py-2.5 rounded-xl text-sm font-extrabold transition-all shadow-sm flex items-center gap-2 group">
                <svg class="w-5 h-5 group-hover:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                EXCEL
            </a>
        </div>
    </div>

    <div class="animate-fade-up grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
        <div class="bg-white rounded-[1.5rem] p-6 border border-slate-100 shadow-[0_8px_30px_rgb(255,255,255)] flex items-center gap-5 hover:-translate-y-1 transition-transform">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pembayaran Pokok</p>
                <div class="flex items-baseline gap-1 mt-1">
                    <span class="text-sm font-bold text-slate-500">Rp</span>
                    <h3 class="text-2xl font-extrabold text-slate-800">{{ number_format($totalPembayaran, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[1.5rem] p-6 border border-slate-100 shadow-[0_8px_30px_rgb(255,255,255)] flex items-center gap-5 hover:-translate-y-1 transition-transform">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Profit Jasa Pinjaman</p>
                <div class="flex items-baseline gap-1 mt-1">
                    <span class="text-sm font-bold text-slate-500">Rp</span>
                    <h3 class="text-2xl font-extrabold text-emerald-600">{{ number_format($totalProfit, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-[1.5rem] p-6 shadow-xl flex items-center gap-5 hover:-translate-y-1 transition-transform">
            <div class="w-14 h-14 rounded-2xl bg-white/20 text-white flex items-center justify-center shrink-0 backdrop-blur-sm border border-white/20">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-indigo-200 uppercase tracking-wider">Laba Bersih Koperasi</p>
                <div class="flex items-baseline gap-1 mt-1">
                    <span class="text-sm font-bold text-indigo-200">Rp</span>
                    <h3 class="text-2xl font-extrabold text-white">{{ number_format($labaBersih, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="animate-fade-up bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="px-5 py-4 text-[11px] font-bold text-slate-500 uppercase text-center w-14">NO</th>
                        <th class="px-5 py-4 text-[11px] font-bold text-slate-500 uppercase">NAMA PEMINJAM</th>
                        <th class="px-5 py-4 text-[11px] font-bold text-slate-500 uppercase text-center">JATUH TEMPO</th>
                        <th class="px-5 py-4 text-[11px] font-bold text-slate-500 uppercase text-center">ANGSURAN KE</th>
                        <th class="px-5 py-4 text-[11px] font-bold text-slate-500 uppercase text-right">TAGIHAN (Rp)</th>
                        <th class="px-5 py-4 text-[11px] font-bold text-slate-500 uppercase text-center">STATUS</th>
                        <th class="px-5 py-4 text-[11px] font-bold text-slate-500 uppercase text-center sticky right-0 bg-slate-50/90 backdrop-blur-sm z-10 shadow-[-10px_0_15px_-10px_rgba(0,0,0,0.05)]">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($tagihans as $tagihan)
                    <tr class="hover:bg-indigo-50/30 transition-colors">
                        <td class="px-5 py-4 font-bold text-slate-400 text-center">{{ ($tagihans->currentPage() - 1) * $tagihans->perPage() + $loop->iteration }}</td>
                        <td class="px-5 py-4 font-extrabold text-slate-800 uppercase">{{ $tagihan->pinjaman->anggota->nama }}</td>
                        <td class="px-5 py-4 font-semibold text-slate-600 text-center">{{ \Carbon\Carbon::parse($tagihan->tanggal_jatuh_tempo)->format('d/m/Y') }}</td>
                        <td class="px-5 py-4 font-bold text-indigo-600 text-center">Ke-{{ $tagihan->angsuran_ke }}</td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex justify-between items-center w-full font-bold text-slate-700">
                                <span class="text-[10px] text-slate-400 mr-2">Rp</span>
                                <span>{{ number_format($tagihan->nominal_tagihan, 0, ',', '.') }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-center">
                            @if($tagihan->status == 'Sudah Bayar')
                                <span class="px-3 py-1.5 bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded-lg uppercase tracking-wider border border-emerald-200">LUNAS</span>
                            @else
                                <span class="px-3 py-1.5 bg-orange-100 text-orange-700 text-[10px] font-bold rounded-lg uppercase tracking-wider border border-orange-200">BELUM BAYAR</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-center sticky right-0 bg-white group-hover:bg-indigo-50/10 transition-colors z-10 shadow-[-10px_0_15px_-10px_rgba(0,0,0,0.02)]">
                            @if($tagihan->status == 'Belum Bayar')
                                <button wire:click="terimaPembayaran({{ $tagihan->id }})" wire:confirm="Terima pembayaran angsuran Rp {{ number_format($tagihan->nominal_tagihan, 0, ',', '.') }} dari {{ $tagihan->pinjaman->anggota->nama }}?" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-xs font-bold transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 whitespace-nowrap">
                                    Terima Bayar
                                </button>
                            @else
                                <span class="text-[11px] font-extrabold text-slate-300 italic">SELESAI</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center text-slate-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            <p class="font-bold text-slate-500 text-base">Hore! Tidak ada tagihan di bulan ini.</p>
                            <p class="text-xs mt-1">Atau mungkin admin belum memasukkan data kontrak pinjaman baru?</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-slate-50">
            {{ $tagihans->links() }}
        </div>
    </div>
</div>
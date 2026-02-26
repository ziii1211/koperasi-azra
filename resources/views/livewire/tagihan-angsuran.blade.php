<div class="relative pb-10">
    <style>
        @keyframes fadeUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up { animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    </style>

    @if (session()->has('message'))
        <div class="animate-fade-up p-4 mb-6 text-sm text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-2xl font-semibold flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('message') }}
        </div>
    @endif
    
    @if (session()->has('error'))
        <div class="animate-fade-up p-4 mb-6 text-sm text-red-700 bg-red-50 border border-red-200 rounded-2xl font-semibold flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="animate-fade-up flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Tagihan Bulanan</h2>
            <p class="text-sm font-semibold text-slate-500 mt-1">Lacak pembayaran angsuran anggota berdasarkan bulan.</p>
        </div>
        
        <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
            
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
                    <option value="{{ date('Y') + 2 }}">{{ date('Y') + 2 }}</option>
                </select>
            </div>

            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input type="text" wire:model.live.debounce.500ms="search" class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-slate-700 font-semibold focus:ring-2 focus:ring-indigo-500 outline-none shadow-sm transition-all" placeholder="Cari nama anggota...">
            </div>
        </div>
    </div>

    <div class="animate-fade-up bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase text-center w-14">NO</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase">NAMA PEMINJAM</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase text-center">JATUH TEMPO</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase text-center">ANGSURAN KE</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase text-right">TAGIHAN (Rp)</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase text-center">STATUS BULAN INI</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase text-center sticky right-0 bg-slate-50/90 backdrop-blur-sm z-10 shadow-[-10px_0_15px_-10px_rgba(0,0,0,0.05)]">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($tagihans as $tagihan)
                        <tr class="hover:bg-indigo-50/30 transition-colors {{ $tagihan->status == 'Sudah Bayar' ? 'bg-slate-50/50' : '' }}">
                            <td class="px-6 py-5 font-bold text-slate-400 text-center">{{ ($tagihans->currentPage() - 1) * $tagihans->perPage() + $loop->iteration }}</td>
                            <td class="px-6 py-5 font-bold text-slate-800 text-base">{{ $tagihan->pinjaman->anggota->nama }}</td>
                            
                            <td class="px-6 py-5 text-center font-semibold text-slate-600">
                                {{ \Carbon\Carbon::parse($tagihan->tanggal_jatuh_tempo)->format('d M Y') }}
                            </td>
                            
                            <td class="px-6 py-5 text-center">
                                <span class="px-3 py-1.5 bg-indigo-50 text-indigo-600 font-extrabold rounded-lg border border-indigo-100">
                                    Bulan Ke-{{ $tagihan->angsuran_ke }}
                                </span>
                            </td>

                            <td class="px-6 py-5">
                                <div class="flex justify-between items-center w-full font-extrabold text-slate-700 text-lg">
                                    <span class="text-xs text-slate-400 mr-2">Rp</span>
                                    <span class="{{ $tagihan->status == 'Sudah Bayar' ? 'line-through text-slate-400' : '' }}">
                                        {{ number_format($tagihan->nominal_tagihan, 0, ',', '.') }}
                                    </span>
                                </div>
                            </td>

                            <td class="px-6 py-5 text-center">
                                @if($tagihan->status == 'Sudah Bayar')
                                    <span class="px-3 py-1.5 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-lg uppercase tracking-wider border border-emerald-200">
                                        Sudah Bayar
                                    </span>
                                    <p class="text-[9px] font-bold text-slate-400 mt-1 uppercase">Tgl: {{ \Carbon\Carbon::parse($tagihan->tanggal_bayar)->format('d/m/Y') }}</p>
                                @else
                                    <span class="px-3 py-1.5 bg-orange-100 text-orange-700 text-xs font-bold rounded-lg uppercase tracking-wider border border-orange-200">
                                        Belum Bayar
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-5 text-center sticky right-0 {{ $tagihan->status == 'Sudah Bayar' ? 'bg-slate-50' : 'bg-white' }} group-hover:bg-transparent transition-colors z-10 shadow-[-10px_0_15px_-10px_rgba(0,0,0,0.02)]">
                                @if($tagihan->status == 'Sudah Bayar')
                                    <div class="flex items-center justify-center text-emerald-500 font-bold text-sm gap-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        Selesai
                                    </div>
                                @else
                                    <button wire:click="terimaPembayaran({{ $tagihan->id }})" wire:confirm="Terima pembayaran angsuran dari {{ $tagihan->pinjaman->anggota->nama }} untuk bulan ini?" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-bold transition-all shadow-md shadow-emerald-200 flex items-center gap-2 mx-auto hover:-translate-y-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Terima Bayar
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mx-auto mb-3">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <p class="text-slate-600 font-bold text-lg">Tidak Ada Tagihan Bulan Ini</p>
                                <p class="text-sm font-semibold text-slate-400">Silakan pilih bulan lain melalui dropdown di atas.</p>
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
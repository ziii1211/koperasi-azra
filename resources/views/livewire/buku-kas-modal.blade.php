<div class="relative pb-10">
    
    <style>
        @keyframes fadeUpStagger {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up-1 { animation: fadeUpStagger 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-fade-up-2 { animation: fadeUpStagger 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; animation-delay: 0.1s; opacity: 0; }
        .animate-fade-up-3 { animation: fadeUpStagger 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; animation-delay: 0.2s; opacity: 0; }
        .animate-fade-up-4 { animation: fadeUpStagger 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; animation-delay: 0.3s; opacity: 0; }
    </style>

    @if (session()->has('message'))
        <div class="animate-fade-up-1 p-4 mb-6 text-sm text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-2xl font-semibold flex items-center gap-3 shadow-sm">
            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            </div>
            {{ session('message') }}
        </div>
    @endif

    <div wire:loading wire:target="refreshData" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/40 backdrop-blur-md transition-all duration-300">
        <div class="flex flex-col items-center bg-white/90 p-8 rounded-[2.5rem] shadow-2xl border border-white/50">
            <div class="relative w-28 h-28 mb-6">
                <div class="absolute inset-0 bg-indigo-100 rounded-full animate-ping opacity-70"></div>
                <div class="relative z-10 w-full h-full bg-gradient-to-tr from-indigo-500 to-blue-500 rounded-full flex items-center justify-center shadow-lg animate-bounce shadow-indigo-300">
                    <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 9h.01M15 9h.01" class="animate-pulse text-indigo-100"></path>
                    </svg>
                </div>
            </div>
            <h2 class="text-xl font-bold text-slate-700 tracking-wide bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-blue-600">
                AI Sinkronisasi Data...
            </h2>
            <p class="text-sm font-semibold text-slate-500 mt-2">Menganalisa mutasi kas & profit terbaru</p>
        </div>
    </div>

    <div class="animate-fade-up-1 flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Performa Kas Modal</h2>
            <p class="text-sm font-semibold text-slate-500 mt-1">Ringkasan modal murni, dana pinjaman, dan pergerakan profit.</p>
        </div>
        
        <div class="flex items-center gap-3 w-full md:w-auto">
            <button wire:click="refreshData" class="p-3 bg-white hover:bg-slate-50 text-slate-600 border border-slate-200 rounded-2xl transition-all shadow-sm group">
                <svg wire:loading.class="animate-spin" wire:target="refreshData" class="w-5 h-5 text-indigo-500 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            </button>
            <button wire:click="openModal" class="flex-1 md:flex-none bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl font-bold transition-all shadow-[0_8px_20px_rgba(79,_70,_229,_0.25)] hover:-translate-y-0.5 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                Catat Transaksi Kas
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6 mb-8">
        
        <div class="animate-fade-up-2 xl:col-span-1 bg-gradient-to-br from-slate-800 via-slate-900 to-[#0f172a] rounded-[2rem] p-8 shadow-xl relative overflow-hidden flex flex-col justify-between min-h-[220px] group border border-slate-700/50">
            <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl -mr-20 -mt-20 group-hover:bg-indigo-500/20 transition-colors duration-700"></div>
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-sm font-semibold tracking-wide uppercase">Saldo Kas Tersedia</p>
                    <div class="mt-4 flex items-start">
                        <span class="text-indigo-300 font-bold text-lg mt-1 mr-1">Rp</span>
                        <h3 class="text-4xl sm:text-5xl font-extrabold text-white tracking-tight">{{ number_format($sisaSaldo, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            <div class="relative z-10 mt-8 pt-5 border-t border-slate-700/80 flex justify-between items-center">
                <p class="text-sm font-semibold text-slate-300 tracking-wider">KOPERASI AZRA</p>
                <div class="flex items-center gap-2 bg-emerald-500/10 px-3 py-1 rounded-full border border-emerald-500/20">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest">Liquid</p>
                </div>
            </div>
        </div>

        <div class="xl:col-span-3 grid grid-cols-1 sm:grid-cols-3 gap-6">
            
            <div class="animate-fade-up-3 bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 flex flex-col relative overflow-hidden group hover:shadow-md transition-shadow">
                <div class="absolute right-0 bottom-0 w-24 h-24 bg-emerald-50 rounded-tl-full -mr-8 -mb-8 transition-transform duration-500 group-hover:scale-110"></div>
                <div class="w-12 h-12 rounded-xl bg-emerald-100/50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100 mb-4 relative z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <div class="relative z-10 mt-auto">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Pemasukan Modal</p>
                    <h3 class="text-2xl font-extrabold text-slate-700">Rp {{ number_format($modalMurni, 0, ',', '.') }}</h3>
                </div>
            </div>

            <div class="animate-fade-up-4 bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 flex flex-col relative overflow-hidden group hover:shadow-md transition-shadow">
                <div class="absolute right-0 bottom-0 w-24 h-24 bg-orange-50 rounded-tl-full -mr-8 -mb-8 transition-transform duration-500 group-hover:scale-110"></div>
                <div class="w-12 h-12 rounded-xl bg-orange-100/50 text-orange-600 flex items-center justify-center shrink-0 border border-orange-100 mb-4 relative z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="relative z-10 mt-auto">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Dana Pinjaman Keluar</p>
                    <h3 class="text-2xl font-extrabold text-slate-700">Rp {{ number_format($danaKeluar, 0, ',', '.') }}</h3>
                </div>
            </div>

            <div class="animate-fade-up-4 bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 flex flex-col relative overflow-hidden group hover:shadow-md transition-shadow" style="animation-delay: 0.4s;">
                <div class="absolute right-0 bottom-0 w-24 h-24 bg-blue-50 rounded-tl-full -mr-8 -mb-8 transition-transform duration-500 group-hover:scale-110"></div>
                <div class="w-12 h-12 rounded-xl bg-blue-100/50 text-blue-600 flex items-center justify-center shrink-0 border border-blue-100 mb-4 relative z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                <div class="relative z-10 mt-auto">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Keuntungan (Profit Jasa)</p>
                    <h3 class="text-2xl font-extrabold text-blue-600">Rp {{ number_format($totalProfit, 0, ',', '.') }}</h3>
                </div>
            </div>

        </div>
    </div>

    <div class="animate-fade-up-4 bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden" style="animation-delay: 0.5s;">
        <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center">
            <h3 class="text-xl font-bold text-slate-700">Riwayat Mutasi Terakhir</h3>
            <a href="#" class="px-4 py-2 text-sm font-bold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition-colors">
                Lihat Semua
            </a>
        </div>
        
        <div class="p-4">
            @forelse ($riwayatKas as $kas)
                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 hover:bg-slate-50/80 rounded-2xl transition-all group border border-transparent hover:border-slate-100">
                    <div class="flex items-center gap-5">
                        @if($kas->jenis_transaksi == 'Pemasukan')
                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                            </div>
                        @else
                            <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-500 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                            </div>
                        @endif
                        
                        <div>
                            <p class="font-bold text-slate-700 text-base">{{ $kas->keterangan }}</p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-sm font-semibold text-slate-500">{{ \Carbon\Carbon::parse($kas->tanggal)->translatedFormat('d F Y') }}</span>
                                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $kas->kategori_kas }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-left sm:text-right mt-4 sm:mt-0 pl-17 sm:pl-0">
                        <p class="text-lg font-bold {{ $kas->jenis_transaksi == 'Pemasukan' ? 'text-emerald-600' : 'text-slate-700' }}">
                            {{ $kas->jenis_transaksi == 'Pemasukan' ? '+' : '-' }} Rp {{ number_format($kas->nominal, 0, ',', '.') }}
                        </p>
                        <p class="text-sm font-semibold text-slate-400 mt-0.5">Saldo: Rp {{ number_format($kas->saldo_berjalan, 0, ',', '.') }}</p>
                    </div>
                </div>
            @empty
                <div class="py-16 flex flex-col items-center justify-center text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <p class="text-lg font-bold text-slate-700">Belum Ada Transaksi</p>
                    <p class="text-sm font-semibold text-slate-500 mt-1">Klik tombol "Catat Transaksi Kas" untuk memulai.</p>
                </div>
            @endforelse
        </div>
    </div>

    @if($isModalOpen)
    <div class="fixed inset-0 z-[150] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
        <div class="bg-white rounded-[2rem] w-full max-w-xl shadow-2xl overflow-hidden animate-fade-up-1">
            <div class="px-8 py-5 flex justify-between items-center bg-slate-50/50 border-b border-slate-100">
                <h3 class="text-xl font-bold text-slate-700">Catat Transaksi Manual</h3>
                <button wire:click="closeModal" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form wire:submit.prevent="simpanTransaksi" class="p-8 space-y-6">
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Transaksi</label>
                        <input type="date" wire:model="tanggal" class="w-full border-2 border-slate-100 bg-slate-50 focus:bg-white rounded-xl px-4 py-3 font-semibold text-slate-700 focus:ring-0 focus:border-indigo-500 outline-none transition-all">
                        @error('tanggal') <span class="text-sm font-semibold text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Kategori</label>
                        <select wire:model="kategori_kas" class="w-full border-2 border-slate-100 bg-slate-50 focus:bg-white rounded-xl px-4 py-3 font-semibold text-slate-700 focus:ring-0 focus:border-indigo-500 outline-none transition-all cursor-pointer">
                            <option value="Modal Kas">Modal Kas (Utama)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Aliran Dana</label>
                    <div class="grid grid-cols-1 gap-4">
                        <label class="flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all {{ $jenis_transaksi == 'Pemasukan' ? 'border-emerald-500 bg-emerald-50/50' : 'border-slate-100 bg-slate-50 hover:bg-slate-100' }}">
                            <input type="radio" wire:model.live="jenis_transaksi" value="Pemasukan" class="hidden">
                            <div class="flex items-center justify-center w-full gap-2">
                                <svg class="w-5 h-5 {{ $jenis_transaksi == 'Pemasukan' ? 'text-emerald-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                <span class="font-bold text-base {{ $jenis_transaksi == 'Pemasukan' ? 'text-emerald-700' : 'text-slate-600' }}">Dana Masuk</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Transaksi</label>
                    <input type="text" wire:model="keterangan" placeholder="Contoh: Pencairan pinjaman A.n Rocky / Setor Modal" class="w-full border-2 border-slate-100 bg-slate-50 focus:bg-white rounded-xl px-4 py-3 font-semibold text-slate-700 focus:ring-0 focus:border-indigo-500 outline-none transition-all">
                    @error('keterangan') <span class="text-sm font-semibold text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Jumlah (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-slate-400 font-bold text-lg">Rp</span>
                        <input type="text" inputmode="numeric" wire:model="nominal" x-data x-on:input="$el.value = $el.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')" placeholder="0" class="w-full border-2 border-slate-100 bg-slate-50 focus:bg-white rounded-xl pl-12 pr-4 py-3 font-extrabold text-slate-800 text-lg focus:ring-0 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    @error('nominal') <span class="text-sm font-semibold text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="pt-2 flex justify-end gap-4">
                    <button type="button" wire:click="closeModal" class="px-6 py-3 rounded-xl font-bold text-slate-500 hover:bg-slate-100 transition-colors">Batal</button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-indigo-200 transition-all flex items-center gap-2 hover:-translate-y-0.5">
                        <svg wire:loading wire:target="simpanTransaksi" class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
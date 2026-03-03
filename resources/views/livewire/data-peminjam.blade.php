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
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            {{ session('message') }}
        </div>
    @endif

    <div class="animate-fade-up flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Data Peminjam</h2>
            <p class="text-sm font-semibold text-slate-500 mt-1">Sesuai Format Master Simpan Pinjam 2026</p>
        </div>
        
        <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
            <div class="flex items-center gap-2 w-full sm:w-auto bg-white border border-slate-200 rounded-2xl px-4 py-2 shadow-sm">
                <span class="text-sm font-bold text-slate-500 hidden xl:inline">Tampilkan</span>
                <select wire:model.live="perPage" class="bg-transparent text-slate-800 font-bold text-sm focus:outline-none cursor-pointer">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-sm font-bold text-slate-500 hidden sm:inline">Data</span>
            </div>

            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input type="text" wire:model.live.debounce.500ms="search" class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-slate-700 font-semibold focus:ring-2 focus:ring-indigo-500 outline-none shadow-sm transition-all" placeholder="Cari nama anggota...">
            </div>

            <button wire:click="openModal" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-2xl font-bold transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 flex items-center justify-center gap-2 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                <span class="hidden sm:inline">Tambah Baru</span>
            </button>
        </div>
    </div>

    <div class="animate-fade-up bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="px-5 py-4 text-[11px] font-bold text-slate-500 uppercase text-center w-14">NO</th>
                        <th class="px-5 py-4 text-[11px] font-bold text-slate-500 uppercase">N A M A</th>
                        <th class="px-5 py-4 text-[11px] font-bold text-slate-500 uppercase">TGL PINJAM</th>
                        <th class="px-5 py-4 text-[11px] font-bold text-slate-500 uppercase">MULAI BULAN</th>
                        <th class="px-5 py-4 text-[11px] font-bold text-slate-500 uppercase text-center">ANGSURAN<br><span class="text-[9px] text-slate-400">(JMLH, KE, SISA)</span></th>
                        <th class="px-5 py-4 text-[11px] font-bold text-slate-500 uppercase text-right w-40">JUMLAH PINJAMAN</th>
                        <th class="px-5 py-4 text-[11px] font-bold text-slate-500 uppercase text-right w-40">ANGSURAN POKOK</th>
                        <th class="px-5 py-4 text-[11px] font-bold text-slate-500 uppercase text-right w-36">JASA PINJAMAN</th>
                        <th class="px-5 py-4 text-[11px] font-bold text-slate-500 uppercase text-right w-40">JUMLAH ANGSURAN</th>
                        <th class="px-5 py-4 text-[11px] font-bold text-slate-500 uppercase text-right w-40">SISA PINJAMAN</th>
                        <th class="px-5 py-4 text-[11px] font-bold text-slate-500 uppercase text-right w-40">SISA POKOK</th>
                        <th class="px-5 py-4 text-[11px] font-bold text-slate-500 uppercase text-center w-40">KETERANGAN</th>
                        <th class="px-5 py-4 text-[11px] font-bold text-slate-500 uppercase text-center w-32">STATUS</th>
                        <th class="px-5 py-4 text-[11px] font-bold text-slate-500 uppercase text-center sticky right-0 bg-slate-50/90 backdrop-blur-sm z-10 shadow-[-10px_0_15px_-10px_rgba(0,0,0,0.05)]">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($pinjamans as $pinjaman)
                        <tr class="hover:bg-indigo-50/30 transition-colors">
                            <td class="px-5 py-4 font-bold text-slate-400 text-center">{{ ($pinjamans->currentPage() - 1) * $pinjamans->perPage() + $loop->iteration }}</td>
                            <td class="px-5 py-4 font-bold text-slate-800">{{ $pinjaman->anggota->nama }}</td>
                            <td class="px-5 py-4 font-semibold text-slate-600">{{ \Carbon\Carbon::parse($pinjaman->tanggal_pinjaman)->format('d/m/Y') }}</td>
                            <td class="px-5 py-4 font-semibold text-slate-600">{{ $pinjaman->mulai_bulan }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-1.5 text-xs font-bold">
                                    <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded-md">{{ $pinjaman->angsuran_jumlah }}</span>
                                    <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded-md">{{ $pinjaman->angsuran_ke }}</span>
                                    <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded-md">{{ $pinjaman->angsuran_sisa }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4"><div class="flex justify-between items-center w-full font-bold text-slate-700"><span class="text-[10px] text-slate-400 mr-2">Rp</span><span>{{ number_format($pinjaman->jumlah_pinjaman, 0, ',', '.') }}</span></div></td>
                            <td class="px-5 py-4"><div class="flex justify-between items-center w-full font-semibold text-slate-600"><span class="text-[10px] text-slate-400 mr-2">Rp</span><span>{{ number_format($pinjaman->angsuran_pokok, 0, ',', '.') }}</span></div></td>
                            <td class="px-5 py-4"><div class="flex justify-between items-center w-full font-semibold text-slate-600"><span class="text-[10px] text-slate-400 mr-2">Rp</span><span>{{ number_format($pinjaman->jasa_pinjaman, 0, ',', '.') }}</span></div></td>
                            <td class="px-5 py-4"><div class="flex justify-between items-center w-full font-bold text-indigo-600"><span class="text-[10px] text-indigo-300 mr-2">Rp</span><span>{{ number_format($pinjaman->jumlah_angsuran, 0, ',', '.') }}</span></div></td>
                            <td class="px-5 py-4"><div class="flex justify-between items-center w-full font-bold text-orange-600"><span class="text-[10px] text-orange-300 mr-2">Rp</span><span>{{ number_format($pinjaman->sisa_pinjaman, 0, ',', '.') }}</span></div></td>
                            <td class="px-5 py-4"><div class="flex justify-between items-center w-full font-semibold text-slate-600"><span class="text-[10px] text-slate-400 mr-2">Rp</span><span>{{ number_format($pinjaman->sisa_pokok_pinjaman, 0, ',', '.') }}</span></div></td>
                            
                            <td class="px-5 py-4">
                                <div class="flex justify-center items-center w-full font-bold text-slate-600 uppercase">
                                    <span>{{ $pinjaman->keterangan_jumlah }}</span>
                                </div>
                            </td>
                            
                            <td class="px-5 py-4 text-center">
                                @if($pinjaman->status == 'Aktif')
                                    <span class="px-3 py-1.5 bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded-lg uppercase tracking-wider border border-emerald-200">Aktif</span>
                                @elseif($pinjaman->status == 'Lunas')
                                    <span class="px-3 py-1.5 bg-blue-100 text-blue-700 text-[10px] font-bold rounded-lg uppercase tracking-wider border border-blue-200">Lunas</span>
                                @else
                                    <span class="px-3 py-1.5 bg-red-100 text-red-700 text-[10px] font-bold rounded-lg uppercase tracking-wider border border-red-200">Jatuh Tempo</span>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-center sticky right-0 bg-white group-hover:bg-indigo-50/10 transition-colors z-10 shadow-[-10px_0_15px_-10px_rgba(0,0,0,0.02)]">
                                <div class="flex justify-center items-center gap-2">
                                    <button wire:click="editPeminjam({{ $pinjaman->id }})" class="p-1.5 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-lg transition-colors group/btn" title="Update Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <button wire:click="hapusPeminjam({{ $pinjaman->id }})" wire:confirm="Data ini akan dihapus permanen. Apakah Anda yakin?" class="p-1.5 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-lg transition-colors group/btn" title="Hapus Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="14" class="px-6 py-12 text-center text-slate-500 font-semibold">Belum ada data peminjam.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-50">
            {{ $pinjamans->links() }}
        </div>
    </div>

    @if($isModalOpen)
    <div class="fixed inset-0 z-[150] flex items-center justify-center p-4 sm:p-6 bg-slate-900/40 backdrop-blur-sm">
        
        <div class="bg-white rounded-[2rem] w-full max-w-4xl shadow-2xl animate-fade-up flex flex-col max-h-[95vh]">
            
            <div class="px-6 py-4 sm:px-8 sm:py-5 flex justify-between items-center bg-slate-50/50 border-b border-slate-100 shrink-0 rounded-t-[2rem]">
                <h3 class="text-lg sm:text-xl font-bold text-slate-700">
                    {{ $peminjam_id ? 'Update Data Peminjam' : 'Tambah Kontrak Peminjam Baru' }}
                </h3>
                <button wire:click="closeModal" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form wire:submit.prevent="simpanPeminjam" class="p-5 sm:p-8 overflow-y-auto">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-5 mb-5">
                    
                    <div class="relative">
                        <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-2">PILIH NAMA ANGGOTA</label>
                        
                        <div wire:click="toggleDropdown" class="w-full border-2 {{ $anggotaTerpilih ? 'border-indigo-200 bg-indigo-50/50' : 'border-slate-100 bg-slate-50' }} rounded-xl px-4 py-3 font-semibold cursor-pointer flex justify-between items-center hover:bg-white hover:border-indigo-300 transition-all select-none">
                            <span class="{{ $anggotaTerpilih ? 'text-indigo-700 font-bold uppercase' : 'text-slate-400 font-medium' }} truncate pr-2 text-sm sm:text-base">
                                {{ $anggotaTerpilih ? $namaAnggotaTerpilih : 'Pilih Nama Anggota...' }}
                            </span>
                            <svg class="w-5 h-5 text-slate-400 shrink-0 transition-transform duration-200 {{ $dropdownOpen ? 'rotate-180 text-indigo-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                        </div>

                        @if($dropdownOpen)
                        <div wire:click.away="closeDropdown" class="absolute z-50 w-full mt-2 bg-white border border-slate-200 rounded-xl shadow-[0_15px_40px_rgba(0,0,0,0.12)] overflow-hidden">
                            <div class="p-3 border-b border-slate-100 bg-slate-50/50 sticky top-0 z-10">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                    </div>
                                    <input type="text" wire:model.live.debounce.300ms="searchAnggota" placeholder="Ketik pencarian..." class="w-full pl-9 pr-3 py-2.5 bg-white border border-slate-200 rounded-lg text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none uppercase" autocomplete="off" autofocus>
                                </div>
                            </div>
                            
                            <ul class="max-h-56 overflow-y-auto divide-y divide-slate-50">
                                @forelse($this->getDaftarAnggota() as $anggota)
                                    <li wire:click="selectAnggota({{ $anggota->id }}, '{{ addslashes($anggota->nama) }}')" class="px-4 py-3 hover:bg-indigo-50 cursor-pointer transition-colors group flex flex-col">
                                        <span class="font-bold text-slate-700 group-hover:text-indigo-700 text-sm uppercase">{{ $anggota->nama }}</span>
                                        <span class="text-[10px] font-bold text-slate-400 mt-0.5">NRP: {{ $anggota->nrp ?? '-' }} <span class="mx-1">•</span> Bank: {{ $anggota->bank ?? '-' }}</span>
                                    </li>
                                @empty
                                    <li class="px-4 py-6 flex flex-col items-center justify-center text-slate-400">
                                        <svg class="w-8 h-8 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="text-sm font-bold">Data tidak ditemukan</span>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                        @endif
                        @error('anggota_id') <span class="text-[11px] text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-2">TGL PENCAIRAN (PINJAM)</label>
                        <input type="date" wire:model="tanggal_pinjaman" class="w-full border-2 border-slate-100 bg-slate-50 rounded-xl px-4 py-3 font-semibold text-slate-700 focus:bg-white focus:border-indigo-500 outline-none text-sm sm:text-base">
                        @error('tanggal_pinjaman') <span class="text-[11px] text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-2">MULAI BULAN</label>
                        <input type="text" wire:model="mulai_bulan" placeholder="Contoh: Maret" class="w-full border-2 border-slate-100 bg-slate-50 rounded-xl px-4 py-3 font-semibold text-slate-700 focus:bg-white focus:border-indigo-500 outline-none uppercase text-sm sm:text-base">
                        @error('mulai_bulan') <span class="text-[11px] text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 mb-5 p-4 bg-indigo-50/40 border border-indigo-100/60 rounded-2xl">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Tunjangan Dibayarkan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-slate-400 font-bold text-sm sm:text-base">Rp</span>
                            </div>
                            <input type="text" wire:model="tunjangan_anggota" readonly class="w-full pl-11 pr-4 py-3 bg-slate-200/50 border-2 border-slate-100/50 text-emerald-600 font-bold rounded-xl outline-none cursor-not-allowed text-sm sm:text-base" placeholder="0">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Bank & Rekening</label>
                        <input type="text" wire:model="rekening_anggota" readonly class="w-full px-4 py-3 bg-slate-200/50 border-2 border-slate-100/50 text-slate-600 font-bold rounded-xl outline-none cursor-not-allowed text-sm sm:text-base" placeholder="Pilih nama anggota dulu...">
                    </div>
                </div>

                <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-2">ANGSURAN (JMLH, KE, SISA)</label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-5 mb-5">
                    <div>
                        <input type="number" wire:model.live.debounce.300ms="angsuran_jumlah" placeholder="JMLH (Total)" class="w-full border-2 border-slate-100 bg-slate-50 rounded-xl px-4 py-3 font-bold text-slate-700 focus:bg-white focus:border-indigo-500 outline-none text-sm sm:text-base">
                        @error('angsuran_jumlah') <span class="text-[11px] text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <input type="number" wire:model.live.debounce.300ms="angsuran_ke" placeholder="KE Berapa" class="w-full border-2 border-slate-100 bg-slate-50 rounded-xl px-4 py-3 font-bold text-slate-700 focus:bg-white focus:border-indigo-500 outline-none text-sm sm:text-base">
                        @error('angsuran_ke') <span class="text-[11px] text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <input type="number" wire:model="angsuran_sisa" placeholder="SISA (Otomatis)" readonly class="w-full border-2 border-slate-200 bg-slate-200/50 text-slate-500 rounded-xl px-4 py-3 font-bold cursor-not-allowed outline-none focus:ring-0 text-sm sm:text-base">
                        @error('angsuran_sisa') <span class="text-[11px] text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 mb-5">
                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-2">JUMLAH PINJAMAN (Rp)</label>
                        <input type="text" inputmode="numeric" wire:model.live.debounce.500ms="jumlah_pinjaman" x-data x-on:input="$el.value = $el.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')" placeholder="0" class="w-full border-2 border-slate-100 bg-slate-50 rounded-xl px-4 py-3 font-extrabold text-slate-800 focus:bg-white focus:border-indigo-500 outline-none transition-colors text-sm sm:text-base">
                        @error('jumlah_pinjaman') <span class="text-[11px] text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-2">ANGSURAN POKOK (Rp)</label>
                        <input type="text" wire:model="angsuran_pokok" readonly class="w-full border-2 border-slate-200 bg-slate-200/50 text-slate-500 rounded-xl px-4 py-3 font-bold cursor-not-allowed outline-none focus:ring-0 text-sm sm:text-base" placeholder="0 (Otomatis)">
                        @error('angsuran_pokok') <span class="text-[11px] text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-2">JASA PINJAMAN (Rp)</label>
                        <input type="text" inputmode="numeric" wire:model.live.debounce.500ms="jasa_pinjaman" x-data x-on:input="$el.value = $el.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')" placeholder="0" class="w-full border-2 border-slate-100 bg-slate-50 rounded-xl px-4 py-3 font-bold text-slate-700 focus:bg-white focus:border-indigo-500 outline-none transition-colors text-sm sm:text-base">
                        @error('jasa_pinjaman') <span class="text-[11px] text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-2">JUMLAH ANGSURAN (Rp)</label>
                        <input type="text" wire:model="jumlah_angsuran" readonly class="w-full border-2 border-slate-200 bg-slate-200/50 text-indigo-500 rounded-xl px-4 py-3 font-extrabold cursor-not-allowed outline-none focus:ring-0 text-sm sm:text-base" placeholder="0 (Otomatis)">
                        @error('jumlah_angsuran') <span class="text-[11px] text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-2">SISA PINJAMAN (Rp)</label>
                        <input type="text" wire:model="sisa_pinjaman" readonly class="w-full border-2 border-slate-200 bg-slate-200/50 text-orange-600 rounded-xl px-4 py-3 font-extrabold cursor-not-allowed outline-none focus:ring-0 text-sm sm:text-base" placeholder="0 (Otomatis)">
                        @error('sisa_pinjaman') <span class="text-[11px] text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-2">SISA POKOK PINJAMAN (Rp)</label>
                        <input type="text" wire:model="sisa_pokok_pinjaman" readonly class="w-full border-2 border-slate-200 bg-slate-200/50 text-slate-600 rounded-xl px-4 py-3 font-bold cursor-not-allowed outline-none focus:ring-0 text-sm sm:text-base" placeholder="0 (Otomatis)">
                        @error('sisa_pokok_pinjaman') <span class="text-[11px] text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-2">KETERANGAN</label>
                        <input type="text" wire:model="keterangan_jumlah" placeholder class="w-full border-2 border-slate-100 bg-slate-50 rounded-xl px-4 py-3 font-extrabold text-slate-800 focus:bg-white focus:border-indigo-500 outline-none transition-colors uppercase text-sm sm:text-base">
                        @error('keterangan_jumlah') <span class="text-[11px] text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-2">STATUS PINJAMAN</label>
                        <div class="relative">
                            <select wire:model="status" class="w-full border-2 border-slate-100 bg-slate-50 rounded-xl px-4 py-3 font-bold text-slate-700 focus:bg-white focus:border-indigo-500 outline-none appearance-none cursor-pointer text-sm sm:text-base">
                                <option value="Aktif">Aktif</option>
                                <option value="Lunas">Lunas</option>
                                <option value="Jatuh Tempo">Jatuh Tempo</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        @error('status') <span class="text-[11px] text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="pt-4 flex justify-end gap-3 sm:gap-4 border-t border-slate-50 shrink-0">
                    <button type="button" wire:click="closeModal" class="px-5 py-2.5 sm:px-6 sm:py-3 rounded-xl font-bold text-slate-500 hover:bg-slate-100 transition-colors text-sm sm:text-base">Batal</button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 sm:px-8 sm:py-3 rounded-xl font-bold shadow-lg transition-all flex items-center gap-2 text-sm sm:text-base">
                        <svg wire:loading wire:target="simpanPeminjam" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        {{ $peminjam_id ? 'Simpan' : 'Simpan Data' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
<div class="space-y-6">
    <div class="flex justify-between items-end">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Data Anggota</h2>
            <p class="text-sm text-slate-500 font-medium mt-1">Kelola dan unggah data anggota koperasi secara massal.</p>
        </div>
        
        <div class="flex gap-3">
            @if(App\Models\Anggota::count() > 0)
            <button wire:click="hapusSemua" wire:confirm="PERINGATAN! Yakin ingin menghapus SEMUA data anggota? Tindakan ini tidak bisa dibatalkan." class="bg-red-50 border border-red-200 text-red-600 px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-red-600 hover:text-white transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Kosongkan Data
            </button>
            @endif

            <button class="bg-white border border-slate-200 text-slate-700 px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-slate-50 hover:text-indigo-600 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Template Excel
            </button>
        </div>
    </div>

    @if (session()->has('sukses'))
        <div class="bg-emerald-50 text-emerald-600 border border-emerald-200 p-4 rounded-xl flex items-center gap-3 font-semibold text-sm animate-fade-in-up">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('sukses') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-50 text-red-600 border border-red-200 p-4 rounded-xl flex items-center gap-3 font-semibold text-sm animate-fade-in-up">
            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_8px_30px_rgb(255,255,255)]"> <form wire:submit.prevent="importData">
            <label class="block text-sm font-bold text-slate-700 mb-3">Unggah File Data Anggota</label>
            
            <div class="relative border-2 border-dashed border-slate-300 hover:border-indigo-400 bg-white hover:bg-indigo-50/50 rounded-2xl p-8 text-center transition-all group cursor-pointer">
                <input type="file" wire:model="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept=".xlsx, .xls, .csv">
                
                <div class="flex flex-col items-center justify-center space-y-3 pointer-events-none">
                    <div class="w-14 h-14 bg-slate-50 rounded-full flex items-center justify-center text-indigo-500 group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-indigo-600">Klik untuk unggah <span class="text-slate-500 font-medium">atau seret file ke sini</span></p>
                        <p class="text-xs text-slate-400 mt-1">Mendukung format .XLSX, .XLS, atau .CSV (Maks. 10MB)</p>
                    </div>
                    
                    <div wire:loading wire:target="file" class="text-sm text-indigo-600 font-semibold animate-pulse mt-2">
                        Sedang menyiapkan file...
                    </div>
                    
                    @if ($file)
                        <div class="mt-3 px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg text-sm font-bold flex items-center gap-2 border border-indigo-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            {{ $file->getClientOriginalName() }}
                        </div>
                    @endif
                </div>
            </div>

            @error('file') <span class="text-red-500 text-xs font-bold mt-2 block">{{ $message }}</span> @enderror

            <div class="mt-4 flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl hover:shadow-lg transition-all flex items-center gap-2 disabled:opacity-50" wire:loading.attr="disabled" @if(!$file) disabled @endif>
                    <span wire:loading.remove wire:target="importData">Proses Impor Data</span>
                    <span wire:loading wire:target="importData">Sedang Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden mt-6 shadow-[0_8px_30px_rgb(255,255,255)]"> <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white">
            <h3 class="text-lg font-bold text-slate-800">Daftar Anggota</h3>
            
            <div class="relative w-full sm:w-80">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input wire:model.live="search" type="text" class="w-full pl-11 pr-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none" placeholder="Cari Nama atau NRP...">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse bg-white">
                <thead>
                    <tr class="bg-white border-b border-slate-100 text-xs uppercase tracking-wider text-slate-500 font-extrabold">
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Nama / Pangkat</th>
                        <th class="px-6 py-4">NRP</th>
                        <th class="px-6 py-4">Tunjangan Dibayarkan</th>
                        <th class="px-6 py-4">Bank / Rekening</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-medium text-slate-700 divide-y divide-slate-100">
                    @forelse ($anggotas as $index => $anggota)
                        <tr class="hover:bg-slate-50/50 transition-colors bg-white">
                            <td class="px-6 py-4">{{ $anggotas->firstItem() + $index }}</td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800">{{ $anggota->nama }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">{{ $anggota->pangkat ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4"><span class="bg-slate-50 border border-slate-100 text-slate-600 px-2.5 py-1 rounded-md text-xs font-bold">{{ $anggota->nrp ?? '-' }}</span></td>
                            <td class="px-6 py-4 text-emerald-600 font-bold">Rp {{ number_format($anggota->tunjangan, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-700">{{ $anggota->bank ?? '-' }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">{{ $anggota->rekening ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button wire:click="hapusAnggota({{ $anggota->id }})" wire:confirm="Yakin ingin menghapus data {{ $anggota->nama }}?" class="text-red-500 hover:text-white bg-white border border-red-100 hover:bg-red-500 hover:border-red-500 p-2.5 rounded-xl transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white">
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                <p class="font-bold text-slate-500">Tidak ada data ditemukan.</p>
                                @if($search)
                                    <p class="text-xs mt-1">Tidak ada anggota dengan nama/NRP "<span class="text-slate-700">{{ $search }}</span>".</p>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100 bg-white"> {{ $anggotas->links() }}
        </div>
    </div>
</div>
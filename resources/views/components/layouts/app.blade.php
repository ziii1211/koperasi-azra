<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Koperasi Azra - Dashboard' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        /* Animasi Masuk */
        @keyframes slideInLeft {
            0% { transform: translateX(-100%); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }
        @keyframes fadeInContent {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-left { animation: slideInLeft 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-fade-content { animation: fadeInContent 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards; animation-delay: 0.2s; opacity: 0; }
        
        /* Scrollbar Estetik */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
    @livewireStyles
</head>
<body class="bg-[#F0F4F8] font-sans antialiased text-slate-700 flex h-screen overflow-hidden selection:bg-indigo-500 selection:text-white relative">
    
    <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-indigo-100/40 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-blue-100/40 rounded-full blur-3xl translate-y-1/3 -translate-x-1/4"></div>
    </div>

    <aside class="w-72 my-4 ml-4 bg-white/80 backdrop-blur-2xl border border-white rounded-[2rem] shadow-[0_20px_40px_rgba(0,0,0,0.03)] flex flex-col justify-between hidden md:flex z-20 animate-slide-left relative overflow-hidden">
        
        <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-white/60 to-transparent pointer-events-none"></div>

        <div>
            <div class="h-24 flex items-center px-8 relative z-10">
                <div class="w-12 h-12 bg-gradient-to-br from-slate-800 via-indigo-950 to-slate-900 rounded-[1.2rem] flex items-center justify-center shadow-xl shadow-indigo-900/20 mr-4 relative group cursor-pointer overflow-hidden border border-slate-700/50">
                    
                    <div class="absolute inset-0 bg-gradient-to-tr from-white/0 via-white/10 to-white/0 -translate-x-[150%] group-hover:translate-x-[150%] transition-transform duration-1000 ease-in-out"></div>
                    
                    <svg class="w-7 h-7 relative z-10 group-hover:scale-110 group-hover:-translate-y-0.5 transition-all duration-300" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3L4 7.5 12 12l8-4.5L12 3z" class="text-indigo-100" />
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12l8 4.5 8-4.5" class="text-indigo-400" />
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16.5L12 21l8-4.5" class="text-emerald-400" />
                    </svg>
                </div>
                
                <div class="group cursor-default">
                    <h1 class="text-[1.35rem] font-extrabold text-slate-800 tracking-tight leading-none group-hover:text-indigo-600 transition-colors duration-300">Azra</h1>
                    <p class="text-[0.65rem] font-extrabold text-slate-400 uppercase tracking-[0.2em] mt-1.5">Sistem Koperasi</p>
                </div>
            </div>

            <nav class="px-5 py-4 space-y-2 relative z-10">
                <p class="px-3 text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Menu Utama</p>
                
                <a href="/dashboard" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl bg-gradient-to-r from-indigo-50 to-blue-50 text-indigo-600 font-bold transition-all shadow-sm border border-indigo-100/50 group relative overflow-hidden">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-indigo-600 rounded-r-full"></div>
                    <svg class="w-5 h-5 ml-1 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span class="relative z-10">Buku Kas Modal</span>
                </a>

                <a href="/data-peminjam" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold transition-all border group relative overflow-hidden {{ request()->is('data-peminjam') ? 'bg-gradient-to-r from-indigo-50 to-blue-50 text-indigo-600 border-indigo-100/50 shadow-sm' : 'text-slate-500 border-transparent hover:bg-white hover:text-slate-700 hover:border-slate-100' }}">
                    @if(request()->is('data-peminjam')) <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-indigo-600 rounded-r-full"></div> @endif
                    <svg class="w-5 h-5 ml-1 relative z-10 {{ request()->is('data-peminjam') ? '' : 'opacity-60 group-hover:opacity-100 group-hover:scale-110 group-hover:text-indigo-500 transition-all' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="relative z-10">Data Peminjam</span>
                </a>

                <a href="/tagihan-angsuran" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold transition-all border group relative overflow-hidden {{ request()->is('tagihan-angsuran') ? 'bg-gradient-to-r from-emerald-50 to-teal-50 text-emerald-600 border-emerald-100/50 shadow-sm' : 'text-slate-500 border-transparent hover:bg-white hover:text-slate-700 hover:border-slate-100' }}">
                    @if(request()->is('tagihan-angsuran')) <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-emerald-600 rounded-r-full"></div> @endif
                    <svg class="w-5 h-5 ml-1 relative z-10 {{ request()->is('tagihan-angsuran') ? '' : 'opacity-60 group-hover:opacity-100 group-hover:scale-110 group-hover:text-emerald-500 transition-all' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="relative z-10">Tagihan Angsuran</span>
                </a>

                <a href="/mutasi-rekening" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold transition-all border group relative overflow-hidden {{ request()->is('mutasi-rekening') ? 'bg-gradient-to-r from-blue-50 to-cyan-50 text-blue-600 border-blue-100/50 shadow-sm' : 'text-slate-500 border-transparent hover:bg-white hover:text-slate-700 hover:border-slate-100' }}">
                    @if(request()->is('mutasi-rekening')) <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-blue-600 rounded-r-full"></div> @endif
                    <svg class="w-5 h-5 ml-1 relative z-10 {{ request()->is('mutasi-rekening') ? '' : 'opacity-60 group-hover:opacity-100 group-hover:scale-110 group-hover:text-blue-500 transition-all' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    <span class="relative z-10">Mutasi Rekening</span>
                </a>
            </nav>
        </div>

        <div class="p-5 relative z-10 mb-2">
            <div class="bg-slate-50/80 rounded-2xl p-4 border border-slate-100 shadow-inner">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-[0.8rem] bg-indigo-100 text-indigo-600 flex items-center justify-center font-extrabold text-lg shadow-sm border border-white">
                        A
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-700">Administrator</p>
                        <div class="flex items-center gap-1.5 mt-0.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-wide">Sedang Aktif</p>
                        </div>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-slate-600 font-bold hover:bg-red-50 hover:text-red-600 transition-all border border-transparent hover:border-red-100 group bg-white shadow-sm">
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Keluar Sistem
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div class="flex-1 flex flex-col h-screen overflow-hidden relative z-10 animate-fade-content">
        
        <header class="h-24 flex items-center justify-between px-8 lg:px-12 shrink-0">
            <div class="flex items-center gap-4">
                <button class="md:hidden p-2 text-slate-500 hover:bg-white rounded-xl shadow-sm transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="hidden sm:block">
                    <h2 class="text-2xl font-extrabold text-slate-700 tracking-tight">Sistem Simpan Pinjam</h2>
                    <p class="text-sm font-semibold text-slate-400 mt-0.5">Kelola arus kas dengan cerdas dan aman.</p>
                </div>
            </div>
            
            <div class="flex items-center gap-5">
                <div class="hidden sm:flex items-center gap-2.5 px-5 py-2.5 bg-white/60 backdrop-blur-md border border-slate-200/50 rounded-2xl shadow-sm cursor-default hover:bg-white transition-colors">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="text-sm font-bold text-slate-600 tracking-wide">{{ \Carbon\Carbon::now()->translatedFormat('d M Y') }}</span>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto px-8 lg:px-12 pb-12">
            <div class="max-w-7xl mx-auto h-full">
                {{ $slot }}
            </div>
        </main>
        
    </div>

    @livewireScripts
</body>
</html>
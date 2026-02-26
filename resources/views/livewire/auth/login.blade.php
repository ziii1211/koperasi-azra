<div class="min-h-screen flex items-center justify-center bg-[#F0F4F8] p-6 relative overflow-hidden font-sans">
    
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-[10%] -left-[10%] w-[600px] h-[600px] opacity-[0.08] animate-float-slow text-indigo-600">
            <svg viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full"><path d="M0 300L50 250C100 200 200 100 300 150C400 200 500 400 600 350" stroke="currentColor" stroke-width="40" stroke-linecap="round" class="path-grow"/></svg>
        </div>
        <div class="absolute -bottom-[20%] -right-[15%] w-[700px] h-[700px] opacity-[0.08] animate-float-medium text-emerald-600 animation-delay-2000">
            <svg viewBox="0 0 400 400" fill="currentColor" xmlns="http://www.w3.org/2000/svg" class="w-full h-full"><circle cx="200" cy="200" r="150"/></svg>
        </div>
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-50/40 via-white/0 to-emerald-50/40 backdrop-blur-[1px]"></div>
    </div>


    <div class="w-full max-w-[440px] bg-white/70 backdrop-blur-3xl rounded-[2.5rem] shadow-[0_30px_60px_-15px_rgba(0,0,0,0.1),0_0_0_1px_rgba(255,255,255,0.5)_inset] p-10 relative z-10 animate-entrance-card">
        
        <div class="text-center mb-10 relative">
             <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-32 bg-indigo-400/30 rounded-full blur-3xl -z-10 animate-pulse-slow"></div>
            
            <div class="w-24 h-24 bg-gradient-to-tr from-slate-800 to-indigo-900 rounded-[2rem] mx-auto flex items-center justify-center shadow-2xl shadow-indigo-900/20 mb-6 relative group overflow-hidden ring-4 ring-white">
                 <div class="absolute inset-0 bg-gradient-to-tr from-white/0 via-white/20 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                
                <svg class="w-12 h-12 text-indigo-100 relative z-10 drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01" class="text-emerald-400 animate-pulse"/>
                    <circle cx="12" cy="14" r="2" fill="currentColor" class="text-emerald-300" />
                </svg>
            </div>
            <h2 class="text-[2rem] font-extrabold text-slate-800 tracking-tight leading-tight">Koperasi Azra</h2>
            <p class="text-slate-500 font-medium text-base mt-2">Portal Aman Pengelolaan Dana</p>
        </div>

        <form wire:submit.prevent="prosesLogin" class="space-y-7">
            
            @error('name')
                <div class="p-4 bg-red-50/80 border border-red-200/50 rounded-2xl text-sm font-semibold text-red-700 flex items-start gap-3 animate-shake backdrop-blur-md shadow-sm">
                    <svg class="w-5 h-5 shrink-0 mt-0.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div>Letak kesalahan: <span class="block font-bold">{{ $message }}</span></div>
                </div>
            @enderror

            <div class="space-y-2 group">
                <label class="block text-sm font-bold text-slate-700 ml-2 tracking-wide">ID / Nama Pengguna</label>
                <div class="relative transition-all duration-300 focus-within:scale-[1.02]">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none transition-colors group-focus-within:text-indigo-600 text-slate-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .667.333 1 1 1h2c.667 0 1-.333 1-1m-5 6h.01m-1.01 4h.01M15 11h.01M15 15h.01" />
                        </svg>
                    </div>
                    <input type="text" wire:model="name" class="w-full pl-14 pr-4 py-4 bg-white/60 border-2 border-slate-100 rounded-2xl text-slate-800 font-bold placeholder:text-slate-400 placeholder:font-medium focus:ring-0 focus:border-indigo-500 focus:bg-white/90 transition-all outline-none shadow-sm" placeholder="Masukkan nama terdaftar..." required>
                </div>
            </div>

            <div class="space-y-2 group">
                 <label class="block text-sm font-bold text-slate-700 ml-2 tracking-wide">Kode Keamanan</label>
                <div class="relative transition-all duration-300 focus-within:scale-[1.02]">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none transition-colors group-focus-within:text-indigo-600 text-slate-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v.01M12 12v.01" class="text-indigo-600"/>
                        </svg>
                    </div>
                    <input type="password" wire:model="password" class="w-full pl-14 pr-4 py-4 bg-white/60 border-2 border-slate-100 rounded-2xl text-slate-800 font-bold placeholder:text-slate-400 placeholder:font-medium focus:ring-0 focus:border-indigo-500 focus:bg-white/90 transition-all outline-none shadow-sm" placeholder="••••••••" required>
                </div>
            </div>

            <div class="flex items-center justify-between ml-1">
                <div class="flex items-center">
                    <input id="remember" type="checkbox" wire:model="remember" class="w-5 h-5 text-indigo-600 bg-white border-2 border-slate-300 rounded-[0.4rem] focus:ring-offset-0 focus:ring-2 focus:ring-indigo-500 cursor-pointer transition-all checked:bg-indigo-600 checked:border-transparent">
                    <label for="remember" class="ml-3 text-sm font-bold text-slate-600 cursor-pointer select-none">Ingat perangkat ini</label>
                </div>
                <a href="#" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition-colors">Bantuan Akses?</a>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-slate-800 via-indigo-900 to-slate-900 hover:from-indigo-900 hover:to-slate-900 text-white font-bold py-4 rounded-2xl shadow-[0_10px_30px_rgba(30,_58,_138,_0.3)] hover:shadow-[0_15px_35px_rgba(30,_58,_138,_0.4)] hover:-translate-y-1 transition-all duration-300 flex justify-center items-center gap-3 group mt-6 relative overflow-hidden">
                 <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-[150%] group-hover:translate-x-[150%] transition-transform duration-700 ease-in-out"></div>
                
                <span wire:loading.remove wire:target="prosesLogin" class="tracking-wider text-lg relative z-10">Masuk Aplikasi</span>
                <span wire:loading wire:target="prosesLogin" class="tracking-wider text-lg relative z-10 flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5 text-indigo-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Memverifikasi Kredensial...
                </span>
                <svg wire:loading.remove wire:target="prosesLogin" class="w-6 h-6 group-hover:translate-x-1 transition-transform relative z-10 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
            </button>
        </form>
    </div>
    
    <style>
        @keyframes float-slow {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(20px, 30px) rotate(5deg); }
        }
        @keyframes float-medium {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-30px, 20px) scale(1.05); }
        }
        @keyframes entrance-card {
            0% { opacity: 0; transform: translateY(40px) scale(0.95); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-3px); }
            20%, 40%, 60%, 80% { transform: translateX(3px); }
        }
        .animate-float-slow { animation: float-slow 15s ease-in-out infinite; }
        .animate-float-medium { animation: float-medium 12s ease-in-out infinite; }
        .animate-entrance-card { animation: entrance-card 0.8s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
        .animate-shake { animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animate-pulse-slow { animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
    </style>
</div>
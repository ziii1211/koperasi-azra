<div class="min-h-screen flex items-center justify-center p-6 relative overflow-hidden font-sans bg-slate-50">
    
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[500px] h-[500px] bg-indigo-400/50 rounded-full mix-blend-multiply filter blur-[120px] animate-blob"></div>
        <div class="absolute top-[20%] -right-[10%] w-[500px] h-[500px] bg-emerald-300/50 rounded-full mix-blend-multiply filter blur-[120px] animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-[20%] left-[20%] w-[600px] h-[600px] bg-purple-400/50 rounded-full mix-blend-multiply filter blur-[120px] animate-blob animation-delay-4000"></div>
        
        <div class="absolute inset-0 bg-white/30 backdrop-blur-[60px]"></div>
        
        <div class="absolute inset-0 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px] opacity-40"></div>
    </div>

    <div class="w-full max-w-[420px] bg-white/70 backdrop-blur-2xl rounded-[2.5rem] shadow-[0_20px_40px_-15px_rgba(0,0,0,0.05),0_0_0_1px_rgba(255,255,255,0.6)_inset] p-10 relative z-10 animate-entrance-card border border-white/60">
        
        <div class="text-center mb-10 relative">
            <div class="w-20 h-20 bg-gradient-to-tr from-slate-900 via-indigo-900 to-slate-800 rounded-[1.5rem] mx-auto flex items-center justify-center shadow-xl shadow-indigo-900/30 mb-6 relative group overflow-hidden border-2 border-white/50 ring-4 ring-indigo-50/50">
                 <div class="absolute inset-0 bg-gradient-to-tr from-white/0 via-white/30 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-in-out"></div>
                
                <svg class="w-10 h-10 text-white relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Koperasi Azra</h2>
            <p class="text-slate-500 font-semibold text-sm mt-2">Portal Aman Pengelolaan Dana</p>
        </div>

        <form wire:submit.prevent="prosesLogin" class="space-y-6">
            
            @error('name')
                <div class="p-4 bg-red-50/90 border border-red-200 rounded-2xl text-sm font-semibold text-red-600 flex items-start gap-3 animate-shake shadow-sm">
                    <svg class="w-5 h-5 shrink-0 mt-0.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div><span class="block">{{ $message }}</span></div>
                </div>
            @enderror

            <div class="space-y-1.5 group">
                <label class="block text-xs font-bold text-slate-500 ml-1 uppercase tracking-wider">Nama Pengguna</label>
                <div class="relative transition-all duration-300">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors text-slate-400 group-focus-within:text-indigo-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input type="text" wire:model="name" class="w-full pl-11 pr-4 py-3.5 bg-white/50 border-2 border-slate-100/80 rounded-2xl text-slate-800 font-bold placeholder:text-slate-400 placeholder:font-medium focus:ring-0 focus:border-indigo-500 focus:bg-white transition-all outline-none shadow-sm backdrop-blur-sm" placeholder="Masukkan nama..." required>
                </div>
            </div>

            <div class="space-y-1.5 group">
                 <div class="flex items-center justify-between ml-1">
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Kata Sandi</label>
                     <a href="#" class="text-xs font-bold text-indigo-500 hover:text-indigo-700 transition-colors">Lupa Sandi?</a>
                 </div>
                <div class="relative transition-all duration-300">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors text-slate-400 group-focus-within:text-indigo-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" wire:model="password" class="w-full pl-11 pr-4 py-3.5 bg-white/50 border-2 border-slate-100/80 rounded-2xl text-slate-800 font-bold placeholder:text-slate-400 placeholder:font-medium focus:ring-0 focus:border-indigo-500 focus:bg-white transition-all outline-none shadow-sm backdrop-blur-sm" placeholder="••••••••" required>
                </div>
            </div>

            <div class="flex items-center ml-1 pb-2">
                <div class="relative flex items-center">
                    <input id="remember" type="checkbox" wire:model="remember" class="peer w-5 h-5 appearance-none border-2 border-slate-200 rounded-md bg-white/50 checked:bg-indigo-600 checked:border-indigo-600 transition-all cursor-pointer">
                    <svg class="absolute w-3.5 h-3.5 left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 pointer-events-none opacity-0 peer-checked:opacity-100 text-white transition-opacity" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <label for="remember" class="ml-2.5 text-sm font-bold text-slate-600 cursor-pointer select-none hover:text-slate-800 transition-colors">Ingat sesi ini</label>
            </div>

            <div class="relative group mt-4">
                <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-emerald-400 rounded-2xl blur opacity-30 group-hover:opacity-100 transition duration-500 group-hover:duration-200 animate-gradient-xy"></div>
                
                <button type="submit" class="relative w-full flex items-center justify-center gap-3 bg-slate-900 text-white font-bold py-4 rounded-xl transition-all duration-300 hover:bg-slate-800 overflow-hidden">
                    
                    <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-[150%] group-hover:translate-x-[150%] transition-transform duration-700 ease-in-out"></div>
                    
                    <span wire:loading.remove wire:target="prosesLogin" class="tracking-wide text-[1.05rem] relative z-10">Akses Dasbor</span>
                    
                    <span wire:loading wire:target="prosesLogin" class="tracking-wide text-[1.05rem] relative z-10 flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Memverifikasi...
                    </span>
                    
                    <svg wire:loading.remove wire:target="prosesLogin" class="w-5 h-5 group-hover:translate-x-1.5 transition-transform duration-300 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </form>
    </div>
    
    <style>
        /* Animasi Fluid & Glow */
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        @keyframes gradient-xy {
            0%, 100% { background-size: 400% 400%; background-position: left center; }
            50% { background-size: 200% 200%; background-position: right center; }
        }
        @keyframes entrance-card {
            0% { opacity: 0; transform: translateY(30px) scale(0.95); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-3px); }
            20%, 40%, 60%, 80% { transform: translateX(3px); }
        }
        
        /* Utilitas Kelas Animasi */
        .animate-blob { animation: blob 8s infinite cubic-bezier(0.4, 0, 0.2, 1); }
        .animate-gradient-xy { animation: gradient-xy 4s ease infinite; }
        .animate-entrance-card { animation: entrance-card 0.8s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
        .animate-shake { animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
    </style>
</div>
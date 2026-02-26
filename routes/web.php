<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Auth\Login;
use App\Livewire\BukuKasModal;
use App\Livewire\DataPeminjam;
use App\Livewire\TagihanAngsuran;
use App\Livewire\MutasiRekening;


// Jika user mengakses rute awal, otomatis arahkan ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Halaman Login (Hanya bisa diakses jika belum login)
Route::get('/login', Login::class)->name('login')->middleware('guest');

// Proses Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// Halaman Dashboard Utama (HARUS login dulu baru bisa diakses)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', BukuKasModal::class)->name('dashboard');
    Route::get('/data-peminjam', DataPeminjam::class)->name('data-peminjam');
    Route::get('/tagihan-angsuran', TagihanAngsuran::class)->name('tagihan-angsuran');
    Route::get('/mutasi-rekening', MutasiRekening::class)->name('mutasi-rekening');
 
});
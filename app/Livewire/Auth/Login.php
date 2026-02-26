<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    // Menggunakan name, bukan email
    public $name = '';
    public $password = '';
    public $remember = false;

    public function prosesLogin()
    {
        // Validasi input
        $credentials = $this->validate([
            'name' => 'required|string',
            'password' => 'required',
        ]);

        // Cek kecocokan data nama dan password di database
        if (Auth::attempt($credentials, $this->remember)) {
            session()->regenerate();
            
            // Arahkan ke dashboard jika sukses
            return redirect()->intended('/dashboard');
        }

        // Jika gagal, munculkan error
        $this->addError('name', 'Nama Pengguna atau Kata Sandi salah.');
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->title('Login - Koperasi Azra')
            ->layout('components.layouts.guest');
    }
}
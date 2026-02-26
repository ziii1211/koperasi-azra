<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun Admin default
        User::create([
            'name' => 'Admin',
            'email' => 'admin@koperasi.com',
            'password' => Hash::make('password123'), // Passwordnya: password123
        ]);
    }
}
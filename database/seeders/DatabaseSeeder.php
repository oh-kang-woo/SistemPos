<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // <-- PASTIKAN BARIS INI ADA!

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat Akun Master Manajer
        User::create([
            'name' => 'Owner / Manajer Toko',
            'email' => 'admin@toko.com',
            'password' => Hash::make('password123'),
            'role' => 'manajer',
            'phone_number' => '081234567890',
        ]);
    }
}

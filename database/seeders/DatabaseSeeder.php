<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. AKUN MANAJER (OWNER)
        User::create([
            'name' => 'Owner / Manajer Toko',
            'email' => 'admin@toko.com',
            'password' => Hash::make('password123'),
            'phone_number' => '081234567890',
            'role' => 'manajer',
        ]);

        // 2. AKUN KARYAWAN (KASIR)
        User::create([
            'name' => 'xero',
            'email' => 'xero@toko.com',
            'password' => Hash::make('kasir123'),
            'phone_number' => '089876543210',
            'role' => 'karyawan',
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::create([
            'nama_toko' => 'Cafe Simpang MI',
            'alamat_lengkap' => 'Jl. Merdeka Kendari, KM.14, C',
            'nomor_telepon' => '+62',
            'nomor_whatsapp' => '+62',
            'format_nomor_transaksi' => 'Contoh: DD-MM-YYYY',
            'reset_nomor_urut' => 'reset_bulan',
            'ukuran_kertas' => 'Thermal 88mm',
            'margin' => 5,
            'cetak_otomatis' => false
        ]);
    }
}

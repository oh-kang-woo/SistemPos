<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    // Mengizinkan semua kolom untuk disimpan (termasuk business_id yang baru ditambahkan)
    protected $guarded = [];

    /**
     * Boot system untuk model Setting.
     * Mengatur nilai default 'Swiftbill' jika nama_toko tidak diisi saat pertama kali dibuat.
     */
    protected static function booted()
    {
        static::creating(function ($setting) {
            if (empty($setting->nama_toko)) {
                $setting->nama_toko = 'Swiftbill';
            }
        });
    }
}

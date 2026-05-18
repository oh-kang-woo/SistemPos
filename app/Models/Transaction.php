<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_transaksi';

    // Menggunakan guarded kosong agar semua inputan dinamis (termasuk kolom nama_pelanggan & metode_pembayaran) tidak diblokir Laravel
    protected $guarded = [];

    /**
     * Relasi ke model User (Kasir yang membuat transaksi)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relasi ke model TransactionDetail (Isi barang belanjaan)
     */
    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'transaksi_id', 'id_transaksi');
    }
}

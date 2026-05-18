<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Tentukan primary key asli sesuai migrasi kamu
    protected $primaryKey = 'id_transaksi';

    // Daftarkan kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'business_id',
        'user_id',
        'nomor_invoice',
        'total_harga',
        'bayar',
        'kembali',
    ];

    /**
     * Relasi ke model User (Kasir yang membuat transaksi)
     * Menghubungkan user_id di tabel transactions ke id di tabel users
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relasi ke model TransactionDetail (Isi barang belanjaan)
     * Menghubungkan id_transaksi ke transaksi_id di tabel detail
     */
    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'transaksi_id', 'id_transaksi');
    }
}

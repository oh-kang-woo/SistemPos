<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_transaksi';
    protected $guarded = ['id_transaksi'];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'transaksi_id', 'id_transaksi');
    }

}

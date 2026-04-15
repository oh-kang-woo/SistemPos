<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_detail';
    protected $guarded = ['id_detail'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaksi_id', 'id_transaksi');
    }
}

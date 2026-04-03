<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'id_produk';

    protected $guarded = ['id_produk'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id', 'id_kategori');
    }
}

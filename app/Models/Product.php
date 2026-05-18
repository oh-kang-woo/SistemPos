<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'id_produk';

    protected $guarded = ['id_produk'];

    /**
     * Relasi: Produk ini milik toko/bisnis yang mana
     */
    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id', 'id');
    }

    /**
     * Relasi: Produk ini termasuk dalam kategori apa
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id', 'id_kategori');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_kategori';
    protected $guarded = ['id_kategori'];

    public function products()
    {
        return $this->hasMany(Product::class, 'kategori_id', 'id_kategori');
    }
}

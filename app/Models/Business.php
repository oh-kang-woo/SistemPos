<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Business extends Model
{
    protected $fillable = ['name'];

    // Relasi: Satu bisnis punya banyak user (Manajer + Karyawan)
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}

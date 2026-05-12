<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kategori',
    ];

    // Relasi: Satu kategori memiliki banyak bahan baku
    public function bahanBakus(): HasMany
    {
        return $this->hasMany(BahanBaku::class, 'kategori_id');
    }
}

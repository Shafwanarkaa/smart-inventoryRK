<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_supplier',
        'kontak',
        'no_telp',
    ];

    // Relasi: Satu supplier menyediakan banyak bahan baku
    public function bahanBakus(): HasMany
    {
        return $this->hasMany(BahanBaku::class, 'supplier_id');
    }
}

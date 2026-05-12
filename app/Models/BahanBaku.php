<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BahanBaku extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_id',
        'supplier_id',
        'nama_bahan',
        'satuan',
        'stok_saat_ini',
        'nilai_c1',
        'nilai_c2',
        'nilai_c3',
        'skor_saw',
    ];

    protected $casts = [
        'stok_saat_ini' => 'integer',
        'nilai_c1' => 'integer',
        'nilai_c2' => 'integer',
        'nilai_c3' => 'integer',
        'skor_saw' => 'float',
    ];

    // Relasi: Bahan baku milik satu kategori
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // Relasi: Bahan baku dipasok oleh satu supplier
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    // Helper untuk status stok
    public function getStatusStokAttribute(): string
    {
        if ($this->stok_saat_ini <= 10) {
            return 'Kritis';
        } elseif ($this->stok_saat_ini <= 50) {
            return 'Rendah';
        }
        return 'Aman';
    }

    // Helper untuk badge color status
    public function getStatusColorAttribute(): string
    {
        $status = $this->status_stok;
        return match ($status) {
            'Kritis' => 'bg-red-100 text-red-800',
            'Rendah' => 'bg-yellow-100 text-yellow-800',
            'Aman' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}

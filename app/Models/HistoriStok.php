<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoriStok extends Model
{
    protected $table = 'histori_stok';

    protected $fillable = [
        'bahan_baku_id',
        'user_id',
        'stok_sebelum',
        'stok_sesudah',
        'selisih',
        'keterangan',
    ];

    protected $casts = [
        'stok_sebelum' => 'integer',
        'stok_sesudah' => 'integer',
        'selisih'      => 'integer',
    ];

    public function bahanBaku(): BelongsTo
    {
        return $this->belongsTo(BahanBaku::class, 'bahan_baku_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Helper: label arah perubahan
    public function getArahAttribute(): string
    {
        if ($this->selisih > 0) return 'Naik';
        if ($this->selisih < 0) return 'Turun';
        return 'Tidak Berubah';
    }

    // Helper: warna badge arah
    public function getArahColorAttribute(): string
    {
        if ($this->selisih > 0) return 'bg-green-100 text-green-800';
        if ($this->selisih < 0) return 'bg-red-100 text-red-800';
        return 'bg-gray-100 text-gray-600';
    }
}

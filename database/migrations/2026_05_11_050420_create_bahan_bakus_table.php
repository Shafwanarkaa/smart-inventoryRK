<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bahan_bakus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->string('nama_bahan');
            $table->string('satuan');
            $table->integer('stok_saat_ini')->default(0);
            $table->integer('nilai_c1')->default(0)->comment('Sisa Stok (COST)');
            $table->integer('nilai_c2')->default(0)->comment('Tingkat Kadaluarsa (BENEFIT)');
            $table->integer('nilai_c3')->default(0)->comment('Batas Kebutuhan Harian (BENEFIT)');
            $table->float('skor_saw', 8, 4)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bahan_bakus');
    }
};

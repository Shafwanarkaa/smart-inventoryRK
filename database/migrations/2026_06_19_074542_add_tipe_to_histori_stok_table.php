<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('histori_stok', function (Blueprint $table) {
            $table->enum('tipe', ['pemakaian', 'pembelian'])
                  ->default('pemakaian')
                  ->after('selisih')
                  ->comment('pemakaian = koki kurangi stok, pembelian = manajer tambah stok');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('histori_stok', function (Blueprint $table) {
            $table->dropColumn('tipe');
        });
    }
};

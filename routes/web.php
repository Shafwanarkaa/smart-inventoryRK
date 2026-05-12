<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SpkController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\OperasionalController;

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ========================================
// GROUP OPERASIONAL (Koki/Staff)
// ========================================
Route::middleware(['auth', 'operasional'])->prefix('operasional')->name('operasional.')->group(function () {

    // Halaman Update Stok Harian
    Route::get('/stok', [OperasionalController::class, 'index'])->name('stok');
    Route::get('/stok/{id}/edit', [OperasionalController::class, 'edit'])->name('stok.edit');
    Route::put('/stok/{id}', [OperasionalController::class, 'update'])->name('stok.update');
});

// ========================================
// GROUP MANAJER
// ========================================
Route::middleware(['auth', 'manajer'])->prefix('manajer')->name('manajer.')->group(function () {

    // Dashboard & Ranking SAW
    Route::get('/dashboard', [SpkController::class, 'dashboard'])->name('dashboard');
    Route::post('/hitung-saw', [SpkController::class, 'hitungSAW'])->name('hitung-saw');

    // CRUD Kategori
    Route::resource('kategori', KategoriController::class);

    // CRUD Supplier
    Route::resource('supplier', SupplierController::class);

    // CRUD Bahan Baku
    Route::resource('bahan-baku', BahanBakuController::class);
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SpkController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\OperasionalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HistoriStokController;

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
// GANTI PASSWORD (Semua Role)
// ========================================
Route::middleware('auth')->prefix('profil')->name('profil.')->group(function () {
    Route::get('/ubah-password', [ProfileController::class, 'showUbahPassword'])->name('ubah-password');
    Route::post('/ubah-password', [ProfileController::class, 'ubahPassword'])->name('ubah-password.post');
});

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
// GROUP MANAJER (termasuk Super Admin)
// ========================================
Route::middleware(['auth', 'manajer'])->prefix('manajer')->name('manajer.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [SpkController::class, 'dashboard'])->name('dashboard');

    // Ranking SAW
    Route::get('/ranking-saw', [SpkController::class, 'rankingSAW'])->name('ranking-saw');
    Route::post('/hitung-saw', [SpkController::class, 'hitungSAW'])->name('hitung-saw');

    // Peringatan Stok
    Route::get('/peringatan-stok', [SpkController::class, 'peringatanStok'])->name('peringatan-stok');

    // CRUD Kategori
    Route::resource('kategori', KategoriController::class);

    // CRUD Supplier
    Route::resource('supplier', SupplierController::class);

    // CRUD Bahan Baku
    Route::resource('bahan-baku', BahanBakuController::class);

    // Kelola User (Manajer)
    Route::resource('users', UserController::class)->except(['show']);

    // Histori Transaksi Stok (sementara disembunyikan)
    // Route::get('/histori-stok', [HistoriStokController::class, 'index'])->name('histori-stok');
});
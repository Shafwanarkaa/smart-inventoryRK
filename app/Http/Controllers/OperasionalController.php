<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;

class OperasionalController extends Controller
{
    /**
     * Tampilkan daftar stok untuk update harian
     */
    public function index(Request $request)
    {
        $query = BahanBaku::with(['kategori', 'supplier']);

        // Filter berdasarkan kategori
        if ($request->filled('kategori_id') && $request->kategori_id != '') {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Search berdasarkan nama bahan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_bahan', 'like', "%{$search}%");
        }

        $bahanBakus = $query->orderBy('nama_bahan')->paginate(20);

        return view('operasional.stok.index', compact('bahanBakus'));
    }

    /**
     * Form edit stok
     */
    public function edit($id)
    {
        $bahan = BahanBaku::with(['kategori', 'supplier'])->findOrFail($id);
        return view('operasional.stok.edit', compact('bahan'));
    }

    /**
     * Update stok harian (C1 otomatis = stok_saat_ini)
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'stok_saat_ini' => 'required|integer|min:0',
    ]);

    $bahan = BahanBaku::findOrFail($id);
    
    // Koki CUMA update stok_saat_ini
    // C1, C2, C3 TIDAK DISENTUH (diurus Manajer)
    $bahan->update([
        'stok_saat_ini' => $request->stok_saat_ini,
        // HAPUS: 'nilai_c1' => $request->stok_saat_ini,
    ]);

    return redirect()->route('operasional.stok')
        ->with('success', 'Stok berhasil diperbarui untuk ' . $bahan->nama_bahan);
}
}
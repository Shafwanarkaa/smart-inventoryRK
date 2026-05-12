<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;

class OperasionalController extends Controller
{
    /**
     * Tampilkan daftar stok untuk update harian
     */
    public function index()
    {
        $bahanBakus = BahanBaku::with(['kategori', 'supplier'])
            ->orderBy('nama_bahan')
            ->paginate(15);

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
     * Update stok harian
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'stok_saat_ini' => 'required|integer|min:0',
            'nilai_c1' => 'required|integer|min:0',
        ]);

        $bahan = BahanBaku::findOrFail($id);

        $bahan->update([
            'stok_saat_ini' => $request->stok_saat_ini,
            'nilai_c1' => $request->nilai_c1,
        ]);

        return redirect()->route('operasional.stok')
            ->with('success', 'Stok berhasil diperbarui untuk ' . $bahan->nama_bahan);
    }
}

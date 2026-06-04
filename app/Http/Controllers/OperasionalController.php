<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use App\Models\HistoriStok;
use Illuminate\Support\Facades\Auth;

class OperasionalController extends Controller
{
    /**
     * Tampilkan daftar stok untuk update harian
     */
    public function index(Request $request)
    {
        $query = BahanBaku::with(['kategori', 'supplier']);

        if ($request->filled('kategori_id') && $request->kategori_id != '') {
            $query->where('kategori_id', $request->kategori_id);
        }

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
     * Update stok harian + catat histori
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'stok_saat_ini' => 'required|integer|min:0',
            'keterangan'    => 'nullable|string|max:200',
        ]);

        $bahan        = BahanBaku::findOrFail($id);
        $stokSebelum  = $bahan->stok_saat_ini;
        $stokSesudah  = $request->stok_saat_ini;
        $selisih      = $stokSesudah - $stokSebelum;

        // Update stok
        $bahan->update(['stok_saat_ini' => $stokSesudah]);

        // Catat histori (selalu dicatat, termasuk jika tidak berubah)
        HistoriStok::create([
            'bahan_baku_id' => $bahan->id,
            'user_id'       => Auth::id(),
            'stok_sebelum'  => $stokSebelum,
            'stok_sesudah'  => $stokSesudah,
            'selisih'       => $selisih,
            'keterangan'    => $request->keterangan,
        ]);

        return redirect()->route('operasional.stok')
            ->with('success', "Stok {$bahan->nama_bahan} berhasil diperbarui ({$stokSebelum} → {$stokSesudah}).");
    }
}
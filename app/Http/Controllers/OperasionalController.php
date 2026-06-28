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
     * Catat pemakaian harian (stok berkurang)
     */
    public function update(Request $request, $id)
    {
        $bahan = BahanBaku::findOrFail($id);

        $request->validate([
            'jumlah_pemakaian' => [
                'required', 'integer', 'min:1',
                "max:{$bahan->stok_saat_ini}",
            ],
            'keterangan' => 'nullable|string|max:200',
        ], [
            'jumlah_pemakaian.max' => "Jumlah pemakaian tidak boleh melebihi stok tersedia ({$bahan->stok_saat_ini} {$bahan->satuan}).",
            'jumlah_pemakaian.min' => 'Jumlah pemakaian minimal 1.',
        ]);

        $stokSebelum  = $bahan->stok_saat_ini;
        $jumlah       = (int) $request->jumlah_pemakaian;
        $stokSesudah  = $stokSebelum - $jumlah;

        // Kurangi stok
        $bahan->update(['stok_saat_ini' => $stokSesudah]);

        // Catat histori dengan tipe 'pemakaian'
        HistoriStok::create([
            'bahan_baku_id' => $bahan->id,
            'user_id'       => Auth::id(),
            'stok_sebelum'  => $stokSebelum,
            'stok_sesudah'  => $stokSesudah,
            'selisih'       => -$jumlah,
            'tipe'          => 'pemakaian',
            'keterangan'    => $request->keterangan,
        ]);

        return redirect()->route('operasional.stok')
            ->with('success', "Pemakaian {$bahan->nama_bahan} berhasil dicatat. Stok: {$stokSebelum} → {$stokSesudah} {$bahan->satuan}.");
    }
}
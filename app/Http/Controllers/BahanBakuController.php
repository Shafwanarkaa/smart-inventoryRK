<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use App\Models\Kategori;
use App\Models\Supplier;

class BahanBakuController extends Controller
{
    public function index()
    {
        $bahanBakus = BahanBaku::with(['kategori', 'supplier'])
            ->orderBy('nama_bahan')
            ->paginate(15);

        return view('manajer.bahan-baku.index', compact('bahanBakus'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        $suppliers = Supplier::all();
        return view('manajer.bahan-baku.create', compact('kategoris', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'nama_bahan' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'stok_saat_ini' => 'required|integer|min:0',
            'nilai_c1' => 'required|integer|min:0',
            'nilai_c2' => 'required|integer|min:0',
            'nilai_c3' => 'required|integer|min:0',
        ]);

        BahanBaku::create($request->all());

        return redirect()->route('manajer.bahan-baku.index')
            ->with('success', 'Bahan baku berhasil ditambahkan.');
    }

    public function edit(BahanBaku $bahanBaku)
    {
        $kategoris = Kategori::all();
        $suppliers = Supplier::all();
        return view('manajer.bahan-baku.edit', compact('bahanBaku', 'kategoris', 'suppliers'));
    }

    public function update(Request $request, BahanBaku $bahanBaku)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'nama_bahan' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'stok_saat_ini' => 'required|integer|min:0',
            'nilai_c1' => 'required|integer|min:0',
            'nilai_c2' => 'required|integer|min:0',
            'nilai_c3' => 'required|integer|min:0',
        ]);

        $bahanBaku->update($request->all());

        return redirect()->route('manajer.bahan-baku.index')
            ->with('success', 'Bahan baku berhasil diperbarui.');
    }

    public function destroy(BahanBaku $bahanBaku)
    {
        $bahanBaku->delete();

        return redirect()->route('manajer.bahan-baku.index')
            ->with('success', 'Bahan baku berhasil dihapus.');
    }
}

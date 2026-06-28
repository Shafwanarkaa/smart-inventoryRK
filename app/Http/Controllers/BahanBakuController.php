<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\HistoriStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BahanBakuController extends Controller
{
    public function index(Request $request)
    {
        $query = BahanBaku::with(['kategori', 'supplier']);

        // Filter berdasarkan kategori
        if ($request->filled('kategori_id') && $request->kategori_id != '') {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Search berdasarkan nama bahan, kategori, atau supplier
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_bahan', 'like', "%{$search}%")
                  ->orWhereHas('kategori', function($q) use ($search) {
                      $q->where('nama_kategori', 'like', "%{$search}%");
                  })
                  ->orWhereHas('supplier', function($q) use ($search) {
                      $q->where('nama_supplier', 'like', "%{$search}%");
                  });
            });
        }

        $bahanBakus = $query->orderBy('nama_bahan')->paginate(20);
        $kategoris = \App\Models\Kategori::all();

        return view('manajer.bahan-baku.index', compact('bahanBakus', 'kategoris'));
    }

    public function create()
    {
        $kategoris = \App\Models\Kategori::all();
        $suppliers = \App\Models\Supplier::all();
        return view('manajer.bahan-baku.create', compact('kategoris', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bahan'   => 'required|string|max:255',
            'kategori_id'  => 'required|exists:kategoris,id',
            'supplier_id'  => 'required|exists:suppliers,id',
            'satuan'       => 'required|string|max:50',
            'stok_saat_ini'=> 'required|numeric|min:0',
            'nilai_c1'     => 'required|numeric',
            'nilai_c2'     => 'required|numeric',
            'nilai_c3'     => 'required|numeric',
        ]);

        BahanBaku::create($request->all());

        return redirect()->route('manajer.bahan-baku.index')
                         ->with('success', 'Bahan baku berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $bahanBaku = BahanBaku::findOrFail($id);
        $kategoris = \App\Models\Kategori::all();
        $suppliers = \App\Models\Supplier::all();
        return view('manajer.bahan-baku.edit', compact('bahanBaku', 'kategoris', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $bahanBaku = BahanBaku::findOrFail($id);

        $request->validate([
            'nama_bahan'   => 'required|string|max:255',
            'kategori_id'  => 'required|exists:kategoris,id',
            'supplier_id'  => 'required|exists:suppliers,id',
            'satuan'       => 'required|string|max:50',
            'stok_saat_ini'=> 'required|numeric|min:0',
            'nilai_c1'     => 'required|numeric',
            'nilai_c2'     => 'required|numeric',
            'nilai_c3'     => 'required|numeric',
        ]);

        $bahanBaku->update($request->all());

        return redirect()->route('manajer.bahan-baku.index')
                         ->with('success', 'Bahan baku berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $bahanBaku = BahanBaku::findOrFail($id);
        $bahanBaku->delete();

        return redirect()->route('manajer.bahan-baku.index')
                         ->with('success', 'Bahan baku berhasil dihapus.');
    }

    /**
     * Manajer tambah stok pembelian (stok bertambah)
     */
    public function tambahStok(Request $request, $id)
    {
        $bahan = BahanBaku::findOrFail($id);

        $request->validate([
            'jumlah_pembelian' => 'required|integer|min:1',
            'keterangan'       => 'nullable|string|max:200',
        ], [
            'jumlah_pembelian.min' => 'Jumlah pembelian minimal 1.',
        ]);

        $stokSebelum = $bahan->stok_saat_ini;
        $jumlah      = (int) $request->jumlah_pembelian;
        $stokSesudah = $stokSebelum + $jumlah;

        // Tambah stok
        $bahan->update(['stok_saat_ini' => $stokSesudah]);

        // Catat histori dengan tipe 'pembelian'
        HistoriStok::create([
            'bahan_baku_id' => $bahan->id,
            'user_id'       => Auth::id(),
            'stok_sebelum'  => $stokSebelum,
            'stok_sesudah'  => $stokSesudah,
            'selisih'       => +$jumlah,
            'tipe'          => 'pembelian',
            'keterangan'    => $request->keterangan,
        ]);

        return redirect()->route('manajer.bahan-baku.index')
            ->with('success', "Pembelian {$bahan->nama_bahan} berhasil dicatat. Stok: {$stokSebelum} → {$stokSesudah} {$bahan->satuan}.");
    }
}
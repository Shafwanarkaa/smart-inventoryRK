<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::withCount('bahanBakus')->get();
        return view('manajer.supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('manajer.supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:255',
            'no_telp' => 'required|string|max:20',
        ]);

        Supplier::create($request->all());

        return redirect()->route('manajer.supplier.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit(Supplier $supplier)
    {
        return view('manajer.supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:255',
            'no_telp' => 'required|string|max:20',
        ]);

        $supplier->update($request->all());

        return redirect()->route('manajer.supplier.index')
            ->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier)
    {
        if ($supplier->bahanBakus()->count() > 0) {
            return back()->with('error', 'Supplier tidak dapat dihapus karena masih memiliki bahan baku.');
        }

        $supplier->delete();

        return redirect()->route('manajer.supplier.index')
            ->with('success', 'Supplier berhasil dihapus.');
    }
}

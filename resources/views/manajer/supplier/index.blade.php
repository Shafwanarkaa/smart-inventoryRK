@extends('layouts.app')

@section('title', 'Supplier')
@section('page-title', 'Supplier')
@section('page-subtitle', 'Kelola data supplier bahan baku.')

@section('sidebar')
<a href="{{ route('manajer.dashboard') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
    <i class="fas fa-home w-5"></i>
    <span class="font-medium">Dashboard</span>
</a>
<a href="{{ route('manajer.bahan-baku.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
    <i class="fas fa-box w-5"></i>
    <span class="font-medium">Bahan Baku</span>
</a>
<a href="{{ route('manajer.ranking-saw') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
    <i class="fas fa-trophy w-5"></i>
    <span class="font-medium">Ranking SAW</span>
</a>
<a href="{{ route('manajer.peringatan-stok') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
    <i class="fas fa-exclamation-triangle w-5"></i>
    <span class="font-medium">Peringatan Stok</span>
</a>
<a href="{{ route('manajer.kategori.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
    <i class="fas fa-tags w-5"></i>
    <span class="font-medium">Kategori</span>
</a>
<a href="{{ route('manajer.supplier.index') }}" class="sidebar-link sidebar-active flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition">
    <i class="fas fa-truck w-5"></i>
    <span class="font-medium">Supplier</span>
</a>
@endsection

@section('content')

<!-- Action Button -->
<div class="mb-6">
    <a href="{{ route('manajer.supplier.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-semibold rounded-lg hover:from-emerald-600 hover:to-teal-600 transition-all shadow-lg hover:shadow-xl">
        <i class="fas fa-plus mr-2"></i>Tambah Supplier
    </a>
</div>

<!-- Table Supplier -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <h3 class="text-lg font-bold text-gray-800">
            <i class="fas fa-list mr-2 text-emerald-600"></i>Daftar Supplier
        </h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nama Supplier</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Kontak</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No. Telepon</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Jumlah Bahan</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($suppliers as $index => $supplier)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-gray-600">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">
                        <span class="font-semibold text-gray-800">{{ $supplier->nama_supplier }}</span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $supplier->kontak ?? '-' }}</td>
                    <td class="px-6 py-4 text-gray-600">
                        <i class="fas fa-phone text-emerald-600 mr-2"></i>{{ $supplier->no_telp }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-semibold rounded-full">
                            {{ $supplier->bahan_bakus_count }} item
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('manajer.supplier.edit', $supplier->id) }}" class="px-3 py-1.5 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 transition">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('manajer.supplier.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 bg-red-500 text-white text-sm font-medium rounded-lg hover:bg-red-600 transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                        <p>Belum ada data supplier.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
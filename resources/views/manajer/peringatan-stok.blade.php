@extends('layouts.app')

@section('title', 'Peringatan Stok')
@section('page-title', 'Peringatan Stok')
@section('page-subtitle', 'Daftar bahan baku dengan stok Kritis & Rendah.')

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
<a href="{{ route('manajer.peringatan-stok') }}" class="sidebar-link sidebar-active flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition">
    <i class="fas fa-exclamation-triangle w-5"></i>
    <span class="font-medium">Peringatan Stok</span>
</a>
<a href="{{ route('manajer.kategori.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
    <i class="fas fa-tags w-5"></i>
    <span class="font-medium">Kategori</span>
</a>
<a href="{{ route('manajer.supplier.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
    <i class="fas fa-truck w-5"></i>
    <span class="font-medium">Supplier</span>
</a>
<div class="mt-2 pt-2 border-t border-gray-200">
    <a href="{{ route('manajer.users.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
        <i class="fas fa-users w-5"></i>
        <span class="font-medium">Kelola User</span>
    </a>
</div>
@endsection

@section('content')

<!-- Alert Info -->
<div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
    <div class="flex items-start">
        <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3 mt-1"></i>
        <div>
            <h4 class="font-semibold text-red-800 mb-1">Perhatian!</h4>
            <p class="text-sm text-red-700">Halaman ini menampilkan bahan baku dengan status <span class="font-bold">Kritis (stok ≤ 10)</span> dan <span class="font-bold">Rendah (stok 11-50)</span> yang perlu segera dibeli atau dipantau.</p>
        </div>
    </div>
</div>

<!-- Table Peringatan Stok -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <h3 class="text-lg font-bold text-gray-800">
            <i class="fas fa-list-ul mr-2 text-red-600"></i>Daftar Lengkap Peringatan Stok
        </h3>
        <p class="text-sm text-gray-600 mt-1">Diurutkan dari stok paling sedikit (Kritis → Rendah)</p>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nama Bahan</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Supplier</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Stok</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Satuan</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($bahanBakus as $index => $bahan)
                <tr class="hover:bg-gray-50 transition {{ $bahan->stok_saat_ini <= 10 ? 'bg-red-50' : '' }}">
                    <td class="px-6 py-4 text-gray-600">{{ $bahanBakus->firstItem() + $index }}</td>
                    <td class="px-6 py-4">
                        <span class="font-semibold text-gray-800">{{ $bahan->nama_bahan }}</span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $bahan->kategori->nama_kategori }}</td>
                    <td class="px-6 py-4 text-gray-600 text-sm">{{ $bahan->supplier->nama_supplier }}</td>
                    <td class="px-6 py-4">
                        <span class="font-bold {{ $bahan->stok_saat_ini <= 10 ? 'text-red-600' : 'text-yellow-600' }} text-lg">
                            {{ $bahan->stok_saat_ini }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $bahan->satuan }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $bahan->status_color }}">
                            {{ $bahan->status_stok }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('manajer.bahan-baku.edit', $bahan->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 transition">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-check-circle text-4xl mb-3 text-green-300"></i>
                        <p class="text-lg font-semibold text-green-600">Semua stok dalam kondisi aman! 🎉</p>
                        <p class="text-sm text-gray-500 mt-1">Tidak ada bahan baku dengan status Kritis atau Rendah.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($bahanBakus->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $bahanBakus->links() }}
    </div>
    @endif
    
</div>

<!-- Legend -->
<div class="mt-6 bg-white rounded-lg border border-gray-200 p-4">
    <h4 class="text-sm font-semibold text-gray-800 mb-3">
        <i class="fas fa-info-circle mr-2"></i>Keterangan Status Stok
    </h4>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
        <div class="flex items-center">
            <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full mr-3">Kritis</span>
            <span class="text-gray-600">Stok ≤ 2 (Harus segera dibeli)</span>
        </div>
        <div class="flex items-center">
            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full mr-3">Rendah</span>
            <span class="text-gray-600">Stok 3-5 (Perlu dipantau)</span>
        </div>
        <div class="flex items-center">
            <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full mr-3">Aman</span>
            <span class="text-gray-600">Stok > 6 (Kondisi baik)</span>
        </div>
    </div>
</div>

@endsection
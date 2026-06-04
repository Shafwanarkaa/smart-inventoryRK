@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan informasi bahan baku.')

@section('sidebar')
<a href="{{ route('manajer.dashboard') }}" class="sidebar-link sidebar-active flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition">
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

<!-- Stats Cards (Clickable) -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    
    <!-- Card: Total Bahan (Clickable) -->
    <a href="{{ route('manajer.bahan-baku.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-all cursor-pointer">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Bahan</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ number_format($totalBahan) }} <span class="text-lg text-gray-500">item</span></h3>
                <p class="text-xs text-emerald-600 mt-2">
                    <i class="fas fa-arrow-right mr-1"></i>Klik untuk lihat semua bahan baku
                </p>
            </div>
            <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center">
                <i class="fas fa-box text-emerald-600 text-2xl"></i>
            </div>
        </div>
    </a>
    
    <!-- Card: Peringatan Stok (Clickable) -->
    <a href="{{ route('manajer.peringatan-stok') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-all cursor-pointer">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Peringatan Stok</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $jumlahPeringatan }} <span class="text-lg text-gray-500">item</span></h3>
                <p class="text-xs text-red-600 mt-2">
                    <i class="fas fa-arrow-right mr-1"></i>Klik untuk lihat detail peringatan
                </p>
            </div>
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
            </div>
        </div>
    </a>
    
</div>

<!-- Table Peringatan Stok -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <h3 class="text-lg font-bold text-gray-800">
            <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>Peringatan Stok - Perlu Segera Dibeli (Top 30)
        </h3>
        <p class="text-sm text-gray-600 mt-1">Bahan dengan stok Kritis & Rendah diurutkan dari yang paling sedikit</p>
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
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($peringatanStok as $index => $bahan)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-gray-600">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">
                        <span class="font-semibold text-gray-800">{{ $bahan->nama_bahan }}</span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $bahan->kategori->nama_kategori }}</td>
                    <td class="px-6 py-4 text-gray-600 text-sm">{{ $bahan->supplier->nama_supplier }}</td>
                    <td class="px-6 py-4">
                        <span class="font-bold text-gray-800 text-lg">{{ $bahan->stok_saat_ini }}</span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $bahan->satuan }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $bahan->status_color }}">
                            {{ $bahan->status_stok }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-check-circle text-4xl mb-3 text-green-300"></i>
                        <p>Semua stok dalam kondisi aman! 🎉</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($peringatanStok->count() > 0)
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 text-center">
        <a href="{{ route('manajer.peringatan-stok') }}" class="inline-flex items-center px-6 py-2 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition">
            <i class="fas fa-list mr-2"></i>Lihat Semua Peringatan Stok ({{ $jumlahPeringatan }} item)
        </a>
    </div>
    @endif
    
</div>

@endsection
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
<a href="{{ route('manajer.kategori.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
    <i class="fas fa-tags w-5"></i>
    <span class="font-medium">Kategori</span>
</a>
<a href="{{ route('manajer.supplier.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
    <i class="fas fa-truck w-5"></i>
    <span class="font-medium">Supplier</span>
</a>
@endsection

@section('content')

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

    <!-- Card: Total Bahan -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Bahan</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ number_format($totalBahan) }} <span class="text-lg text-gray-500">item</span></h3>
                <p class="text-xs text-emerald-600 mt-2">
                    <i class="fas fa-info-circle mr-1"></i>Total seluruh bahan baku tersedia
                </p>
            </div>
            <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center">
                <i class="fas fa-box text-emerald-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Card: Peringatan Stok -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Peringatan Stok</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $peringatanStok }} <span class="text-lg text-gray-500">item</span></h3>
                <p class="text-xs text-red-600 mt-2">
                    <i class="fas fa-exclamation-triangle mr-1"></i>Bahan baku dengan stok rendah atau hampir habis
                </p>
            </div>
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
            </div>
        </div>
    </div>

</div>

<!-- Action Button -->
<div class="mb-6">
    <form action="{{ route('manajer.hitung-saw') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghitung ulang ranking SAW?')">
        @csrf
        <button type="submit" class="bg-gradient-to-r from-emerald-500 to-teal-500 text-white px-6 py-3 rounded-lg font-semibold hover:from-emerald-600 hover:to-teal-600 transition-all shadow-lg hover:shadow-xl">
            <i class="fas fa-calculator mr-2"></i>Hitung Ranking SAW
        </button>
    </form>
</div>

<!-- Table Ranking -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <h3 class="text-lg font-bold text-gray-800">
            <i class="fas fa-trophy text-yellow-500 mr-2"></i>Ranking Prioritas Pengadaan (Metode SAW)
        </h3>
        <p class="text-sm text-gray-600 mt-1">Bahan baku diurutkan berdasarkan skor SAW tertinggi</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Rank</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nama Bahan</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Supplier</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Satuan</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Stok</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Skor SAW</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($bahanBakus as $index => $bahan)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        @if($index < 3)
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ $index == 0 ? 'bg-yellow-100 text-yellow-600' : ($index == 1 ? 'bg-gray-100 text-gray-600' : 'bg-orange-100 text-orange-600') }} font-bold">
                            {{ $index + 1 }}
                            </span>
                            @else
                            <span class="text-gray-600 font-semibold">{{ $index + 1 }}</span>
                            @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-semibold text-gray-800">{{ $bahan->nama_bahan }}</span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $bahan->kategori->nama_kategori }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $bahan->supplier->nama_supplier }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $bahan->satuan }}</td>
                    <td class="px-6 py-4">
                        <span class="font-semibold text-gray-800">{{ $bahan->stok_saat_ini }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-bold text-emerald-600 text-lg">{{ number_format($bahan->skor_saw, 4) }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $bahan->status_color }}">
                            {{ $bahan->status_stok }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                        <p>Belum ada data bahan baku.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
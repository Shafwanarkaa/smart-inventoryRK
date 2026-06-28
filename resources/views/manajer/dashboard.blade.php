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
<a href="{{ route('manajer.histori-stok') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
    <i class="fas fa-history w-5"></i>
    <span class="font-medium">Histori Stok</span>
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
    
    <!-- Card: Ranking SAW (Clickable) -->
    <a href="{{ route('manajer.ranking-saw') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-all cursor-pointer">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Prioritas Pengadaan (SAW)</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $jumlahTelahDihitung ?? $totalBahan }} <span class="text-lg text-gray-500">item</span></h3>
                <p class="text-xs text-indigo-600 mt-2">
                    <i class="fas fa-arrow-right mr-1"></i>Klik untuk lihat detail ranking
                </p>
            </div>
            <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center">
                <i class="fas fa-trophy text-indigo-600 text-2xl"></i>
            </div>
        </div>
    </a>
    
</div>

<!-- Table Ranking SAW -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
        <div>
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-trophy text-yellow-500 mr-2"></i>Top 10 Prioritas Pengadaan (Hasil SAW)
            </h3>
            <p class="text-sm text-gray-600 mt-1">Bahan baku yang paling direkomendasikan untuk segera dibeli</p>
        </div>
        <form action="{{ route('manajer.hitung-saw') }}" method="POST" class="m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghitung ulang ranking SAW?')">
            @csrf
            <button type="submit" class="bg-emerald-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-emerald-600 transition-all text-sm">
                <i class="fas fa-calculator mr-1"></i>Hitung Ulang
            </button>
        </form>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Rank</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nama Bahan</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Stok</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Skor SAW</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Saran Sistem</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($rankingSAW as $index => $bahan)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        @php
                            $rank = $index + 1;
                        @endphp
                        @if($rank <= 3)
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ $rank == 1 ? 'bg-yellow-100 text-yellow-600' : ($rank == 2 ? 'bg-gray-100 text-gray-600' : 'bg-orange-100 text-orange-600') }} font-bold">
                                {{ $rank }}
                            </span>
                        @else
                            <span class="text-gray-600 font-semibold">{{ $rank }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-semibold text-gray-800">{{ $bahan->nama_bahan }}</span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $bahan->kategori->nama_kategori }}</td>
                    <td class="px-6 py-4">
                        <span class="font-semibold text-gray-800">{{ $bahan->stok_saat_ini }} {{ $bahan->satuan }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-bold text-emerald-600 text-lg">{{ number_format($bahan->skor_saw, 4) }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $bahan->status_color }}">
                            {{ $bahan->status_stok }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($bahan->skor_saw >= 0.6)
                            <span class="text-red-600 font-bold text-xs"><i class="fas fa-fire mr-1"></i>Beli Segera</span>
                        @elseif($bahan->skor_saw >= 0.5)
                            <span class="text-orange-500 font-bold text-xs"><i class="fas fa-shopping-cart mr-1"></i>Prioritas Hari Ini</span>
                        @else
                            <span class="text-gray-500 text-xs"><i class="fas fa-clock mr-1"></i>Bisa Ditunda / Cicil</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-calculator text-4xl mb-3 text-gray-300"></i>
                        <p>Belum ada data perhitungan SAW.</p>
                        <form action="{{ route('manajer.hitung-saw') }}" method="POST" class="mt-3">
                            @csrf
                            <button type="submit" class="bg-emerald-500 text-white px-4 py-2 rounded font-medium hover:bg-emerald-600 transition-all">
                                Hitung Sekarang
                            </button>
                        </form>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($rankingSAW->count() > 0)
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 text-center">
        <a href="{{ route('manajer.ranking-saw') }}" class="inline-flex items-center px-6 py-2 bg-indigo-500 text-white font-semibold rounded-lg hover:bg-indigo-600 transition">
            <i class="fas fa-trophy mr-2"></i>Lihat Semua Ranking SAW
        </a>
    </div>
    @endif
    
</div>

@endsection
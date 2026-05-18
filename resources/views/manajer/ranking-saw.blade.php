@extends('layouts.app')

@section('title', 'Ranking SAW')
@section('page-title', 'Ranking SAW')
@section('page-subtitle', 'Prioritas pengadaan berdasarkan metode Simple Additive Weighting.')

@section('sidebar')
<a href="{{ route('manajer.dashboard') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
    <i class="fas fa-home w-5"></i>
    <span class="font-medium">Dashboard</span>
</a>
<a href="{{ route('manajer.bahan-baku.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
    <i class="fas fa-box w-5"></i>
    <span class="font-medium">Bahan Baku</span>
</a>
<a href="{{ route('manajer.ranking-saw') }}" class="sidebar-link sidebar-active flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition">
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
@endsection

@section('content')

<!-- Action Button -->
<div class="mb-6">
    <form action="{{ route('manajer.hitung-saw') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghitung ulang ranking SAW?')">
        @csrf
        <button type="submit" class="bg-gradient-to-r from-emerald-500 to-teal-500 text-white px-6 py-3 rounded-lg font-semibold hover:from-emerald-600 hover:to-teal-600 transition-all shadow-lg hover:shadow-xl">
            <i class="fas fa-calculator mr-2"></i>Hitung Ulang Ranking SAW
        </button>
    </form>
</div>

<!-- Table Ranking -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <h3 class="text-lg font-bold text-gray-800">
            <i class="fas fa-trophy text-yellow-500 mr-2"></i>Ranking Prioritas Pengadaan (Metode SAW)
        </h3>
        <p class="text-sm text-gray-600 mt-1">Semua bahan baku diurutkan berdasarkan skor SAW tertinggi</p>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Rank</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nama Bahan</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Supplier</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Stok</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Skor SAW</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($bahanBakus as $index => $bahan)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        @php
                            $rank = ($bahanBakus->currentPage() - 1) * $bahanBakus->perPage() + $index + 1;
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
                    <td class="px-6 py-4 text-gray-600 text-sm">{{ $bahan->supplier->nama_supplier }}</td>
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
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                        <p>Belum ada data bahan baku.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $bahanBakus->links() }}
    </div>
    
</div>

<!-- Info Box SAW -->
<div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
    <h4 class="text-sm font-semibold text-blue-800 mb-3">
        <i class="fas fa-info-circle mr-2"></i>Informasi Metode SAW dengan Multiplier
    </h4>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs text-blue-700 mb-4">
        <div>
            <p class="font-semibold mb-1">C1 - Sisa Stok (COST)</p>
            <p>Semakin kecil stok = prioritas lebih tinggi</p>
            <p class="text-blue-600 mt-1">Bobot: 40%</p>
        </div>
        <div>
            <p class="font-semibold mb-1">C2 - Tingkat Kadaluarsa (BENEFIT)</p>
            <p>Semakin mudah basi = prioritas lebih tinggi</p>
            <p class="text-blue-600 mt-1">Bobot: 30%</p>
        </div>
        <div>
            <p class="font-semibold mb-1">C3 - Kebutuhan Harian (BENEFIT)</p>
            <p>Semakin banyak kebutuhan = prioritas lebih tinggi</p>
            <p class="text-blue-600 mt-1">Bobot: 30%</p>
        </div>
    </div>
    
    <div class="border-t border-blue-200 pt-4">
        <h5 class="font-semibold text-blue-800 mb-2">
            <i class="fas fa-star mr-2"></i>Sistem Multiplier Status
        </h5>
        <div class="grid grid-cols-3 gap-3">
            <div class="bg-red-50 border border-red-200 rounded p-3">
                <p class="font-bold text-red-600 text-sm">🔴 KRITIS</p>
                <p class="text-xs text-red-700 mt-1">Stok ≤ 10</p>
                <p class="text-xs text-red-800 font-semibold mt-1">Bonus: +10 poin</p>
            </div>
            <div class="bg-yellow-50 border border-yellow-200 rounded p-3">
                <p class="font-bold text-yellow-600 text-sm">🟡 RENDAH</p>
                <p class="text-xs text-yellow-700 mt-1">Stok 11-50</p>
                <p class="text-xs text-yellow-800 font-semibold mt-1">Bonus: +5 poin</p>
            </div>
            <div class="bg-green-50 border border-green-200 rounded p-3">
                <p class="font-bold text-green-600 text-sm">🟢 AMAN</p>
                <p class="text-xs text-green-700 mt-1">Stok > 50</p>
                <p class="text-xs text-green-800 font-semibold mt-1">Bonus: +0 poin</p>
            </div>
        </div>
    </div>
    
    <div class="mt-4 pt-4 border-t border-blue-200">
        <p class="text-xs text-blue-800">
            <i class="fas fa-lightbulb mr-2"></i>
            <strong>Cara Kerja:</strong> Sistem menghitung skor SAW normal (0-1), lalu menambahkan bonus berdasarkan status stok. 
            Dengan cara ini, semua bahan dengan status KRITIS akan memiliki skor 10.xx (rank 1-20), 
            RENDAH akan skor 5.xx (rank 21-60), dan AMAN akan skor 0.xx (rank 61-98).
            <strong class="text-blue-900">Dijamin 100% tidak akan kebalik!</strong>
        </p>
    </div>
</div>
@endsection
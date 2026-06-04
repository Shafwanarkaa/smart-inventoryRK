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
<div class="mt-2 pt-2 border-t border-gray-200">
    <a href="{{ route('manajer.users.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
        <i class="fas fa-users w-5"></i>
        <span class="font-medium">Kelola User</span>
    </a>
</div>
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
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Saran Sistem</th>
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
                    <td class="px-6 py-4">
                        @if($rank <= 3)
                            <span class="text-red-600 font-bold text-xs"><i class="fas fa-fire mr-1"></i>Wajib Beli Sekarang!</span>
                        @elseif($rank <= 10)
                            <span class="text-orange-500 font-bold text-xs"><i class="fas fa-shopping-cart mr-1"></i>Prioritas Hari Ini</span>
                        @else
                            <span class="text-gray-500 text-xs"><i class="fas fa-clock mr-1"></i>Bisa Ditunda / Cicil</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                        <p>Belum ada data bahan baku yang perlu dibeli.</p>
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
        <i class="fas fa-info-circle mr-2"></i>Bagaimana Sistem SAW Mengurutkan Prioritas Belanja?
    </h4>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs text-blue-700 mb-4">
        <div>
            <p class="font-semibold mb-1">C1 - Urgensi Stok (COST)</p>
            <p>Semakin mepet sisa stok terhadap batas minimumnya, poin semakin besar.</p>
            <p class="text-blue-600 mt-1">Bobot: 40%</p>
        </div>
        <div>
            <p class="font-semibold mb-1">C2 - Tingkat Kadaluarsa (BENEFIT)</p>
            <p>Bahan yang sangat mudah basi (skala 5) akan diprioritaskan untuk dibeli.</p>
            <p class="text-blue-600 mt-1">Bobot: 30%</p>
        </div>
        <div>
            <p class="font-semibold mb-1">C3 - Kebutuhan Harian (BENEFIT)</p>
            <p>Bahan utama masakan (skala 5) akan diprioritaskan dibanding bumbu pelengkap.</p>
            <p class="text-blue-600 mt-1">Bobot: 30%</p>
        </div>
    </div>
    
    <div class="border-t border-blue-200 pt-4">
        <h5 class="font-semibold text-blue-800 mb-2">
            <i class="fas fa-question-circle mr-2"></i>Pertanyaan Sering Diajukan (FAQ)
        </h5>
        
        <div class="space-y-3 mt-3">
            <div class="bg-white rounded p-3 border border-blue-100">
                <p class="font-bold text-blue-800 text-xs mb-1">Q: Kemana perginya bahan baku yang statusnya AMAN?</p>
                <p class="text-xs text-blue-700">A: Bahan baku yang stoknya masih di atas batas minimum (Aman) **sengaja disembunyikan** dari daftar ini agar Manajer bisa fokus melihat rekomendasi bahan yang benar-benar butuh dibeli hari ini.</p>
            </div>
            
            <div class="bg-white rounded p-3 border border-blue-100">
                <p class="font-bold text-blue-800 text-xs mb-1">Q: Kenapa status 'Rendah' bisa berada di atas status 'Kritis'?</p>
                <p class="text-xs text-blue-700">A: Karena sistem SPK itu cerdas! Sistem ini tidak hanya melihat sisa stok secara buta. Jika ada Daging (Rendah) dan Garam (Kritis), sistem akan memaksa Daging naik ke ranking atas karena daging lebih cepat busuk (C2) dan krusial untuk menu masakan (C3). Inilah fungsi dari Sistem Pendukung Keputusan.</p>
            </div>
            
            <div class="bg-white rounded p-3 border border-blue-100">
                <p class="font-bold text-blue-800 text-xs mb-1">Q: Apa bedanya halaman ini dengan Peringatan Stok?</p>
                <p class="text-xs text-blue-700">A: Peringatan Stok hanya laporan fisik dari dapur (mana barang yang mau habis). Ranking SAW adalah rekomendasi untuk Manajer Pembelian (mana barang yang paling wajib dibeli pakai uang sekarang).</p>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Update Stok')
@section('page-title', 'Update Stok')
@section('page-subtitle', 'Perbarui data stok bahan baku.')

@section('sidebar')
<a href="{{ route('operasional.stok') }}" class="sidebar-link sidebar-active flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition">
    <i class="fas fa-boxes w-5"></i>
    <span class="font-medium">Stok Harian</span>
</a>
@endsection

@section('content')

<div class="max-w-2xl">
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-800">Update Stok Harian</h3>
            <p class="text-sm text-gray-600 mt-1">{{ $bahan->nama_bahan }}</p>
        </div>
        
        <form action="{{ route('operasional.stok.update', $bahan->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Info Bahan -->
            <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-emerald-800 mb-3">
                    <i class="fas fa-info-circle mr-2"></i>Informasi Bahan
                </h4>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-600">Kategori:</p>
                        <p class="font-semibold text-gray-800">{{ $bahan->kategori->nama_kategori }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Supplier:</p>
                        <p class="font-semibold text-gray-800">{{ $bahan->supplier->nama_supplier }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Satuan:</p>
                        <p class="font-semibold text-gray-800">{{ $bahan->satuan }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Stok Kemarin:</p>
                        <p class="font-semibold text-emerald-600 text-lg">{{ $bahan->stok_saat_ini }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Stok Saat Ini (CUMA INI DOANG!) -->
            <div>
                <label for="stok_saat_ini" class="block text-lg font-bold text-gray-800 mb-3">
                    <i class="fas fa-box text-emerald-600 mr-2"></i>Stok Hari Ini <span class="text-red-500">*</span>
                </label>
                <input 
                    type="number" 
                    name="stok_saat_ini" 
                    id="stok_saat_ini" 
                    class="w-full px-6 py-4 text-2xl border-2 border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-center font-bold"
                    value="{{ old('stok_saat_ini', $bahan->stok_saat_ini) }}"
                    min="0"
                    required
                    autofocus
                >
                <p class="text-sm text-gray-500 mt-2 text-center">
                    <i class="fas fa-info-circle mr-1"></i>Masukkan jumlah stok hasil pengecekan fisik hari ini
                </p>
            </div>
            
            <!-- Status Preview -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-chart-line mr-2"></i>Status Stok
                </h4>
                <div class="flex items-center justify-center space-x-4">
                    <div class="text-center">
                        <p class="text-xs text-gray-600 mb-1">Kemarin</p>
                        <span class="px-4 py-2 text-sm font-semibold rounded-full {{ $bahan->status_color }}">
                            {{ $bahan->status_stok }}
                        </span>
                    </div>
                    <i class="fas fa-arrow-right text-gray-400"></i>
                    <div class="text-center">
                        <p class="text-xs text-gray-600 mb-1">Setelah Update</p>
                        <span class="px-4 py-2 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                            Akan Dihitung
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Keterangan (opsional) -->
            <div>
                <label for="keterangan" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-sticky-note text-gray-400 mr-2"></i>Keterangan <span class="font-normal text-gray-400">(opsional)</span>
                </label>
                <input
                    type="text"
                    name="keterangan"
                    id="keterangan"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none"
                    placeholder="Contoh: Beli dari pasar, Terpakai masak siang, Stok baru datang..."
                    value="{{ old('keterangan') }}"
                    maxlength="200">
            </div>

            <!-- Buttons -->
            <div class="flex items-center space-x-3">
                <button type="submit" class="flex-1 px-6 py-3 bg-emerald-500 text-white font-bold text-lg rounded-lg hover:bg-emerald-600 transition shadow-lg hover:shadow-xl">
                    <i class="fas fa-save mr-2"></i>Simpan Stok
                </button>
                <a href="{{ route('operasional.stok') }}" class="px-6 py-3 bg-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-400 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
            
        </form>
        
    </div>
    
    <!-- Tips -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <h4 class="text-sm font-semibold text-blue-800 mb-2">
            <i class="fas fa-lightbulb mr-2"></i>Tips Update Stok
        </h4>
        <ul class="text-xs text-blue-700 space-y-1">
            <li>• Lakukan pengecekan fisik stok secara teliti</li>
            <li>• Update stok setiap hari di waktu yang sama (pagi/sore)</li>
            <li>• Jika stok menipis, segera laporkan ke Manajer</li>
            <li>• Sistem akan otomatis menghitung prioritas pengadaan</li>
        </ul>
    </div>
    
</div>

@endsection
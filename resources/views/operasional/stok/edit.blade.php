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
            <h3 class="text-lg font-bold text-gray-800">Form Update Stok</h3>
            <p class="text-sm text-gray-600 mt-1">{{ $bahan->nama_bahan }}</p>
        </div>

        <form action="{{ route('operasional.stok.update', $bahan->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Info Bahan -->
            <div class="bg-gray-50 p-4 rounded-lg">
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
                        <p class="text-gray-600">Stok Lama:</p>
                        <p class="font-semibold text-gray-800">{{ $bahan->stok_saat_ini }}</p>
                    </div>
                </div>
            </div>

            <!-- Stok Saat Ini -->
            <div>
                <label for="stok_saat_ini" class="block text-sm font-semibold text-gray-700 mb-2">
                    Stok Saat Ini <span class="text-red-500">*</span>
                </label>
                <input
                    type="number"
                    name="stok_saat_ini"
                    id="stok_saat_ini"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none"
                    value="{{ old('stok_saat_ini', $bahan->stok_saat_ini) }}"
                    min="0"
                    required>
            </div>

            <!-- Nilai C1 -->
            <div>
                <label for="nilai_c1" class="block text-sm font-semibold text-gray-700 mb-2">
                    Nilai C1 (Sisa Stok) <span class="text-red-500">*</span>
                </label>
                <input
                    type="number"
                    name="nilai_c1"
                    id="nilai_c1"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none"
                    value="{{ old('nilai_c1', $bahan->nilai_c1) }}"
                    min="0"
                    required>
                <p class="text-xs text-gray-500 mt-1">
                    <i class="fas fa-info-circle mr-1"></i>C1 adalah kriteria COST (semakin kecil semakin prioritas)
                </p>
            </div>

            <!-- Buttons -->
            <div class="flex items-center space-x-3">
                <button type="submit" class="px-6 py-2 bg-emerald-500 text-white font-semibold rounded-lg hover:bg-emerald-600 transition">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
                <a href="{{ route('operasional.stok') }}" class="px-6 py-2 bg-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-400 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>

        </form>

    </div>

</div>

@endsection
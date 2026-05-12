@extends('layouts.app')

@section('title', 'Edit Bahan Baku')
@section('page-title', 'Edit Bahan Baku')
@section('page-subtitle', 'Perbarui data bahan baku.')

@section('sidebar')
<a href="{{ route('manajer.dashboard') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
    <i class="fas fa-home w-5"></i>
    <span class="font-medium">Dashboard</span>
</a>
<a href="{{ route('manajer.bahan-baku.index') }}" class="sidebar-link sidebar-active flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition">
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

<div class="max-w-4xl">

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-800">Form Edit Bahan Baku</h3>
            <p class="text-sm text-gray-600 mt-1">{{ $bahanBaku->nama_bahan }}</p>
        </div>

        <form action="{{ route('manajer.bahan-baku.update', $bahanBaku->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Nama Bahan -->
                <div>
                    <label for="nama_bahan" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Bahan <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="nama_bahan"
                        id="nama_bahan"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none"
                        value="{{ old('nama_bahan', $bahanBaku->nama_bahan) }}"
                        required>
                </div>

                <!-- Kategori -->
                <div>
                    <label for="kategori_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="kategori_id"
                        id="kategori_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none"
                        required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('kategori_id', $bahanBaku->kategori_id) == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Supplier -->
                <div>
                    <label for="supplier_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Supplier <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="supplier_id"
                        id="supplier_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none"
                        required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id', $bahanBaku->supplier_id) == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->nama_supplier }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Satuan -->
                <div>
                    <label for="satuan" class="block text-sm font-semibold text-gray-700 mb-2">
                        Satuan <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="satuan"
                        id="satuan"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none"
                        required>
                        <option value="">-- Pilih Satuan --</option>
                        @php
                        $satuans = ['Kg', 'Gram', 'Liter', 'Ml', 'Ikat', 'Bungkus', 'Botol', 'Pcs', 'Buah'];
                        @endphp
                        @foreach($satuans as $satuan)
                        <option value="{{ $satuan }}" {{ old('satuan', $bahanBaku->satuan) == $satuan ? 'selected' : '' }}>
                            {{ $satuan }}
                        </option>
                        @endforeach
                    </select>
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
                        value="{{ old('stok_saat_ini', $bahanBaku->stok_saat_ini) }}"
                        min="0"
                        required>
                </div>

                <!-- Nilai C1 (Sisa Stok) -->
                <div>
                    <label for="nilai_c1" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nilai C1 - Sisa Stok <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        name="nilai_c1"
                        id="nilai_c1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none"
                        value="{{ old('nilai_c1', $bahanBaku->nilai_c1) }}"
                        min="0"
                        required>
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-info-circle mr-1"></i>Kriteria COST (semakin kecil = prioritas tinggi)
                    </p>
                </div>

                <!-- Nilai C2 (Tingkat Kadaluarsa) -->
                <div>
                    <label for="nilai_c2" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nilai C2 - Tingkat Kadaluarsa <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        name="nilai_c2"
                        id="nilai_c2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none"
                        value="{{ old('nilai_c2', $bahanBaku->nilai_c2) }}"
                        min="0"
                        required>
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-info-circle mr-1"></i>Kriteria BENEFIT (semakin besar = prioritas tinggi)
                    </p>
                </div>

                <!-- Nilai C3 (Batas Kebutuhan Harian) -->
                <div>
                    <label for="nilai_c3" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nilai C3 - Batas Kebutuhan Harian <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        name="nilai_c3"
                        id="nilai_c3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none"
                        value="{{ old('nilai_c3', $bahanBaku->nilai_c3) }}"
                        min="0"
                        required>
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-info-circle mr-1"></i>Kriteria BENEFIT (semakin besar = prioritas tinggi)
                    </p>
                </div>

            </div>

            <!-- Info Box SAW -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-blue-800 mb-2">
                    <i class="fas fa-lightbulb mr-2"></i>Informasi Kriteria SAW
                </h4>
                <ul class="text-xs text-blue-700 space-y-1">
                    <li><strong>C1 (Sisa Stok):</strong> COST - Nilai semakin kecil = prioritas pengadaan tinggi</li>
                    <li><strong>C2 (Tingkat Kadaluarsa):</strong> BENEFIT - Nilai semakin besar = prioritas tinggi (skala 1-10)</li>
                    <li><strong>C3 (Batas Kebutuhan Harian):</strong> BENEFIT - Nilai semakin besar = prioritas tinggi</li>
                    <li><strong>Bobot:</strong> W1 = 0.40, W2 = 0.30, W3 = 0.30</li>
                </ul>
            </div>

            <!-- Buttons -->
            <div class="flex items-center space-x-3 mt-6">
                <button type="submit" class="px-6 py-2 bg-emerald-500 text-white font-semibold rounded-lg hover:bg-emerald-600 transition">
                    <i class="fas fa-save mr-2"></i>Update
                </button>
                <a href="{{ route('manajer.bahan-baku.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-400 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>

        </form>

    </div>

</div>

@endsection
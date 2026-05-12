@extends('layouts.app')

@section('title', 'Tambah Supplier')
@section('page-title', 'Tambah Supplier')
@section('page-subtitle', 'Tambah supplier bahan baku baru.')

@section('sidebar')
<a href="{{ route('manajer.dashboard') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
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
<a href="{{ route('manajer.supplier.index') }}" class="sidebar-link sidebar-active flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition">
    <i class="fas fa-truck w-5"></i>
    <span class="font-medium">Supplier</span>
</a>
@endsection

@section('content')

<div class="max-w-2xl">

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-800">Form Tambah Supplier</h3>
        </div>

        <form action="{{ route('manajer.supplier.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Nama Supplier -->
            <div>
                <label for="nama_supplier" class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Supplier <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="nama_supplier"
                    id="nama_supplier"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none"
                    placeholder="Contoh: CV. Sumber Rezeki"
                    value="{{ old('nama_supplier') }}"
                    required>
            </div>

            <!-- Kontak -->
            <div>
                <label for="kontak" class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Kontak
                </label>
                <input
                    type="text"
                    name="kontak"
                    id="kontak"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none"
                    placeholder="Contoh: Budi Santoso"
                    value="{{ old('kontak') }}">
            </div>

            <!-- No. Telepon -->
            <div>
                <label for="no_telp" class="block text-sm font-semibold text-gray-700 mb-2">
                    No. Telepon <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="no_telp"
                    id="no_telp"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none"
                    placeholder="Contoh: 0813-1234-5678"
                    value="{{ old('no_telp') }}"
                    required>
            </div>

            <!-- Buttons -->
            <div class="flex items-center space-x-3">
                <button type="submit" class="px-6 py-2 bg-emerald-500 text-white font-semibold rounded-lg hover:bg-emerald-600 transition">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
                <a href="{{ route('manajer.supplier.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-400 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>

        </form>

    </div>

</div>

@endsection
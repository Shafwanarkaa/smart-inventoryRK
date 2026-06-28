@extends('layouts.app')

@section('title', 'Catat Pemakaian')
@section('page-title', 'Catat Pemakaian')
@section('page-subtitle', 'Input jumlah bahan baku yang digunakan hari ini.')

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
            <h3 class="text-lg font-bold text-gray-800">Catat Pemakaian Bahan</h3>
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
                        <p class="text-gray-600">Stok Tersedia:</p>
                        <p class="font-bold text-emerald-600 text-xl">{{ $bahan->stok_saat_ini }} {{ $bahan->satuan }}</p>
                    </div>
                </div>
            </div>

            <!-- Validasi error -->
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <ul class="text-sm text-red-700 space-y-1">
                    @foreach($errors->all() as $error)
                    <li><i class="fas fa-exclamation-circle mr-1"></i>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <!-- Jumlah Pemakaian -->
            <div>
                <label for="jumlah_pemakaian" class="block text-lg font-bold text-gray-800 mb-3">
                    <i class="fas fa-minus-circle text-red-500 mr-2"></i>Jumlah Pemakaian <span class="text-red-500">*</span>
                </label>
                <input 
                    type="number" 
                    name="jumlah_pemakaian" 
                    id="jumlah_pemakaian" 
                    class="w-full px-6 py-4 text-2xl border-2 border-red-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none text-center font-bold"
                    value="{{ old('jumlah_pemakaian', '') }}"
                    min="1"
                    max="{{ $bahan->stok_saat_ini }}"
                    required
                    autofocus
                >
                <p class="text-sm text-gray-500 mt-2 text-center">
                    <i class="fas fa-info-circle mr-1"></i>Masukkan berapa banyak bahan yang <strong>digunakan</strong> hari ini (maks. {{ $bahan->stok_saat_ini }} {{ $bahan->satuan }})
                </p>
            </div>
            
            <!-- Preview Sisa Stok -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-gray-700 mb-3">
                    <i class="fas fa-chart-line mr-2"></i>Preview Sisa Stok
                </h4>
                <div class="flex items-center justify-center space-x-4">
                    <div class="text-center">
                        <p class="text-xs text-gray-600 mb-1">Stok Sekarang</p>
                        <span class="px-4 py-2 text-lg font-bold text-emerald-700 bg-emerald-100 rounded-full">
                            {{ $bahan->stok_saat_ini }}
                        </span>
                    </div>
                    <i class="fas fa-minus text-red-400 text-lg"></i>
                    <div class="text-center">
                        <p class="text-xs text-gray-600 mb-1">Pemakaian</p>
                        <span id="preview-pemakaian" class="px-4 py-2 text-lg font-bold text-red-700 bg-red-100 rounded-full">
                            0
                        </span>
                    </div>
                    <i class="fas fa-equals text-gray-400 text-lg"></i>
                    <div class="text-center">
                        <p class="text-xs text-gray-600 mb-1">Sisa Nanti</p>
                        <span id="preview-sisa" class="px-4 py-2 text-lg font-bold text-blue-700 bg-blue-100 rounded-full">
                            {{ $bahan->stok_saat_ini }}
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
                    placeholder="Contoh: Dipakai masak siang, menu ayam geprek..."
                    value="{{ old('keterangan') }}"
                    maxlength="200">
            </div>

            <!-- Buttons -->
            <div class="flex items-center space-x-3">
                <button type="submit" class="flex-1 px-6 py-3 bg-red-500 text-white font-bold text-lg rounded-lg hover:bg-red-600 transition shadow-lg hover:shadow-xl">
                    <i class="fas fa-check mr-2"></i>Catat Pemakaian
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
            <i class="fas fa-lightbulb mr-2"></i>Panduan Pengisian
        </h4>
        <ul class="text-xs text-blue-700 space-y-1">
            <li>• Catat pemakaian setiap selesai memasak</li>
            <li>• Input hanya jumlah yang <strong>dipakai</strong>, bukan sisa stok</li>
            <li>• Jika stok hampir habis, segera laporkan ke Manajer untuk pembelian</li>
            <li>• Histori pemakaian akan tercatat otomatis</li>
        </ul>
    </div>
    
</div>

<script>
    const stokSekarang = {{ $bahan->stok_saat_ini }};
    const inputPemakaian = document.getElementById('jumlah_pemakaian');
    const previewPemakaian = document.getElementById('preview-pemakaian');
    const previewSisa = document.getElementById('preview-sisa');

    inputPemakaian.addEventListener('input', function() {
        const pemakaian = parseInt(this.value) || 0;
        const sisa = stokSekarang - pemakaian;

        previewPemakaian.textContent = pemakaian;
        previewSisa.textContent = sisa >= 0 ? sisa : '⚠️ Melebihi stok!';
        previewSisa.className = sisa >= 0 
            ? 'px-4 py-2 text-lg font-bold text-blue-700 bg-blue-100 rounded-full'
            : 'px-4 py-2 text-lg font-bold text-red-700 bg-red-200 rounded-full';
    });
</script>

@endsection
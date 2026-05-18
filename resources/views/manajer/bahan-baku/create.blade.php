@extends('layouts.app')

@section('title', 'Tambah Bahan Baku')
@section('page-title', 'Tambah Bahan Baku')
@section('page-subtitle', 'Tambah data bahan baku baru.')

@section('sidebar')
<a href="{{ route('manajer.dashboard') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
    <i class="fas fa-home w-5"></i>
    <span class="font-medium">Dashboard</span>
</a>
<a href="{{ route('manajer.bahan-baku.index') }}" class="sidebar-link sidebar-active flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition">
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
@endsection

@section('content')

<div class="max-w-4xl">
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-800">Form Tambah Bahan Baku</h3>
        </div>
        
        <form action="{{ route('manajer.bahan-baku.store') }}" method="POST" class="p-6">
            @csrf
            
            <!-- Section: Data Dasar -->
            <div class="mb-8">
                <h4 class="text-md font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">
                    <i class="fas fa-info-circle text-emerald-600 mr-2"></i>Data Dasar Bahan
                </h4>
                
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
                            placeholder="Contoh: Kangkung, Bawang Merah"
                            value="{{ old('nama_bahan') }}"
                            required
                        >
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
                            required
                        >
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
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
                            required
                        >
                            <option value="">-- Pilih Supplier --</option>
                            @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
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
                            required
                        >
                            <option value="">-- Pilih Satuan --</option>
                            <option value="Kg" {{ old('satuan') == 'Kg' ? 'selected' : '' }}>Kilogram (Kg)</option>
                            <option value="Gram" {{ old('satuan') == 'Gram' ? 'selected' : '' }}>Gram</option>
                            <option value="Liter" {{ old('satuan') == 'Liter' ? 'selected' : '' }}>Liter</option>
                            <option value="Ml" {{ old('satuan') == 'Ml' ? 'selected' : '' }}>Mililiter (Ml)</option>
                            <option value="Ikat" {{ old('satuan') == 'Ikat' ? 'selected' : '' }}>Ikat</option>
                            <option value="Bungkus" {{ old('satuan') == 'Bungkus' ? 'selected' : '' }}>Bungkus</option>
                            <option value="Botol" {{ old('satuan') == 'Botol' ? 'selected' : '' }}>Botol</option>
                            <option value="Pcs" {{ old('satuan') == 'Pcs' ? 'selected' : '' }}>Pieces (Pcs)</option>
                            <option value="Buah" {{ old('satuan') == 'Buah' ? 'selected' : '' }}>Buah</option>
                            <option value="Papan" {{ old('satuan') == 'Papan' ? 'selected' : '' }}>Papan</option>
                            <option value="Biji" {{ old('satuan') == 'Biji' ? 'selected' : '' }}>Biji</option>
                            <option value="Sisir" {{ old('satuan') == 'Sisir' ? 'selected' : '' }}>Sisir</option>
                            <option value="Pack" {{ old('satuan') == 'Pack' ? 'selected' : '' }}>Pack</option>
                        </select>
                    </div>
                    
                    <!-- Stok Saat Ini -->
                    <div class="md:col-span-2">
                        <label for="stok_saat_ini" class="block text-sm font-semibold text-gray-700 mb-2">
                            Stok Awal <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="stok_saat_ini" 
                            id="stok_saat_ini" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none"
                            placeholder="Masukkan jumlah stok awal"
                            value="{{ old('stok_saat_ini', 0) }}"
                            min="0"
                            required
                        >
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-info-circle mr-1"></i>Stok awal bahan baku saat pertama kali ditambahkan
                        </p>
                    </div>
                    
                </div>
            </div>
            
            <!-- Section: Kriteria SAW -->
            <div class="mb-8">
                <h4 class="text-md font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">
                    <i class="fas fa-calculator text-emerald-600 mr-2"></i>Kriteria untuk Perhitungan SAW
                </h4>
                
                <div class="grid grid-cols-1 gap-6">
                    
                    <!-- Nilai C1 (Sisa Stok - Threshold Minimum) -->
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <label for="nilai_c1" class="block text-sm font-semibold text-gray-800 mb-2">
                            <i class="fas fa-box text-red-600 mr-2"></i>C1 - Sisa Stok (Batas Minimum) <span class="text-red-500">*</span>
                        </label>
                        <p class="text-xs text-gray-700 mb-3">
                            Berapa stok minimum yang aman? Jika stok di bawah angka ini, sistem akan prioritaskan untuk dibeli.
                        </p>
                        <input 
                            type="number" 
                            name="nilai_c1" 
                            id="nilai_c1" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none bg-white"
                            placeholder="Contoh: 10"
                            value="{{ old('nilai_c1', 10) }}"
                            min="1"
                            required
                        >
                        <div class="mt-3 bg-white rounded p-3 border border-gray-200">
                            <p class="text-xs text-gray-700">
                                <strong>Contoh:</strong><br>
                                • Kangkung: <strong>10 ikat</strong> (Kritis jika stok < 10)<br>
                                • Garam: <strong>5 kg</strong> (Kritis jika stok < 5)<br>
                                • Beras: <strong>50 kg</strong> (Kritis jika stok < 50)
                            </p>
                        </div>
                    </div>
                    
                    <!-- Nilai C2 (Tingkat Kadaluarsa) - Skala 1-5 -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <label for="nilai_c2" class="block text-sm font-semibold text-gray-800 mb-2">
                            <i class="fas fa-hourglass-half text-blue-600 mr-2"></i>C2 - Tingkat Kadaluarsa <span class="text-red-500">*</span>
                        </label>
                        <p class="text-xs text-gray-700 mb-3">
                            Seberapa cepat bahan ini basi/rusak? Pilih skala 1–5.
                        </p>
                        <select 
                            name="nilai_c2" 
                            id="nilai_c2" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none bg-white"
                            required
                        >
                            <option value="">-- Pilih Tingkat Kadaluarsa --</option>
                            <option value="1" {{ old('nilai_c2') == '1' ? 'selected' : '' }}>1 — Sangat Tahan Lama (Beras, Gula, Minyak, Bumbu Kering)</option>
                            <option value="2" {{ old('nilai_c2') == '2' ? 'selected' : '' }}>2 — Tahan Lama (Kentang, Bawang, Makanan Kaleng)</option>
                            <option value="3" {{ old('nilai_c2') == '3' ? 'selected' : '' }}>3 — Sedang (Telur, Buah, Daging Beku)</option>
                            <option value="4" {{ old('nilai_c2') == '4' ? 'selected' : '' }}>4 — Mudah Basi (Daging Segar, Tahu, Tempe)</option>
                            <option value="5" {{ old('nilai_c2') == '5' ? 'selected' : '' }}>5 — Sangat Mudah Basi (Sayuran Hijau, Ikan, Susu Segar)</option>
                        </select>
                        <div class="mt-3 grid grid-cols-5 gap-1 text-xs text-center">
                            <div class="bg-green-100 rounded p-1 border border-green-200"><span class="font-bold text-green-700">1</span><br>Sangat Tahan</div>
                            <div class="bg-lime-100 rounded p-1 border border-lime-200"><span class="font-bold text-lime-700">2</span><br>Tahan</div>
                            <div class="bg-yellow-100 rounded p-1 border border-yellow-200"><span class="font-bold text-yellow-700">3</span><br>Sedang</div>
                            <div class="bg-orange-100 rounded p-1 border border-orange-200"><span class="font-bold text-orange-700">4</span><br>Mudah Basi</div>
                            <div class="bg-red-100 rounded p-1 border border-red-200"><span class="font-bold text-red-700">5</span><br>Sangat Cepat</div>
                        </div>
                    </div>
                    
                    <!-- Nilai C3 (Kebutuhan Harian) - Skala 1-5 -->
                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                        <label for="nilai_c3" class="block text-sm font-semibold text-gray-800 mb-2">
                            <i class="fas fa-utensils text-purple-600 mr-2"></i>C3 - Estimasi Kebutuhan Harian <span class="text-red-500">*</span>
                        </label>
                        <p class="text-xs text-gray-700 mb-3">
                            Seberapa besar kebutuhan harian bahan ini? Pilih skala 1–5.
                        </p>
                        <select 
                            name="nilai_c3" 
                            id="nilai_c3" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none bg-white"
                            required
                        >
                            <option value="">-- Pilih Tingkat Kebutuhan Harian --</option>
                            <option value="1" {{ old('nilai_c3') == '1' ? 'selected' : '' }}>1 — Sangat Rendah (jarang dipakai, misal bumbu pelengkap)</option>
                            <option value="2" {{ old('nilai_c3') == '2' ? 'selected' : '' }}>2 — Rendah (dipakai beberapa kali seminggu)</option>
                            <option value="3" {{ old('nilai_c3') == '3' ? 'selected' : '' }}>3 — Sedang (dipakai setiap hari, jumlah normal)</option>
                            <option value="4" {{ old('nilai_c3') == '4' ? 'selected' : '' }}>4 — Tinggi (kebutuhan besar setiap hari)</option>
                            <option value="5" {{ old('nilai_c3') == '5' ? 'selected' : '' }}>5 — Sangat Tinggi (bahan utama, habis banyak tiap hari)</option>
                        </select>
                        <div class="mt-3 grid grid-cols-5 gap-1 text-xs text-center">
                            <div class="bg-green-100 rounded p-1 border border-green-200"><span class="font-bold text-green-700">1</span><br>Sangat Rendah</div>
                            <div class="bg-lime-100 rounded p-1 border border-lime-200"><span class="font-bold text-lime-700">2</span><br>Rendah</div>
                            <div class="bg-yellow-100 rounded p-1 border border-yellow-200"><span class="font-bold text-yellow-700">3</span><br>Sedang</div>
                            <div class="bg-orange-100 rounded p-1 border border-orange-200"><span class="font-bold text-orange-700">4</span><br>Tinggi</div>
                            <div class="bg-purple-100 rounded p-1 border border-purple-200"><span class="font-bold text-purple-700">5</span><br>Sangat Tinggi</div>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <!-- Info Box SAW -->
            <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-emerald-800 mb-2">
                    <i class="fas fa-lightbulb mr-2"></i>Catatan Penting
                </h4>
                <ul class="text-xs text-emerald-700 space-y-1">
                    <li><strong>C1</strong> = angka threshold minimum stok (contoh: 10 kg)</li>
                    <li><strong>C2 & C3</strong> = skala 1–5 yang dipilih Manajer (1=rendah, 5=tinggi)</li>
                    <li><strong>Bobot SAW:</strong> C1 = 40%, C2 = 30%, C3 = 30%</li>
                    <li>Semakin tinggi skor SAW = semakin prioritas untuk dibeli/diisi stok</li>
                </ul>
            </div>
            
            <!-- Buttons -->
            <div class="flex items-center space-x-3">
                <button type="submit" class="px-6 py-2 bg-emerald-500 text-white font-semibold rounded-lg hover:bg-emerald-600 transition">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
                <a href="{{ route('manajer.bahan-baku.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-400 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
            
        </form>
        
    </div>
    
</div>

@endsection
@extends('layouts.app')

@section('title', 'Bahan Baku')
@section('page-title', 'Bahan Baku')
@section('page-subtitle', 'Kelola data bahan baku restoran.')

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

<!-- Action Button -->
<div class="mb-6">
    <a href="{{ route('manajer.bahan-baku.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-semibold rounded-lg hover:from-emerald-600 hover:to-teal-600 transition-all shadow-lg hover:shadow-xl">
        <i class="fas fa-plus mr-2"></i>Tambah Bahan Baku
    </a>
</div>

<!-- Filter & Search -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
    <form method="GET" action="{{ route('manajer.bahan-baku.index') }}" class="flex flex-col md:flex-row gap-4">
        
        <!-- Search Box -->
        <div class="flex-1">
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input 
                    type="text" 
                    name="search" 
                    class="w-full pl-11 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none"
                    placeholder="Cari nama bahan, kategori, atau supplier..."
                    value="{{ request('search') }}"
                >
            </div>
        </div>
        
        <!-- Filter Kategori -->
        <div class="md:w-64">
            <select 
                name="kategori_id" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none"
                onchange="this.form.submit()"
            >
                <option value="">📁 Semua Kategori</option>
                @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                    {{ $kategori->nama_kategori }}
                </option>
                @endforeach
            </select>
        </div>
        
        <!-- Buttons -->
        <div class="flex gap-2">
            <button type="submit" class="px-6 py-2 bg-emerald-500 text-white font-semibold rounded-lg hover:bg-emerald-600 transition">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
            @if(request('search') || request('kategori_id'))
            <a href="{{ route('manajer.bahan-baku.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-400 transition">
                <i class="fas fa-redo mr-2"></i>Reset
            </a>
            @endif
        </div>
        
    </form>
</div>

<!-- Active Filters Display -->
@if(request('search') || request('kategori_id'))
<div class="mb-4 flex items-center gap-2 text-sm">
    <span class="text-gray-600">Filter aktif:</span>
    @if(request('search'))
    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full">
        <i class="fas fa-search mr-1"></i>{{ request('search') }}
    </span>
    @endif
    @if(request('kategori_id'))
    <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full">
        <i class="fas fa-tag mr-1"></i>{{ $kategoris->find(request('kategori_id'))->nama_kategori ?? 'Kategori' }}
    </span>
    @endif
</div>
@endif

<!-- Table Bahan Baku -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <h3 class="text-lg font-bold text-gray-800">
            <i class="fas fa-list mr-2 text-emerald-600"></i>Daftar Bahan Baku
        </h3>
        <p class="text-sm text-gray-600 mt-1">Total: {{ $bahanBakus->total() }} bahan baku</p>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nama Bahan</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Supplier</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Satuan</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Stok</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">C1</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">C2</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">C3</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($bahanBakus as $index => $bahan)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-gray-600">{{ $bahanBakus->firstItem() + $index }}</td>
                    <td class="px-6 py-4">
                        <span class="font-semibold text-gray-800">{{ $bahan->nama_bahan }}</span>
                    </td>
                    <td class="px-6 py-4 text-gray-600 text-sm">{{ $bahan->kategori->nama_kategori }}</td>
                    <td class="px-6 py-4 text-gray-600 text-sm">{{ $bahan->supplier->nama_supplier }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $bahan->satuan }}</td>
                    <td class="px-6 py-4">
                        <span class="font-bold text-gray-800">{{ $bahan->stok_saat_ini }}</span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $bahan->nilai_c1 }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $bahan->nilai_c2 }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $bahan->nilai_c3 }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $bahan->status_color }}">
                            {{ $bahan->status_stok }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center space-x-2">
                            <button onclick="openModalPembelian({{ $bahan->id }}, '{{ $bahan->nama_bahan }}', {{ $bahan->stok_saat_ini }}, '{{ $bahan->satuan }}')"
                                class="px-3 py-1.5 bg-green-500 text-white text-sm font-medium rounded-lg hover:bg-green-600 transition" title="Tambah Stok Pembelian">
                                <i class="fas fa-plus"></i>
                            </button>
                            <a href="{{ route('manajer.bahan-baku.edit', $bahan->id) }}" class="px-3 py-1.5 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 transition" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('manajer.bahan-baku.destroy', $bahan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus bahan baku ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 bg-red-500 text-white text-sm font-medium rounded-lg hover:bg-red-600 transition" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                        <p>{{ request('search') || request('kategori_id') ? 'Tidak ada hasil yang sesuai dengan pencarian.' : 'Belum ada data bahan baku.' }}</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($bahanBakus->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $bahanBakus->appends(request()->query())->links() }}
    </div>
    @endif
    
</div>

<!-- Modal Tambah Stok Pembelian -->
<div id="modal-pembelian" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-xl flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-800">
                    <i class="fas fa-shopping-cart text-green-600 mr-2"></i>Tambah Stok Pembelian
                </h3>
                <p id="modal-nama-bahan" class="text-sm text-gray-600 mt-0.5"></p>
            </div>
            <button onclick="closeModalPembelian()" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form id="form-pembelian" method="POST" class="p-6 space-y-4">
            @csrf
            <!-- Info stok saat ini -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-3 flex items-center justify-between">
                <span class="text-sm text-green-700">Stok Saat Ini:</span>
                <span id="modal-stok-sekarang" class="font-bold text-green-700 text-lg"></span>
            </div>
            <!-- Input pembelian -->
            <div>
                <label for="jumlah_pembelian" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-plus-circle text-green-600 mr-1"></i>Jumlah Pembelian <span class="text-red-500">*</span>
                </label>
                <input type="number" name="jumlah_pembelian" id="jumlah_pembelian" min="1"
                    class="w-full px-4 py-3 text-xl border-2 border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none text-center font-bold"
                    placeholder="0" required>
            </div>
            <!-- Preview stok setelah pembelian -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 flex items-center justify-between">
                <span class="text-sm text-gray-600">Stok Setelah Pembelian:</span>
                <span id="modal-preview-stok" class="font-bold text-blue-700 text-lg">-</span>
            </div>
            <!-- Keterangan -->
            <div>
                <label for="keterangan_pembelian" class="block text-sm font-semibold text-gray-700 mb-2">Keterangan (opsional)</label>
                <input type="text" name="keterangan" id="keterangan_pembelian"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 outline-none"
                    placeholder="Contoh: Beli dari supplier, datang 50 kg..." maxlength="200">
            </div>
            <!-- Tombol -->
            <div class="flex space-x-3 pt-2">
                <button type="submit" class="flex-1 px-4 py-3 bg-green-500 text-white font-bold rounded-lg hover:bg-green-600 transition">
                    <i class="fas fa-check mr-2"></i>Simpan Pembelian
                </button>
                <button type="button" onclick="closeModalPembelian()" class="px-4 py-3 bg-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-400 transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let stokSaatIni = 0;

    function openModalPembelian(id, nama, stok, satuan) {
        stokSaatIni = stok;
        document.getElementById('modal-nama-bahan').textContent = nama;
        document.getElementById('modal-stok-sekarang').textContent = stok + ' ' + satuan;
        document.getElementById('modal-preview-stok').textContent = stok + ' ' + satuan;
        document.getElementById('jumlah_pembelian').value = '';
        document.getElementById('keterangan_pembelian').value = '';
        document.getElementById('form-pembelian').action = '/manajer/bahan-baku/' + id + '/tambah-stok';
        document.getElementById('modal-pembelian').classList.remove('hidden');
    }

    function closeModalPembelian() {
        document.getElementById('modal-pembelian').classList.add('hidden');
    }

    document.getElementById('jumlah_pembelian').addEventListener('input', function() {
        const jumlah = parseInt(this.value) || 0;
        const preview = document.getElementById('modal-preview-stok');
        const satuanText = document.getElementById('modal-stok-sekarang').textContent.split(' ').slice(1).join(' ');
        preview.textContent = (stokSaatIni + jumlah) + ' ' + satuanText;
    });
</script>

@endsection
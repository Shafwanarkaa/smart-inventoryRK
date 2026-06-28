@extends('layouts.app')

@section('title', 'Histori Transaksi Stok')
@section('page-title', 'Histori Transaksi Stok')
@section('page-subtitle', 'Riwayat pemakaian dan pembelian bahan baku')

@section('sidebar')
<a href="{{ route('manajer.dashboard') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
    <i class="fas fa-home w-5"></i><span class="font-medium">Dashboard</span>
</a>
<a href="{{ route('manajer.bahan-baku.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
    <i class="fas fa-box w-5"></i><span class="font-medium">Bahan Baku</span>
</a>
<a href="{{ route('manajer.ranking-saw') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
    <i class="fas fa-trophy w-5"></i><span class="font-medium">Ranking SAW</span>
</a>
<a href="{{ route('manajer.peringatan-stok') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
    <i class="fas fa-exclamation-triangle w-5"></i><span class="font-medium">Peringatan Stok</span>
</a>
<a href="{{ route('manajer.histori-stok') }}" class="sidebar-link sidebar-active flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition">
    <i class="fas fa-history w-5"></i><span class="font-medium">Histori Stok</span>
</a>
<a href="{{ route('manajer.kategori.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
    <i class="fas fa-tags w-5"></i><span class="font-medium">Kategori</span>
</a>
<a href="{{ route('manajer.supplier.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
    <i class="fas fa-truck w-5"></i><span class="font-medium">Supplier</span>
</a>
<div class="mt-2 pt-2 border-t border-gray-200">
    <a href="{{ route('manajer.users.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
        <i class="fas fa-users w-5"></i><span class="font-medium">Kelola User</span>
    </a>
</div>
@endsection

@section('content')
<div class="space-y-5">

    {{-- Flash Message --}}
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 rounded-xl px-5 py-3 flex items-center gap-3">
        <i class="fas fa-check-circle text-emerald-500 text-lg"></i>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif

    {{-- ===== STAT CARDS ===== --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center space-x-4 shadow-sm">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-history text-blue-600 text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold tracking-wide">Total Semua Log</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($totalLog) }}</p>
                <p class="text-xs text-gray-400">seluruh waktu</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-orange-200 p-4 flex items-center space-x-4 shadow-sm">
            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-utensils text-orange-500 text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-orange-500 uppercase font-semibold tracking-wide">Pemakaian Hari Ini</p>
                <p class="text-2xl font-bold text-gray-800">{{ $pemakaianHariIni }}</p>
                <p class="text-xs text-gray-400">transaksi oleh koki</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-green-200 p-4 flex items-center space-x-4 shadow-sm">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-shopping-cart text-green-600 text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-green-600 uppercase font-semibold tracking-wide">Pembelian Hari Ini</p>
                <p class="text-2xl font-bold text-gray-800">{{ $pembelianHariIni }}</p>
                <p class="text-xs text-gray-400">transaksi oleh manajer</p>
            </div>
        </div>

    </div>

    {{-- ===== FILTER SIMPEL ===== --}}
    @php
        $activePreset = request('preset') ?? '';
        $activeTipe   = request('tipe') ?? '';
    @endphp

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 space-y-3">

        {{-- Baris 1: Preset Tanggal --}}
        <div class="flex flex-wrap items-center gap-2">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                <i class="fas fa-calendar mr-1"></i>Periode:
            </span>

            <a href="{{ route('manajer.histori-stok', array_merge(request()->except(['preset','dari','sampai']), ['preset'=>'hari_ini'])) }}"
               class="px-4 py-1.5 rounded-full text-sm font-semibold transition
                      {{ $activePreset === 'hari_ini' ? 'bg-emerald-500 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-emerald-100 hover:text-emerald-700' }}">
                Hari Ini
            </a>
            <a href="{{ route('manajer.histori-stok', array_merge(request()->except(['preset','dari','sampai']), ['preset'=>'minggu_ini'])) }}"
               class="px-4 py-1.5 rounded-full text-sm font-semibold transition
                      {{ $activePreset === 'minggu_ini' ? 'bg-emerald-500 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-emerald-100 hover:text-emerald-700' }}">
                Minggu Ini
            </a>
            <a href="{{ route('manajer.histori-stok', array_merge(request()->except(['preset','dari','sampai']), ['preset'=>'bulan_ini'])) }}"
               class="px-4 py-1.5 rounded-full text-sm font-semibold transition
                      {{ $activePreset === 'bulan_ini' ? 'bg-emerald-500 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-emerald-100 hover:text-emerald-700' }}">
                Bulan Ini
            </a>

            <button type="button" onclick="toggleCustomDate()"
                class="px-4 py-1.5 rounded-full text-sm font-semibold transition
                       {{ ($dari && !$activePreset) ? 'bg-blue-500 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-blue-100 hover:text-blue-700' }}">
                <i class="fas fa-calendar-alt mr-1"></i>
                {{ ($dari && !$activePreset) ? date('d/m', strtotime($dari)).' – '.date('d/m', strtotime($sampai ?? $dari)) : 'Pilih Tanggal' }}
            </button>

            @if(request()->anyFilled(['preset','dari','sampai','tipe']))
            <a href="{{ route('manajer.histori-stok') }}"
               class="px-3 py-1.5 rounded-full text-sm font-semibold bg-red-50 text-red-500 hover:bg-red-100 transition ml-auto">
                <i class="fas fa-times mr-1"></i>Reset
            </a>
            @endif
        </div>

        {{-- Custom date picker (tersembunyi default) --}}
        <div id="custom-date-box" class="{{ ($dari && !$activePreset) ? '' : 'hidden' }} flex flex-wrap items-center gap-3 pb-1">
            <form method="GET" action="{{ route('manajer.histori-stok') }}" class="flex flex-wrap gap-2 items-center">
                @if($activeTipe) <input type="hidden" name="tipe" value="{{ $activeTipe }}"> @endif
                <div class="flex items-center gap-2">
                    <label class="text-sm text-gray-500 font-medium">Dari</label>
                    <input type="date" name="dari" value="{{ $dari }}"
                        class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div class="flex items-center gap-2">
                    <label class="text-sm text-gray-500 font-medium">Sampai</label>
                    <input type="date" name="sampai" value="{{ $sampai }}"
                        class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <button type="submit" class="px-4 py-1.5 bg-emerald-500 text-white text-sm font-semibold rounded-lg hover:bg-emerald-600 transition">
                    Terapkan
                </button>
            </form>
        </div>

        {{-- Baris 2: Toggle Tipe --}}
        <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-gray-100">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                <i class="fas fa-filter mr-1"></i>Tampilkan:
            </span>
            <a href="{{ route('manajer.histori-stok', request()->except('tipe')) }}"
               class="px-4 py-1.5 rounded-full text-sm font-semibold transition
                      {{ $activeTipe === '' ? 'bg-gray-700 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Semua Transaksi
            </a>
            <a href="{{ route('manajer.histori-stok', array_merge(request()->except('tipe'), ['tipe'=>'pemakaian'])) }}"
               class="px-4 py-1.5 rounded-full text-sm font-semibold transition
                      {{ $activeTipe === 'pemakaian' ? 'bg-orange-500 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-orange-100 hover:text-orange-700' }}">
                <i class="fas fa-utensils mr-1"></i>Pemakaian (Koki)
            </a>
            <a href="{{ route('manajer.histori-stok', array_merge(request()->except('tipe'), ['tipe'=>'pembelian'])) }}"
               class="px-4 py-1.5 rounded-full text-sm font-semibold transition
                      {{ $activeTipe === 'pembelian' ? 'bg-green-500 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-green-100 hover:text-green-700' }}">
                <i class="fas fa-shopping-cart mr-1"></i>Pembelian (Manajer)
            </a>
        </div>

    </div>

    {{-- ===== TABEL ===== --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h3 class="text-base font-bold text-gray-800">
                    <i class="fas fa-list mr-2 text-emerald-600"></i>Log Perubahan Stok
                </h3>
                <p class="text-xs text-gray-500 mt-0.5">
                    Menampilkan <strong>{{ $historis->total() }}</strong> entri
                    @if($activePreset === 'hari_ini') <span class="text-emerald-600 font-semibold">— Hari Ini</span>
                    @elseif($activePreset === 'minggu_ini') <span class="text-emerald-600 font-semibold">— Minggu Ini</span>
                    @elseif($activePreset === 'bulan_ini') <span class="text-emerald-600 font-semibold">— Bulan Ini</span>
                    @elseif($dari) <span class="text-blue-600 font-semibold">— {{ $dari }} s/d {{ $sampai }}</span>
                    @endif
                    @if($activeTipe === 'pemakaian') <span class="text-orange-500 font-semibold">· Pemakaian saja</span>
                    @elseif($activeTipe === 'pembelian') <span class="text-green-600 font-semibold">· Pembelian saja</span>
                    @endif
                </p>
            </div>

            {{-- Tombol Export + Reset --}}
            <div class="flex items-center gap-2">
                <a href="{{ route('manajer.histori-stok.export-excel', request()->query()) }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-lg hover:bg-emerald-700 transition shadow-sm"
                   title="Download sebagai Excel (.xlsx)">
                    <i class="fas fa-file-excel"></i>
                    <span>Excel</span>
                </a>
                <a href="{{ route('manajer.histori-stok.export-pdf', request()->query()) }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition shadow-sm"
                   title="Download sebagai PDF">
                    <i class="fas fa-file-pdf"></i>
                    <span>PDF</span>
                </a>
                <button onclick="document.getElementById('modal-reset').classList.remove('hidden')"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 text-gray-600 text-sm font-semibold rounded-lg hover:bg-red-50 hover:text-red-600 border border-gray-200 hover:border-red-300 transition"
                   title="Hapus semua histori">
                    <i class="fas fa-trash-alt"></i>
                    <span>Reset</span>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Waktu</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Bahan Baku</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Oleh</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Tipe</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Jumlah</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Sisa Stok</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($historis as $h)
                    <tr class="hover:bg-gray-50 transition-colors">

                        <td class="px-4 py-3 whitespace-nowrap">
                            <p class="text-gray-800 font-medium text-xs">{{ $h->created_at->format('d M Y') }}</p>
                            <p class="text-gray-400 text-xs">{{ $h->created_at->format('H:i') }} WIB</p>
                        </td>

                        <td class="px-4 py-3">
                            <p class="font-semibold text-gray-800">{{ $h->bahanBaku->nama_bahan }}</p>
                            <p class="text-xs text-gray-400">{{ $h->bahanBaku->kategori->nama_kategori ?? '-' }}</p>
                        </td>

                        <td class="px-4 py-3">
                            <p class="text-xs font-medium text-gray-800">{{ $h->user->username }}</p>
                            <p class="text-xs text-gray-400 capitalize">{{ $h->user->role }}</p>
                        </td>

                        <td class="px-4 py-3 text-center">
                            @if(($h->tipe ?? 'pemakaian') === 'pembelian')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                    <i class="fas fa-shopping-cart mr-1"></i>Pembelian
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-800">
                                    <i class="fas fa-utensils mr-1"></i>Pemakaian
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-center">
                            @if($h->selisih > 0)
                                <span class="text-green-700 font-bold text-sm">+{{ $h->selisih }} {{ $h->bahanBaku->satuan }}</span>
                            @else
                                <span class="text-red-600 font-bold text-sm">-{{ abs($h->selisih) }} {{ $h->bahanBaku->satuan }}</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-center">
                            <span class="font-bold text-gray-800">{{ $h->stok_sesudah }}</span>
                            <span class="text-xs text-gray-400 ml-0.5">{{ $h->bahanBaku->satuan }}</span>
                        </td>

                        <td class="px-4 py-3 max-w-xs">
                            @if($h->keterangan)
                                <span class="text-xs text-gray-600 italic">"{{ $h->keterangan }}"</span>
                            @else
                                <span class="text-xs text-gray-300">—</span>
                            @endif
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-14 text-center text-gray-400">
                            <i class="fas fa-history text-4xl mb-3 text-gray-200 block"></i>
                            <p class="font-medium">Belum ada histori untuk periode ini</p>
                            <p class="text-xs mt-1">Coba klik "Hari Ini", "Minggu Ini", atau "Semua Transaksi" di atas</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($historis->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $historis->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>

{{-- Modal Konfirmasi Reset --}}
<div id="modal-reset" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-60">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4">
        <div class="px-6 py-5 border-b border-gray-200 flex items-center gap-3">
            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-red-500"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-800">Reset Semua Histori Stok</h3>
                <p class="text-xs text-gray-500 mt-0.5">Tindakan ini tidak dapat dibatalkan</p>
            </div>
        </div>
        <div class="px-6 py-5 space-y-4">
            <p class="text-sm text-gray-700">
                Kamu akan <strong class="text-red-600">menghapus seluruh data histori stok</strong>.
                Data yang sudah dihapus <strong>tidak bisa dikembalikan</strong>.
            </p>
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 text-xs text-amber-800">
                <i class="fas fa-lightbulb mr-1"></i>
                <strong>Tips:</strong> Export dulu ke Excel atau PDF sebelum reset agar data tetap tersimpan.
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Ketik <span class="text-red-600 font-mono">HAPUS</span> untuk konfirmasi:
                </label>
                <input type="text" id="konfirmasi-reset" placeholder="Ketik HAPUS di sini..."
                    class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-400 focus:border-red-400 outline-none"
                    oninput="checkKonfirmasi()">
            </div>
        </div>
        <div class="px-6 py-4 bg-gray-50 rounded-b-2xl flex gap-3">
            <form action="{{ route('manajer.histori-stok.reset') }}" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" id="btn-hapus" disabled
                    class="w-full px-4 py-2.5 bg-red-500 text-white font-bold rounded-lg transition
                           disabled:opacity-40 disabled:cursor-not-allowed hover:bg-red-600">
                    <i class="fas fa-trash mr-2"></i>Ya, Hapus Semua
                </button>
            </form>
            <button onclick="closeModalReset()"
                class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-100 transition">
                Batal
            </button>
        </div>
    </div>
</div>

<script>
    function toggleCustomDate() {
        document.getElementById('custom-date-box').classList.toggle('hidden');
    }

    function checkKonfirmasi() {
        const val = document.getElementById('konfirmasi-reset').value;
        const btn = document.getElementById('btn-hapus');
        btn.disabled = (val !== 'HAPUS');
    }

    function closeModalReset() {
        document.getElementById('modal-reset').classList.add('hidden');
        document.getElementById('konfirmasi-reset').value = '';
        document.getElementById('btn-hapus').disabled = true;
    }

    // Tutup modal kalau klik di luar
    document.getElementById('modal-reset').addEventListener('click', function(e) {
        if (e.target === this) closeModalReset();
    });
</script>

@endsection

@extends('layouts.app')

@section('title', 'Histori Transaksi Stok')
@section('page-title', 'Histori Transaksi Stok')
@section('page-subtitle', 'Log lengkap semua perubahan stok bahan baku')

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
<a href="{{ route('manajer.users.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
    <i class="fas fa-users w-5"></i><span class="font-medium">Kelola User</span>
</a>
@endsection

@section('content')
<div class="space-y-6">

    {{-- Stat Card --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center space-x-4 shadow-sm">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-history text-blue-600 text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Total Log</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($totalLog) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center space-x-4 shadow-sm">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-arrow-up text-green-600 text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Stok Naik</p>
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\HistoriStok::where('selisih', '>', 0)->count() }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center space-x-4 shadow-sm">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-arrow-down text-red-600 text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Stok Turun</p>
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\HistoriStok::where('selisih', '<', 0)->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <form method="GET" action="{{ route('manajer.histori-stok') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">

            {{-- Filter Bahan --}}
            <select name="bahan_baku_id" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                <option value="">📦 Semua Bahan</option>
                @foreach($bahanList as $b)
                    <option value="{{ $b->id }}" {{ request('bahan_baku_id') == $b->id ? 'selected' : '' }}>
                        {{ $b->nama_bahan }}
                    </option>
                @endforeach
            </select>

            {{-- Filter User --}}
            <select name="user_id" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                <option value="">👤 Semua User</option>
                @foreach($userList as $u)
                    <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                        {{ $u->username }} ({{ $u->role }})
                    </option>
                @endforeach
            </select>

            {{-- Filter Arah --}}
            <select name="arah" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                <option value="">↕️ Semua Perubahan</option>
                <option value="naik"  {{ request('arah') === 'naik'  ? 'selected' : '' }}>↑ Stok Naik</option>
                <option value="turun" {{ request('arah') === 'turun' ? 'selected' : '' }}>↓ Stok Turun</option>
                <option value="tetap" {{ request('arah') === 'tetap' ? 'selected' : '' }}>= Tidak Berubah</option>
            </select>

            {{-- Filter Tanggal Dari --}}
            <input type="date" name="dari" value="{{ request('dari') }}"
                class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none">

            {{-- Filter Sampai --}}
            <input type="date" name="sampai" value="{{ request('sampai') }}"
                class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none">

            {{-- Tombol --}}
            <button type="submit"
                class="sm:col-span-2 lg:col-span-3 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition flex items-center justify-center gap-2">
                <i class="fas fa-filter"></i> Terapkan Filter
            </button>
            @if(request()->anyFilled(['bahan_baku_id','user_id','arah','dari','sampai']))
            <a href="{{ route('manajer.histori-stok') }}"
                class="sm:col-span-2 lg:col-span-2 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-semibold rounded-lg transition flex items-center justify-center gap-2">
                <i class="fas fa-times"></i> Reset Filter
            </a>
            @endif
        </form>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-gray-800"><i class="fas fa-list mr-2 text-emerald-600"></i>Log Perubahan Stok</h3>
                <p class="text-xs text-gray-500 mt-0.5">Menampilkan {{ $historis->total() }} entri</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-600 uppercase">#</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Waktu</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Bahan Baku</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Diubah Oleh</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Sebelum</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Sesudah</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Selisih</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($historis as $index => $h)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 text-gray-400 text-xs">{{ $historis->firstItem() + $index }}</td>
                        <td class="px-4 py-3">
                            <p class="text-gray-800 font-medium text-xs">{{ $h->created_at->format('d M Y') }}</p>
                            <p class="text-gray-400 text-xs">{{ $h->created_at->format('H:i') }} WIB</p>
                        </td>
                        <td class="px-4 py-3">
                            <p class="font-semibold text-gray-800">{{ $h->bahanBaku->nama_bahan }}</p>
                            <p class="text-xs text-gray-500">{{ $h->bahanBaku->kategori->nama_kategori ?? '-' }}</p>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center space-x-2">
                                <div class="w-7 h-7 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-user text-emerald-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800 text-xs">{{ $h->user->username }}</p>
                                    <p class="text-gray-400 text-xs capitalize">{{ $h->user->role }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="font-bold text-gray-600">{{ $h->stok_sebelum }}</span>
                            <p class="text-xs text-gray-400">{{ $h->bahanBaku->satuan }}</p>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="font-bold text-gray-800">{{ $h->stok_sesudah }}</span>
                            <p class="text-xs text-gray-400">{{ $h->bahanBaku->satuan }}</p>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold {{ $h->arah_color }}">
                                @if($h->selisih > 0)
                                    <i class="fas fa-arrow-up mr-1"></i>+{{ $h->selisih }}
                                @elseif($h->selisih < 0)
                                    <i class="fas fa-arrow-down mr-1"></i>{{ $h->selisih }}
                                @else
                                    <i class="fas fa-minus mr-1"></i>0
                                @endif
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @if($h->keterangan)
                                <span class="text-xs text-gray-700 italic">"{{ $h->keterangan }}"</span>
                            @else
                                <span class="text-xs text-gray-300">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                            <i class="fas fa-history text-4xl mb-3 text-gray-200"></i>
                            <p class="font-medium">Belum ada histori perubahan stok</p>
                            <p class="text-xs mt-1">Histori akan muncul setelah koki/staff melakukan update stok</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($historis->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $historis->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>
@endsection

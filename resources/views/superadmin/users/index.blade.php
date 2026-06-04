@extends('layouts.app')

@section('title', 'Kelola User')
@section('page-title', 'Kelola User')
@section('page-subtitle', 'Manajemen akun pengguna sistem')

@section('sidebar')
    <div class="space-y-1">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-3">Super Admin</p>

        <a href="{{ route('superadmin.users.index') }}"
            class="sidebar-link sidebar-active flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all">
            <i class="fas fa-users w-5 text-center"></i>
            <span>Kelola User</span>
        </a>

        <a href="{{ route('manajer.dashboard') }}"
            class="sidebar-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 transition-all">
            <i class="fas fa-tachometer-alt w-5 text-center"></i>
            <span>Dashboard Manajer</span>
        </a>
    </div>
@endsection

@section('content')
<div class="space-y-6">

    {{-- Header Aksi --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h3 class="text-lg font-semibold text-gray-700">Daftar Semua User</h3>
            <p class="text-sm text-gray-500">Total {{ $users->count() }} akun terdaftar</p>
        </div>
        <a href="{{ route('superadmin.users.create') }}"
            class="inline-flex items-center px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors shadow">
            <i class="fas fa-plus mr-2"></i> Tambah User Baru
        </a>
    </div>

    {{-- Tabel User --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left px-6 py-4 font-semibold text-gray-600 uppercase tracking-wider text-xs">#</th>
                        <th class="text-left px-6 py-4 font-semibold text-gray-600 uppercase tracking-wider text-xs">Username</th>
                        <th class="text-left px-6 py-4 font-semibold text-gray-600 uppercase tracking-wider text-xs">Role</th>
                        <th class="text-left px-6 py-4 font-semibold text-gray-600 uppercase tracking-wider text-xs">Status</th>
                        <th class="text-right px-6 py-4 font-semibold text-gray-600 uppercase tracking-wider text-xs">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($users as $index => $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0
                                    @if($user->role === 'super_admin') bg-purple-100
                                    @elseif($user->role === 'manajer') bg-blue-100
                                    @elseif($user->role === 'koki') bg-orange-100
                                    @else bg-gray-100 @endif">
                                    <i class="fas fa-user text-sm
                                        @if($user->role === 'super_admin') text-purple-600
                                        @elseif($user->role === 'manajer') text-blue-600
                                        @elseif($user->role === 'koki') text-orange-600
                                        @else text-gray-600 @endif"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $user->username }}</p>
                                    @if($user->id === auth()->id())
                                        <p class="text-xs text-emerald-600 font-medium">(Anda)</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                @if($user->role === 'super_admin') bg-purple-100 text-purple-800
                                @elseif($user->role === 'manajer') bg-blue-100 text-blue-800
                                @elseif($user->role === 'koki') bg-orange-100 text-orange-800
                                @else bg-gray-100 text-gray-800 @endif">
                                @if($user->role === 'super_admin') <i class="fas fa-shield-alt mr-1"></i> Super Admin
                                @elseif($user->role === 'manajer') <i class="fas fa-user-tie mr-1"></i> Manajer
                                @elseif($user->role === 'koki') <i class="fas fa-utensils mr-1"></i> Koki
                                @else <i class="fas fa-user-cog mr-1"></i> Staff @endif
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                <i class="fas fa-circle text-xs mr-1.5"></i> Aktif
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('superadmin.users.edit', $user) }}"
                                    class="inline-flex items-center px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-medium rounded-lg transition-colors">
                                    <i class="fas fa-edit mr-1.5"></i> Edit
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('superadmin.users.destroy', $user) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus user \'{{ $user->username }}\'? Tindakan ini tidak bisa dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-700 text-xs font-medium rounded-lg transition-colors">
                                        <i class="fas fa-trash mr-1.5"></i> Hapus
                                    </button>
                                </form>
                                @else
                                <span class="text-xs text-gray-400 px-3 py-1.5">—</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Info Box --}}
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-start space-x-3">
        <i class="fas fa-info-circle text-amber-500 mt-0.5 flex-shrink-0"></i>
        <div class="text-sm text-amber-800">
            <p class="font-semibold mb-1">Catatan Penting</p>
            <ul class="space-y-1 list-disc list-inside text-amber-700">
                <li>Akun yang sedang aktif (Anda) tidak bisa dihapus</li>
                <li>Perubahan password langsung berlaku — beritahu user yang bersangkutan</li>
                <li>Role <strong>Super Admin</strong> memiliki akses penuh ke seluruh sistem</li>
            </ul>
        </div>
    </div>

</div>
@endsection

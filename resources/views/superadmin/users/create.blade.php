@extends('layouts.app')

@section('title', 'Tambah User')
@section('page-title', 'Tambah User Baru')
@section('page-subtitle', 'Daftarkan akun pengguna baru ke sistem')

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
<div class="max-w-lg">

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

        <form action="{{ route('superadmin.users.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Username --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    <i class="fas fa-user mr-2 text-gray-400"></i>Username
                </label>
                <input type="text" name="username" value="{{ old('username') }}"
                    class="w-full px-4 py-2.5 border rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none
                        {{ $errors->has('username') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                    placeholder="Contoh: koki_baru" required>
                @error('username')
                    <p class="mt-1 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            {{-- Role --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    <i class="fas fa-id-badge mr-2 text-gray-400"></i>Role / Jabatan
                </label>
                <select name="role"
                    class="w-full px-4 py-2.5 border rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none
                        {{ $errors->has('role') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="manajer"     {{ old('role') === 'manajer'     ? 'selected' : '' }}>Manajer</option>
                    <option value="koki"        {{ old('role') === 'koki'        ? 'selected' : '' }}>Koki</option>
                    <option value="staff"       {{ old('role') === 'staff'       ? 'selected' : '' }}>Staff</option>
                    <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                </select>
                @error('role')
                    <p class="mt-1 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    <i class="fas fa-lock mr-2 text-gray-400"></i>Password
                </label>
                <input type="password" name="password"
                    class="w-full px-4 py-2.5 border rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none
                        {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                    placeholder="Minimal 6 karakter" required>
                @error('password')
                    <p class="mt-1 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    <i class="fas fa-lock mr-2 text-gray-400"></i>Konfirmasi Password
                </label>
                <input type="password" name="password_confirmation"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none"
                    placeholder="Ulangi password" required>
            </div>

            {{-- Tombol --}}
            <div class="flex items-center space-x-3 pt-2">
                <button type="submit"
                    class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors shadow">
                    <i class="fas fa-save mr-2"></i>Simpan User
                </button>
                <a href="{{ route('superadmin.users.index') }}"
                    class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')
@section('page-subtitle', 'Ubah data akun: ' . $user->username)

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
<a href="{{ route('manajer.kategori.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
    <i class="fas fa-tags w-5"></i><span class="font-medium">Kategori</span>
</a>
<a href="{{ route('manajer.supplier.index') }}" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
    <i class="fas fa-truck w-5"></i><span class="font-medium">Supplier</span>
</a>
<div class="mt-2 pt-2 border-t border-gray-200">
    <a href="{{ route('manajer.users.index') }}" class="sidebar-link sidebar-active flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition">
        <i class="fas fa-users w-5"></i><span class="font-medium">Kelola User</span>
    </a>
</div>
@endsection

@section('content')
<div class="max-w-lg">

    <div class="mb-5 bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-center space-x-3">
        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
            <i class="fas fa-user text-blue-600"></i>
        </div>
        <div>
            <p class="text-sm font-semibold text-blue-800">Mengedit akun: <strong>{{ $user->username }}</strong></p>
            <p class="text-xs text-blue-600 capitalize">Role saat ini: {{ str_replace('_', ' ', $user->role) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('manajer.users.update', $user) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    <i class="fas fa-user mr-2 text-gray-400"></i>Username
                </label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}"
                    class="w-full px-4 py-2.5 border rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none
                        {{ $errors->has('username') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                    required>
                @error('username')
                    <p class="mt-1 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    <i class="fas fa-id-badge mr-2 text-gray-400"></i>Role / Jabatan
                </label>
                <select name="role"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none" required>
                    <option value="manajer" {{ old('role', $user->role) === 'manajer' ? 'selected' : '' }}>Manajer</option>
                    <option value="koki"    {{ old('role', $user->role) === 'koki'    ? 'selected' : '' }}>Koki</option>
                    <option value="staff"   {{ old('role', $user->role) === 'staff'   ? 'selected' : '' }}>Staff</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    <i class="fas fa-lock mr-2 text-gray-400"></i>Password Baru
                    <span class="font-normal text-gray-400 ml-1">(kosongkan jika tidak ingin ganti)</span>
                </label>
                <div class="relative">
                    <input type="password" name="password" id="pass-baru"
                        class="w-full px-4 py-2.5 pr-12 border rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none
                            {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        placeholder="Minimal 6 karakter">
                    <button type="button" onclick="togglePass('pass-baru','eye-baru')"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-emerald-600 transition-colors">
                        <i id="eye-baru" class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    <i class="fas fa-lock mr-2 text-gray-400"></i>Konfirmasi Password Baru
                </label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="pass-conf"
                        class="w-full px-4 py-2.5 pr-12 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none"
                        placeholder="Ulangi password baru">
                    <button type="button" onclick="togglePass('pass-conf','eye-conf')"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-emerald-600 transition-colors">
                        <i id="eye-conf" class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center space-x-3 pt-2">
                <button type="submit"
                    class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors shadow">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
                <a href="{{ route('manajer.users.index') }}"
                    class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function togglePass(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        const show  = input.type === 'password';
        input.type  = show ? 'text' : 'password';
        icon.classList.toggle('fa-eye',       !show);
        icon.classList.toggle('fa-eye-slash',  show);
    }
</script>
@endpush
@endsection

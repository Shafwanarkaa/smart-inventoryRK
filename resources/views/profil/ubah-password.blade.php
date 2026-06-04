@extends('layouts.app')

@section('title', 'Ubah Password')
@section('page-title', 'Ubah Password')
@section('page-subtitle', 'Ganti password akun Anda')

@section('sidebar')
    {{-- Sidebar dinamis sesuai role --}}
    @if(auth()->user()->isManajer())
        <a href="{{ route('manajer.dashboard') }}"
            class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
            <i class="fas fa-home w-5"></i><span class="font-medium">Dashboard</span>
        </a>
        <a href="{{ route('manajer.bahan-baku.index') }}"
            class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
            <i class="fas fa-box w-5"></i><span class="font-medium">Bahan Baku</span>
        </a>
    @else
        <a href="{{ route('operasional.stok') }}"
            class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition text-gray-600">
            <i class="fas fa-boxes w-5"></i><span class="font-medium">Stok Harian</span>
        </a>
    @endif
    <div class="mt-2 pt-2 border-t border-gray-200">
        <a href="{{ route('profil.ubah-password') }}"
            class="sidebar-link sidebar-active flex items-center space-x-3 px-4 py-3 rounded-lg mb-1 transition">
            <i class="fas fa-key w-5"></i><span class="font-medium">Ubah Password</span>
        </a>
    </div>
@endsection

@section('content')
<div class="max-w-md">

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

        {{-- Info user --}}
        <div class="flex items-center space-x-3 mb-6 pb-5 border-b border-gray-100">
            <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-user text-emerald-600 text-lg"></i>
            </div>
            <div>
                <p class="font-semibold text-gray-800">{{ auth()->user()->username }}</p>
                <p class="text-sm text-gray-500 capitalize">{{ str_replace('_', ' ', auth()->user()->role) }}</p>
            </div>
        </div>

        <form action="{{ route('profil.ubah-password.post') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Password Lama --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    <i class="fas fa-lock mr-2 text-gray-400"></i>Password Lama
                </label>
                <div class="relative">
                    <input type="password" name="password_lama" id="pass-lama"
                        class="w-full px-4 py-2.5 pr-12 border rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none
                            {{ $errors->has('password_lama') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        placeholder="Masukkan password saat ini" required>
                    <button type="button" onclick="togglePass('pass-lama','eye-lama')"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-emerald-600 transition-colors">
                        <i id="eye-lama" class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password_lama')
                    <p class="mt-1 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            {{-- Password Baru --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    <i class="fas fa-key mr-2 text-gray-400"></i>Password Baru
                </label>
                <div class="relative">
                    <input type="password" name="password_baru" id="pass-baru"
                        class="w-full px-4 py-2.5 pr-12 border rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none
                            {{ $errors->has('password_baru') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        placeholder="Minimal 6 karakter" required>
                    <button type="button" onclick="togglePass('pass-baru','eye-baru')"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-emerald-600 transition-colors">
                        <i id="eye-baru" class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password_baru')
                    <p class="mt-1 text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi Password Baru --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    <i class="fas fa-check-circle mr-2 text-gray-400"></i>Konfirmasi Password Baru
                </label>
                <div class="relative">
                    <input type="password" name="password_baru_confirmation" id="pass-konfirm"
                        class="w-full px-4 py-2.5 pr-12 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none"
                        placeholder="Ulangi password baru" required>
                    <button type="button" onclick="togglePass('pass-konfirm','eye-konfirm')"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-emerald-600 transition-colors">
                        <i id="eye-konfirm" class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="pt-2">
                <button type="submit"
                    class="w-full py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors shadow">
                    <i class="fas fa-save mr-2"></i>Simpan Password Baru
                </button>
            </div>
        </form>
    </div>

    {{-- Tips --}}
    <div class="mt-4 bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm text-blue-700">
        <p class="font-semibold mb-1"><i class="fas fa-info-circle mr-2"></i>Tips Password Aman:</p>
        <ul class="list-disc list-inside space-y-1 text-blue-600">
            <li>Minimal 6 karakter</li>
            <li>Kombinasi huruf dan angka lebih aman</li>
            <li>Jangan gunakan nama atau tanggal lahir</li>
        </ul>
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

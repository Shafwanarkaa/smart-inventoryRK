<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - SPK Remaja Kuring</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-emerald-50 to-teal-50 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md px-6">

        <!-- Card Login -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r from-emerald-500 to-teal-500 p-8 text-center">
                <div class="w-20 h-20 bg-white rounded-full mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-leaf text-emerald-500 text-3xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">REMAJA KURING</h1>
                <p class="text-emerald-100 text-sm">Sistem Pendukung Keputusan Pengadaan Bahan Baku</p>
            </div>

            <!-- Form -->
            <div class="p-8">

                @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg text-sm">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first() }}
                </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf

                    <!-- Username -->
                    <div class="mb-6">
                        <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user mr-2 text-gray-400"></i>Username
                        </label>
                        <input
                            type="text"
                            name="username"
                            id="username"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition"
                            placeholder="Masukkan username"
                            value="{{ old('username') }}"
                            required
                            autofocus>
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-gray-400"></i>Password
                        </label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition"
                            placeholder="Masukkan password"
                            required>
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-emerald-500 border-gray-300 rounded focus:ring-emerald-500">
                            <span class="ml-2 text-sm text-gray-600">Ingat Saya</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-semibold py-3 rounded-lg hover:from-emerald-600 hover:to-teal-600 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                    </button>

                </form>

                <!-- Info Akun Demo -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <p class="text-xs text-gray-500 text-center mb-3">Akun Demo:</p>
                    <div class="grid grid-cols-3 gap-2 text-xs">
                        <div class="bg-gray-50 p-2 rounded text-center">
                            <p class="font-semibold text-gray-700">Manajer</p>
                            <p class="text-gray-500">manajer123</p>
                        </div>
                        <div class="bg-gray-50 p-2 rounded text-center">
                            <p class="font-semibold text-gray-700">Koki</p>
                            <p class="text-gray-500">koki123</p>
                        </div>
                        <div class="bg-gray-50 p-2 rounded text-center">
                            <p class="font-semibold text-gray-700">Staff</p>
                            <p class="text-gray-500">staff123</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Footer -->
        <p class="text-center text-sm text-gray-600 mt-6">
            &copy; {{ date('Y') }} Remaja Kuring. All rights reserved.
        </p>

    </div>

</body>

</html>
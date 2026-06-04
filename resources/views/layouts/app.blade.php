<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SPK Remaja Kuring') }} - @yield('title')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Styles -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .sidebar-active {
            background-color: #10b981;
            color: white;
        }

        .sidebar-link:hover {
            background-color: #f0fdf4;
            color: #10b981;
        }

        /* Sidebar transition */
        #sidebar {
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>

<body class="bg-gray-50">

    <div class="flex h-screen overflow-hidden">

        <!-- Mobile Overlay -->
        <div id="sidebar-overlay"
            class="fixed inset-0 z-40 bg-black bg-opacity-50 hidden md:hidden"
            onclick="closeSidebar()">
        </div>

        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 flex flex-col
                   -translate-x-full md:translate-x-0 md:relative md:z-auto">

            <!-- Logo -->
            <div class="p-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex-1 flex items-center justify-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Remaja Kuring" class="h-20 w-auto object-contain">
                    </div>
                    <!-- Close button - mobile only -->
                    <button onclick="closeSidebar()" class="md:hidden text-gray-400 hover:text-gray-600 p-1">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 overflow-y-auto">
                @yield('sidebar')
            </nav>

            <!-- User Info -->
            <div class="p-4 border-t border-gray-200">
                <!-- Link Ubah Password -->
                <a href="{{ route('profil.ubah-password') }}"
                    class="flex items-center space-x-2 text-xs text-gray-500 hover:text-emerald-600 transition-colors mb-3 px-1">
                    <i class="fas fa-key"></i>
                    <span>Ubah Password</span>
                </a>
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user text-emerald-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->username }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ str_replace('_', ' ', Auth::user()->role) }}</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-500 flex-shrink-0" title="Logout">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden min-w-0">

            <!-- Header -->
            <header class="bg-white border-b border-gray-200 px-4 md:px-8 py-4 flex-shrink-0">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3 min-w-0">
                        <!-- Hamburger Button - mobile only -->
                        <button onclick="openSidebar()"
                            class="md:hidden text-gray-600 hover:text-emerald-600 p-1 rounded-lg hover:bg-gray-100 flex-shrink-0"
                            aria-label="Buka menu">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <div class="min-w-0">
                            <h2 class="text-lg md:text-2xl font-bold text-gray-800 truncate">@yield('page-title')</h2>
                            <p class="text-xs md:text-sm text-gray-500 truncate">@yield('page-subtitle')</p>
                        </div>
                    </div>
                    <!-- Date - hidden on small screens -->
                    <div class="hidden sm:flex items-center space-x-4 flex-shrink-0">
                        <div class="text-sm text-gray-600">
                            <i class="far fa-calendar-alt mr-2"></i>
                            {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto p-4 md:p-8">

                <!-- Flash Messages -->
                @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg flex items-center">
                    <i class="fas fa-check-circle mr-3 flex-shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 flex-shrink-0"></i>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-triangle mr-3 flex-shrink-0"></i>
                        <span class="font-semibold">Terdapat kesalahan:</span>
                    </div>
                    <ul class="list-disc list-inside ml-6">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Main Content -->
                @yield('content')

            </main>

        </div>

    </div>

    <!-- Responsive Sidebar Script -->
    <script>
        function openSidebar() {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Close sidebar on resize to desktop
        window.addEventListener('resize', function () {
            if (window.innerWidth >= 768) {
                document.getElementById('sidebar-overlay').classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
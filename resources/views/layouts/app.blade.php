<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Sistem Presensi & Penggajian</title>
    
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-blue-600 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a class="text-white text-lg font-semibold" href="#">
                <i class="fas fa-building"></i> Sistem Presensi & Penggajian
            </a>
            <div class="block lg:hidden">
                <button id="navbar-toggle" class="text-white focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <div class="hidden lg:flex lg:items-center">
                @auth
                <ul class="flex space-x-4">
                    @if(Auth::user()->isAdmin())
                        <li><a class="text-white hover:underline" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a class="text-white hover:underline" href="{{ route('admin.karyawan.index') }}">Data Karyawan</a></li>
                        <li><a class="text-white hover:underline" href="{{ route('admin.absensi.rekap') }}">Rekap Absensi</a></li>
                        <li><a class="text-white hover:underline" href="{{ route('admin.gaji.index') }}">Data Gaji</a></li>
                    @elseif(Auth::user()->isKaryawan())
                        <li><a class="text-white hover:underline" href="{{ route('karyawan.dashboard') }}">Dashboard</a></li>
                        <li><a class="text-white hover:underline" href="{{ route('karyawan.absensi.riwayat') }}">Riwayat Absensi</a></li>
                    @endif
                </ul>
                <div class="relative">
                    <button class="flex items-center text-white focus:outline-none">
                        <i class="fas fa-user"></i> {{ Auth::user()->name }}
                    </button>
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-10 hidden" id="dropdown">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="block px-4 py-2 text-gray-700 hover:bg-gray-200 w-full text-left">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="py-4">
        <div class="container mx-auto">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>

    @stack('scripts')
    <script>
        document.getElementById('navbar-toggle').addEventListener('click', function() {
            var dropdown = document.getElementById('dropdown');
            dropdown.classList.toggle('hidden');
        });
        
        document.querySelectorAll('.flex').forEach(item => {
            item.addEventListener('click', event => {
                var dropdown = document.getElementById('dropdown');
                dropdown.classList.add('hidden');
            });
        });
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Sistem Presensi & Penggajian</title>
    
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a class="text-white text-lg font-bold flex items-center" href="#">
                <i class="fas fa-building mr-2"></i> Sistem Presensi & Penggajian
            </a>
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="text-white focus:outline-none">
                    <i class="fas fa-user"></i> {{ Auth::user()->name }}
                </button>
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 bg-white text-black rounded shadow-lg z-20 hidden" style="display: none;">
                    <form action="{{ route('logout') }}" method="POST" class="p-2">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-200">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    
    <main class="py-4">
        <div class="container mx-auto">
            @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded-md mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-500 text-white p-4 rounded-md mb-4">
                    {{ session('error') }}
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/cdn.min.js" defer></script>
    @stack('scripts')
</body>
</html>
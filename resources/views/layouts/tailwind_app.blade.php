<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Preloved.id') — Jual Beli Pakaian Preloved Terpercaya</title>
    
    <!-- Google Fonts: Poppins & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons for Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <!-- Tailwind CSS & JS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        html {
            scroll-behavior: smooth;
            scroll-padding-top: 6.5rem;
        }
        body {
            font-family: 'Poppins', 'Inter', sans-serif;
        }
        /* Custom scrollbar for horizontal chip categories */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-white text-body-text antialiased min-h-screen flex flex-col">

    <!-- Flash Messages -->
    @if(session('success') || session('error'))
    <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-4">
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl shadow-xs flex items-center justify-between">
                <div class="flex items-center">
                    <i class="bi bi-check-circle text-green-500 text-xl mr-3"></i>
                    <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700 focus:outline-none">
                    <i class="bi bi-x text-lg"></i>
                </button>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-xs flex items-center justify-between">
                <div class="flex items-center">
                    <i class="bi bi-x-circle text-red-500 text-xl mr-3"></i>
                    <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 focus:outline-none">
                    <i class="bi bi-x text-lg"></i>
                </button>
            </div>
        @endif
    </div>
    @endif

    <!-- Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>

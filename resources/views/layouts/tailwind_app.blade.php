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

    <!-- Flash Messages (Floating Toast) -->
    @if(session('success') || session('error'))
    <div class="fixed top-5 right-5 z-[9999] max-w-sm w-full pointer-events-none animate-slide-in px-4">
        @if(session('success'))
            <div class="pointer-events-auto bg-white border-l-4 border-green-500 p-4 rounded-xl shadow-xl flex items-center justify-between gap-3 border border-gray-100">
                <div class="flex items-center">
                    <i class="bi bi-check-circle-fill text-green-500 text-lg mr-2.5"></i>
                    <p class="text-xs text-gray-800 font-semibold leading-normal">{{ session('success') }}</p>
                </div>
                <button onclick="this.closest('.fixed').remove()" class="text-gray-400 hover:text-gray-600 focus:outline-none shrink-0 cursor-pointer">
                    <i class="bi bi-x text-lg"></i>
                </button>
            </div>
        @endif
        @if(session('error'))
            <div class="pointer-events-auto bg-white border-l-4 border-red-500 p-4 rounded-xl shadow-xl flex items-center justify-between gap-3 border border-gray-100">
                <div class="flex items-center">
                    <i class="bi bi-exclamation-circle-fill text-red-500 text-lg mr-2.5"></i>
                    <p class="text-xs text-gray-800 font-semibold leading-normal">{{ session('error') }}</p>
                </div>
                <button onclick="this.closest('.fixed').remove()" class="text-gray-400 hover:text-gray-600 focus:outline-none shrink-0 cursor-pointer">
                    <i class="bi bi-x text-lg"></i>
                </button>
            </div>
        @endif
    </div>
    <script>
        setTimeout(() => {
            const toast = document.querySelector('.fixed.animate-slide-in');
            if (toast) {
                toast.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-10px)';
                setTimeout(() => toast.remove(), 500);
            }
        }, 4000);
    </script>
    @endif

    <!-- Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>

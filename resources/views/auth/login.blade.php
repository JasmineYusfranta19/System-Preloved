<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — Preloved.id</title>
    <meta name="description" content="Masuk ke akun Preloved.id untuk mulai belanja fashion preloved impianmu.">
    
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <!-- Tailwind CSS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-white flex">

    <!-- Left Panel: Fashion Photography -->
    <div class="hidden lg:flex lg:w-[55%] relative overflow-hidden">
        <!-- Background Photo -->
        <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=1200&auto=format&fit=crop"
             alt="Fashion preloved editorial"
             class="absolute inset-0 w-full h-full object-cover">
        
        <!-- Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary-dark/80 via-primary/50 to-accent/30"></div>
        
        <!-- Left Panel Content -->
        <div class="relative z-10 flex flex-col justify-between p-12 w-full">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 text-white font-extrabold text-xl tracking-tight w-max">
                <span class="bg-white/15 p-2 rounded-xl backdrop-blur-sm">
                    <i class="bi bi-bag-heart leading-none"></i>
                </span>
                <span>Preloved<span class="text-accent">.id</span></span>
            </a>

            <!-- Bottom Content -->
            <div class="text-white space-y-6">
                <h2 class="text-4xl font-extrabold leading-tight max-w-md">
                    Temukan Fashion Impianmu, Harga <span class="text-accent">Lebih Hemat</span>
                </h2>
                <p class="text-white/75 text-sm leading-relaxed max-w-sm">
                    Bergabung bersama jutaan pengguna yang telah menemukan cara belanja fashion yang lebih cerdas, hemat, dan ramah lingkungan.
                </p>
                
                <!-- Trust Items -->
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-sm">
                        <div class="w-8 h-8 rounded-lg bg-white/15 backdrop-blur-sm flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-shield-check text-white text-sm"></i>
                        </div>
                        <span class="text-white/90 font-medium">Transaksi aman & terpercaya</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm">
                        <div class="w-8 h-8 rounded-lg bg-white/15 backdrop-blur-sm flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-truck text-white text-sm"></i>
                        </div>
                        <span class="text-white/90 font-medium">Pengiriman ke seluruh Indonesia</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm">
                        <div class="w-8 h-8 rounded-lg bg-white/15 backdrop-blur-sm flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-star text-white text-sm"></i>
                        </div>
                        <span class="text-white/90 font-medium">Ribuan produk preloved bermutu</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Panel: Login Form -->
    <div class="flex-1 flex flex-col justify-center items-center px-6 sm:px-10 py-12 min-h-screen bg-white">
        
        <!-- Mobile Logo (visible only on small screens) -->
        <div class="lg:hidden mb-8 text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-primary-dark font-extrabold text-xl">
                <span class="bg-primary/10 p-2 rounded-xl">
                    <i class="bi bi-bag-heart text-primary leading-none"></i>
                </span>
                Preloved<span class="text-primary">.id</span>
            </a>
        </div>
        
        <div class="w-full max-w-md">
            <!-- Form Header -->
            <div class="mb-8">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                    Selamat Datang Kembali
                </h1>
                <p class="text-sm text-gray-500 mt-2 font-medium">
                    Masuk untuk melanjutkan ke akun Preloved.id Anda
                </p>
            </div>

            <!-- Error Alert -->
            @if($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 text-red-700 text-sm font-medium px-4 py-3 rounded-xl flex items-start gap-2.5">
                    <i class="bi bi-exclamation-circle-fill text-red-500 mt-0.5 flex-shrink-0"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                
                <!-- Email Field -->
                <div class="space-y-1.5">
                    <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="bi bi-envelope text-gray-400 text-sm"></i>
                        </div>
                        <input type="email" 
                               id="email"
                               name="email" 
                               value="{{ old('email') }}"
                               placeholder="email@kamu.com"
                               required
                               class="w-full pl-11 pr-4 py-3.5 text-sm text-gray-800 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 focus:bg-white transition-all duration-200 placeholder-gray-400 @error('email') border-red-300 bg-red-50 @enderror">
                    </div>
                </div>

                <!-- Password Field -->
                <div class="space-y-1.5">
                    <label for="password" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="bi bi-lock text-gray-400 text-sm"></i>
                        </div>
                        <input type="password" 
                               id="password"
                               name="password"
                               placeholder="Masukkan password"
                               required
                               class="w-full pl-11 pr-12 py-3.5 text-sm text-gray-800 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 focus:bg-white transition-all duration-200 placeholder-gray-400">
                        <button type="button" 
                                onclick="togglePwd()"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
                            <i id="eyeIcon" class="bi bi-eye text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" id="remember"
                               class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary/20 focus:ring-2 accent-primary">
                        <span class="text-sm text-gray-600 font-medium">Ingat saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-primary text-white font-bold py-4 px-6 rounded-2xl hover:bg-primary-dark active:scale-[0.98] transition-all duration-200 text-sm tracking-wide shadow-lg shadow-primary/20 flex items-center justify-center gap-2 mt-2">
                    Masuk ke Akun
                    <i class="bi bi-arrow-right text-base group-hover:translate-x-1"></i>
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-100"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="bg-white px-4 text-xs text-gray-400 font-medium uppercase tracking-wider">atau</span>
                </div>
            </div>

            <!-- Register Link -->
            <p class="text-center text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-primary hover:text-primary-dark font-bold transition-colors ml-1">
                    Daftar sekarang
                </a>
            </p>

            <!-- Back to Home -->
            <div class="text-center mt-6">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-xs text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="bi bi-arrow-left text-xs"></i>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <script>
    function togglePwd() {
        const p = document.getElementById('password');
        const i = document.getElementById('eyeIcon');
        p.type = p.type === 'password' ? 'text' : 'password';
        i.className = p.type === 'password' ? 'bi bi-eye text-sm' : 'bi bi-eye-slash text-sm';
    }
    </script>
</body>
</html>
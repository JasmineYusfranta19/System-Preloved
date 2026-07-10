<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — Preloved.id</title>
    <meta name="description" content="Buat akun Preloved.id dan mulai perjalanan fashion preloved Anda.">
    
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
    <div class="hidden lg:flex lg:w-[45%] relative overflow-hidden">
        <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=1200&auto=format&fit=crop"
             alt="Fashion lifestyle preloved"
             class="absolute inset-0 w-full h-full object-cover">
        
        <!-- Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary-dark/85 via-primary/55 to-accent/25"></div>
        
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
            <div class="text-white space-y-5">
                <h2 class="text-3xl font-extrabold leading-tight max-w-xs">
                    Gabung & Mulai <span class="text-accent">Berbelanja</span> Lebih Cerdas
                </h2>
                <p class="text-white/70 text-sm leading-relaxed max-w-sm">
                    Daftar gratis dan akses ribuan pilihan fashion preloved berkualitas dari seller terpercaya se-Indonesia.
                </p>
                
                <!-- Stats -->
                <div class="grid grid-cols-2 gap-4 pt-2">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4">
                        <span class="block text-2xl font-extrabold text-white">10K+</span>
                        <span class="text-[11px] text-white/70 font-medium">Produk Terjual</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4">
                        <span class="block text-2xl font-extrabold text-white">5K+</span>
                        <span class="text-[11px] text-white/70 font-medium">Seller Aktif</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Panel: Registration Form -->
    <div class="flex-1 flex flex-col justify-center items-center px-6 sm:px-10 py-10 overflow-y-auto bg-white">
        
        <!-- Mobile Logo -->
        <div class="lg:hidden mb-6 text-center w-full">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-primary-dark font-extrabold text-xl">
                <span class="bg-primary/10 p-2 rounded-xl">
                    <i class="bi bi-bag-heart text-primary leading-none"></i>
                </span>
                Preloved<span class="text-primary">.id</span>
            </a>
        </div>
        
        <div class="w-full max-w-md">
            <!-- Form Header -->
            <div class="mb-7">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                    Buat Akun Baru
                </h1>
                <p class="text-sm text-gray-500 mt-2 font-medium">
                    Bergabung dengan ribuan pengguna Preloved.id — gratis!
                </p>
            </div>

            <!-- Error Alert -->
            @if($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 text-red-700 text-sm font-medium px-4 py-3 rounded-xl flex items-start gap-2.5">
                    <i class="bi bi-exclamation-circle-fill text-red-500 mt-0.5 flex-shrink-0"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Role Selection -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Saya ingin
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <!-- Buyer Option -->
                        <label id="label-buyer" 
                               class="role-option flex flex-col items-center gap-2 p-4 rounded-2xl border-2 cursor-pointer transition-all duration-200 {{ old('role', 'buyer') === 'buyer' ? 'border-primary bg-primary/5' : 'border-gray-100 bg-gray-50 hover:border-primary/30 hover:bg-primary/3' }}">
                            <input type="radio" name="role" value="buyer" class="sr-only" {{ old('role', 'buyer') === 'buyer' ? 'checked' : '' }}>
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ old('role', 'buyer') === 'buyer' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-500' }} transition-all">
                                <i class="bi bi-bag text-lg"></i>
                            </div>
                            <div class="text-center">
                                <span class="block text-sm font-bold text-gray-800">Belanja</span>
                                <span class="block text-[10px] text-gray-500 mt-0.5">Cari & beli produk</span>
                            </div>
                        </label>
                        
                        <!-- Seller Option -->
                        <label id="label-seller" 
                               class="role-option flex flex-col items-center gap-2 p-4 rounded-2xl border-2 cursor-pointer transition-all duration-200 {{ old('role') === 'seller' ? 'border-primary bg-primary/5' : 'border-gray-100 bg-gray-50 hover:border-primary/30 hover:bg-primary/3' }}">
                            <input type="radio" name="role" value="seller" class="sr-only" {{ old('role') === 'seller' ? 'checked' : '' }}>
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ old('role') === 'seller' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-500' }} transition-all">
                                <i class="bi bi-shop text-lg"></i>
                            </div>
                            <div class="text-center">
                                <span class="block text-sm font-bold text-gray-800">Berjualan</span>
                                <span class="block text-[10px] text-gray-500 mt-0.5">Jual pakaian preloved</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Name -->
                <div class="space-y-1.5">
                    <label for="name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="bi bi-person text-gray-400 text-sm"></i>
                        </div>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Nama lengkap Anda" required
                               class="w-full pl-11 pr-4 py-3 text-sm text-gray-800 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 focus:bg-white transition-all placeholder-gray-400 @error('name') border-red-300 @enderror">
                    </div>
                </div>

                <!-- Email -->
                <div class="space-y-1.5">
                    <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="bi bi-envelope text-gray-400 text-sm"></i>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="email@kamu.com" required
                               class="w-full pl-11 pr-4 py-3 text-sm text-gray-800 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 focus:bg-white transition-all placeholder-gray-400 @error('email') border-red-300 @enderror">
                    </div>
                </div>

                <!-- Phone -->
                <div class="space-y-1.5">
                    <label for="phone" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">No. WhatsApp</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="bi bi-telephone text-gray-400 text-sm"></i>
                        </div>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" required
                               class="w-full pl-11 pr-4 py-3 text-sm text-gray-800 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 focus:bg-white transition-all placeholder-gray-400">
                    </div>
                </div>

                <!-- Password Row -->
                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1.5">
                        <label for="password" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Password</label>
                        <input type="password" id="password" name="password" placeholder="Min. 8 karakter" required
                               class="w-full px-4 py-3 text-sm text-gray-800 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 focus:bg-white transition-all placeholder-gray-400">
                    </div>
                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Konfirmasi</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required
                               class="w-full px-4 py-3 text-sm text-gray-800 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 focus:bg-white transition-all placeholder-gray-400">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-primary text-white font-bold py-4 px-6 rounded-2xl hover:bg-primary-dark active:scale-[0.98] transition-all duration-200 text-sm tracking-wide shadow-lg shadow-primary/20 flex items-center justify-center gap-2 mt-1">
                    Buat Akun Sekarang
                    <i class="bi bi-arrow-right text-base"></i>
                </button>
            </form>

            <!-- Login Link -->
            <p class="text-center text-sm text-gray-600 mt-5">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-primary hover:text-primary-dark font-bold transition-colors ml-1">
                    Masuk di sini
                </a>
            </p>

            <!-- Back to Home -->
            <div class="text-center mt-5">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-xs text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="bi bi-arrow-left text-xs"></i>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <script>
    const radioInputs = document.querySelectorAll('input[name="role"]');
    radioInputs.forEach(radio => {
        radio.addEventListener('change', () => {
            document.querySelectorAll('.role-option').forEach(opt => {
                const icon = opt.querySelector('.w-10');
                opt.classList.remove('border-primary', 'bg-primary/5');
                opt.classList.add('border-gray-100', 'bg-gray-50');
                if (icon) { icon.classList.remove('bg-primary', 'text-white'); icon.classList.add('bg-gray-200', 'text-gray-500'); }
            });
            const selected = radio.closest('.role-option');
            const selectedIcon = selected.querySelector('.w-10');
            selected.classList.remove('border-gray-100', 'bg-gray-50');
            selected.classList.add('border-primary', 'bg-primary/5');
            if (selectedIcon) { selectedIcon.classList.remove('bg-gray-200', 'text-gray-500'); selectedIcon.classList.add('bg-primary', 'text-white'); }
        });
    });
    </script>
</body>
</html>
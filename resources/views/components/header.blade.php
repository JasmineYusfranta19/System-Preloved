<nav class="bg-primary-dark sticky top-0 z-50 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20 gap-4">
            
            <!-- Logo Section -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ url('/') }}" class="flex items-center gap-2 text-white font-extrabold text-2xl tracking-tight group">
                    <span class="bg-white/10 p-2 rounded-xl group-hover:scale-110 transition-transform duration-200">👜</span>
                    <span>Preloved<span class="text-accent">.id</span></span>
                </a>
            </div>

            <!-- Navigation Links (Desktop) — exactly 3 menus -->
            <div class="hidden lg:flex items-center space-x-2">
                <a href="{{ url('/') }}" class="text-white font-semibold text-sm hover:bg-white/10 transition-all duration-200 px-3.5 py-2.5 rounded-xl">Home</a>
                <a href="{{ url('/#categories-section') }}" class="text-white/80 font-medium text-sm hover:bg-white/10 hover:text-white transition-all duration-200 px-3.5 py-2.5 rounded-xl">Kategori</a>
                <a href="{{ url('/#how-it-works') }}" class="text-white/80 font-medium text-sm hover:bg-white/10 hover:text-white transition-all duration-200 px-3.5 py-2.5 rounded-xl">Cara Kerja</a>
            </div>

            <!-- Search Bar -->
            <div class="flex-1 max-w-md mx-6 hidden md:block">
                <form action="{{ url('/products') }}" method="GET" class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari produk, brand, kategori..." 
                           class="w-full bg-white/10 text-white placeholder-white/50 text-sm rounded-2xl pl-11 pr-4 py-2.5 border border-white/20 focus:outline-none focus:bg-white focus:text-body-text focus:placeholder-gray-400 focus:border-white transition-all duration-300">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="bi bi-search text-white/50 group-focus-within:text-gray-400"></i>
                    </div>
                </form>
            </div>

            <!-- Action Section (Right) -->
            <div class="flex items-center gap-3">
                @auth
                    <!-- Wishlist -->
                    <a href="{{ route('wishlist.index') }}" 
                       class="text-white/90 hover:text-accent hover:bg-white/10 transition-all duration-200 p-2.5 rounded-xl flex items-center justify-center relative"
                       title="Wishlist Saya">
                        <i class="bi bi-heart text-xl"></i>
                    </a>

                    <!-- Cart -->
                    <a href="{{ url('/cart') }}" 
                       class="text-white/90 hover:text-accent hover:bg-white/10 transition-all duration-200 p-2.5 rounded-xl flex items-center justify-center relative"
                       title="Keranjang Belanja">
                        <i class="bi bi-bag text-xl"></i>
                        @if(auth()->user()->carts()->count() > 0)
                            <span class="absolute top-1.5 right-1.5 bg-accent text-white text-[9px] font-bold rounded-full w-4 h-4 flex items-center justify-center animate-pulse">
                                {{ auth()->user()->carts()->count() }}
                            </span>
                        @endif
                    </a>

                    <!-- User Dropdown Menu -->
                    <div class="relative inline-block text-left" id="user-menu-wrapper">
                        <button type="button" onclick="toggleUserDropdown()" class="flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white text-sm font-semibold py-2.5 px-4 rounded-xl border border-white/10 transition duration-200 focus:outline-none">
                            <i class="bi bi-person-circle text-base"></i>
                            <span>{{ auth()->user()->name }}</span>
                            <i class="bi bi-chevron-down text-[10px]"></i>
                        </button>
                        
                        <!-- Dropdown panel -->
                        <div id="user-dropdown-menu" class="hidden absolute right-0 mt-2 w-48 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none overflow-hidden transition-all duration-200 transform scale-95 opacity-0 origin-top-right">
                            <div class="py-1" role="menu">
                                @if(auth()->user()->isSeller())
                                    <a href="{{ route('seller.dashboard') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 transition-colors" role="menuitem">
                                        <i class="bi bi-speedometer2 text-gray-500 mr-2.5"></i> Dashboard Seller
                                    </a>
                                    <hr class="border-gray-100">
                                @endif
                                <form action="{{ route('logout') }}" method="POST" class="block w-full">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors" role="menuitem">
                                        <i class="bi bi-box-arrow-left mr-2.5"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Not Authenticated -->
                    <a href="{{ route('login') }}" class="text-white border border-white/30 hover:border-white hover:bg-white/10 transition duration-200 rounded-xl px-4 py-2.5 text-sm font-semibold">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="bg-white text-primary-dark hover:bg-bg-soft hover:scale-[1.03] active:scale-[0.98] transition-all duration-200 rounded-xl px-4 py-2.5 text-sm font-bold shadow-sm">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
    function toggleUserDropdown() {
        const menu = document.getElementById('user-dropdown-menu');
        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
            setTimeout(() => {
                menu.classList.remove('scale-95', 'opacity-0');
                menu.classList.add('scale-100', 'opacity-100');
            }, 10);
        } else {
            menu.classList.remove('scale-100', 'opacity-100');
            menu.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                menu.classList.add('hidden');
            }, 200);
        }
    }
    
    // Close the dropdown when clicking outside
    window.addEventListener('click', function(e) {
        const wrapper = document.getElementById('user-menu-wrapper');
        const menu = document.getElementById('user-dropdown-menu');
        if (wrapper && !wrapper.contains(e.target) && menu && !menu.classList.contains('hidden')) {
            menu.classList.remove('scale-100', 'opacity-100');
            menu.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                menu.classList.add('hidden');
            }, 200);
        }
    });
</script>

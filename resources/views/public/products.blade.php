<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Produk — Preloved.id</title>
    <meta name="description" content="Temukan ribuan pakaian preloved berkualitas di Preloved.id">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Tailwind CSS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Poppins', 'Inter', sans-serif; }
        /* Custom thin scrollbar for sidebar */
        .thin-scroll::-webkit-scrollbar { width: 4px; }
        .thin-scroll::-webkit-scrollbar-track { background: transparent; }
        .thin-scroll::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 4px; }
        .thin-scroll::-webkit-scrollbar-thumb:hover { background: #d1d5db; }
        /* Toast slide-in */
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(100%); }
            to   { opacity: 1; transform: translateX(0); }
        }
        .toast-enter { animation: slideInRight 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    </style>
</head>
<body class="bg-gray-50 text-body-text antialiased overflow-hidden">

{{-- ═══════════════════════════════════════════════════════
     TOAST NOTIFICATIONS (floating, top-right)
═══════════════════════════════════════════════════════ --}}
@if(session('success') || session('error') || session('info'))
<div id="toast-container" class="fixed top-5 right-5 z-[9999] flex flex-col gap-2 w-80">
    @if(session('success'))
    <div class="toast-enter bg-white border border-gray-100 border-l-4 border-l-green-500 rounded-xl shadow-xl p-4 flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center shrink-0">
            <i class="bi bi-check-circle-fill text-green-500 text-sm"></i>
        </div>
        <p class="text-xs text-gray-700 font-semibold flex-1 leading-relaxed">{{ session('success') }}</p>
        <button onclick="this.closest('.toast-enter, [class*=toast]').remove()" class="text-gray-300 hover:text-gray-500 transition-colors cursor-pointer shrink-0">
            <i class="bi bi-x text-base"></i>
        </button>
    </div>
    @endif
    @if(session('error'))
    <div class="toast-enter bg-white border border-gray-100 border-l-4 border-l-red-500 rounded-xl shadow-xl p-4 flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center shrink-0">
            <i class="bi bi-exclamation-circle-fill text-red-500 text-sm"></i>
        </div>
        <p class="text-xs text-gray-700 font-semibold flex-1 leading-relaxed">{{ session('error') }}</p>
        <button onclick="this.closest('[class*=toast]').remove()" class="text-gray-300 hover:text-gray-500 transition-colors cursor-pointer shrink-0">
            <i class="bi bi-x text-base"></i>
        </button>
    </div>
    @endif
    @if(session('info'))
    <div class="toast-enter bg-white border border-gray-100 border-l-4 border-l-blue-400 rounded-xl shadow-xl p-4 flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
            <i class="bi bi-info-circle-fill text-blue-400 text-sm"></i>
        </div>
        <p class="text-xs text-gray-700 font-semibold flex-1 leading-relaxed">{{ session('info') }}</p>
        <button onclick="this.closest('[class*=toast]').remove()" class="text-gray-300 hover:text-gray-500 transition-colors cursor-pointer shrink-0">
            <i class="bi bi-x text-base"></i>
        </button>
    </div>
    @endif
</div>
<script>
    setTimeout(() => {
        const container = document.getElementById('toast-container');
        if (container) {
            container.style.transition = 'opacity 0.5s, transform 0.5s';
            container.style.opacity = '0';
            container.style.transform = 'translateX(20px)';
            setTimeout(() => container.remove(), 500);
        }
    }, 4500);
</script>
@endif

{{-- ═══════════════════════════════════════════════════════
     APP SHELL — Sidebar + Main
═══════════════════════════════════════════════════════ --}}
<div class="flex h-screen overflow-hidden">

    {{-- ════════════════════════════
         LEFT SIDEBAR
    ════════════════════════════ --}}
    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col h-full shrink-0 shadow-xs">

        {{-- Logo --}}
        <div class="px-5 py-4 border-b border-gray-100 shrink-0">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                <span class="w-9 h-9 bg-primary/10 rounded-xl flex items-center justify-center text-lg group-hover:scale-105 transition-transform duration-200">👜</span>
                <span class="font-extrabold text-lg text-primary-dark tracking-tight">
                    Preloved<span class="text-primary">.id</span>
                </span>
            </a>
        </div>

        {{-- Navigation --}}
        <nav class="px-3 py-3 border-b border-gray-100 shrink-0 space-y-0.5">
            <a href="{{ url('/') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-800 text-sm font-medium transition-all duration-150">
                <i class="bi bi-house-door text-base w-4"></i>
                <span>Beranda</span>
            </a>
            <a href="{{ url('/products') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-primary/8 text-primary font-semibold text-sm transition-all duration-150">
                <i class="bi bi-grid-3x3-gap text-base w-4"></i>
                <span>Semua Produk</span>
            </a>
        </nav>

        {{-- Filter Form --}}
        <div class="flex-1 overflow-y-auto thin-scroll px-4 py-4">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Filter Produk</p>

            <form action="{{ url('/products') }}" method="GET" id="filter-form" class="space-y-4">

                {{-- Search --}}
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Cari</label>
                    <div class="relative">
                        <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-xs pointer-events-none"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Nama, brand..."
                               class="w-full pl-8 pr-3 py-2 bg-gray-50 border border-gray-100 text-xs rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 focus:bg-white transition-all placeholder-gray-300">
                    </div>
                </div>

                {{-- Category --}}
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Kategori</label>
                    <select name="category"
                            class="w-full bg-gray-50 border border-gray-100 text-xs rounded-xl px-3 py-2 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 focus:bg-white transition-all text-gray-600">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <optgroup label="{{ $cat->name }}">
                                @foreach($cat->children as $child)
                                    <option value="{{ $child->slug }}" {{ request('category')===$child->slug ? 'selected' : '' }}>
                                        {{ $child->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                {{-- Condition --}}
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Kondisi</label>
                    <div class="space-y-1.5">
                        @foreach(['new'=>'Baru','like_new'=>'Seperti Baru','good'=>'Bagus','fair'=>'Cukup'] as $val=>$label)
                        <label class="flex items-center gap-2.5 cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" name="condition[]" value="{{ $val }}"
                                       class="peer sr-only"
                                       {{ in_array($val, request('condition',[])) ? 'checked' : '' }}>
                                <div class="w-4 h-4 rounded border border-gray-200 bg-gray-50 peer-checked:bg-primary peer-checked:border-primary transition-all flex items-center justify-center">
                                    <i class="bi bi-check text-white text-[10px] leading-none hidden peer-checked:block"></i>
                                </div>
                            </div>
                            <span class="text-xs text-gray-600 font-medium group-hover:text-gray-900 transition-colors">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Size --}}
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Ukuran</label>
                    <div class="grid grid-cols-3 gap-1.5">
                        @foreach(['XS','S','M','L','XL','XXL'] as $s)
                        @php $isSizeChecked = in_array($s, request('size',[])); @endphp
                        <label class="cursor-pointer">
                            <input type="checkbox" name="size[]" value="{{ $s }}" class="sr-only peer"
                                   {{ $isSizeChecked ? 'checked' : '' }}>
                            <div class="border border-gray-100 bg-gray-50 text-center py-1.5 rounded-lg text-[10px] font-bold text-gray-500
                                        hover:border-primary/40 hover:text-primary
                                        peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary
                                        transition-all">
                                {{ $s }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Gender --}}
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Gender</label>
                    <select name="gender"
                            class="w-full bg-gray-50 border border-gray-100 text-xs rounded-xl px-3 py-2 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 focus:bg-white transition-all text-gray-600">
                        <option value="">Semua</option>
                        <option value="women" {{ request('gender')==='women' ? 'selected' : '' }}>Wanita</option>
                        <option value="men"   {{ request('gender')==='men'   ? 'selected' : '' }}>Pria</option>
                        <option value="unisex"{{ request('gender')==='unisex'? 'selected' : '' }}>Unisex</option>
                        <option value="kids"  {{ request('gender')==='kids'  ? 'selected' : '' }}>Anak-anak</option>
                    </select>
                </div>

                {{-- Price --}}
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Harga (Rp)</label>
                    <div class="flex gap-2">
                        <input type="number" name="min_price" value="{{ request('min_price') }}"
                               placeholder="Min"
                               class="w-full bg-gray-50 border border-gray-100 text-xs rounded-xl px-3 py-2 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 focus:bg-white transition-all placeholder-gray-300">
                        <input type="number" name="max_price" value="{{ request('max_price') }}"
                               placeholder="Max"
                               class="w-full bg-gray-50 border border-gray-100 text-xs rounded-xl px-3 py-2 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 focus:bg-white transition-all placeholder-gray-300">
                    </div>
                </div>

                {{-- Action buttons --}}
                <div class="space-y-2 pt-1">
                    <button type="submit"
                            class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-2.5 rounded-xl text-xs transition-colors shadow-sm shadow-primary/20 cursor-pointer">
                        Terapkan Filter
                    </button>
                    <a href="{{ url('/products') }}"
                       class="w-full border border-primary/30 text-primary-dark hover:bg-primary/5 font-semibold py-2.5 rounded-xl text-xs text-center block transition-colors">
                        Reset
                    </a>
                </div>

            </form>
        </div>

    </aside>

    {{-- ════════════════════════════
         MAIN CONTENT (right)
    ════════════════════════════ --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        {{-- TOP BAR --}}
        <header class="bg-white border-b border-gray-100 px-6 h-16 flex items-center justify-between gap-4 shrink-0">

            {{-- Search bar --}}
            <form action="{{ url('/products') }}" method="GET" class="flex-1 max-w-lg" id="search-form-top">
                {{-- Pass existing filter params --}}
                @foreach(request()->except(['search','page']) as $k => $v)
                    @if(is_array($v))
                        @foreach($v as $val)
                            <input type="hidden" name="{{ $k }}[]" value="{{ $val }}">
                        @endforeach
                    @else
                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                    @endif
                @endforeach
                <div class="relative">
                    <i class="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari produk, brand, kategori..."
                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-100 rounded-2xl text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 focus:bg-white transition-all placeholder-gray-300 text-gray-700">
                </div>
            </form>

            {{-- Right actions --}}
            <div class="flex items-center gap-1">

                @auth
                {{-- Wishlist --}}
                <a href="{{ route('wishlist.index') }}"
                   class="w-10 h-10 rounded-xl flex items-center justify-center text-gray-500 hover:text-accent hover:bg-gray-50 transition-all relative"
                   title="Wishlist Saya">
                    <i class="bi bi-heart text-[18px]"></i>
                </a>

                {{-- Cart --}}
                <a href="{{ url('/cart') }}"
                   class="w-10 h-10 rounded-xl flex items-center justify-center text-gray-500 hover:text-primary hover:bg-gray-50 transition-all relative"
                   title="Keranjang Belanja">
                    <i class="bi bi-bag text-[18px]"></i>
                    @if(auth()->user()->carts()->count() > 0)
                        <span class="absolute top-1.5 right-1.5 bg-accent text-white text-[9px] font-bold rounded-full w-[15px] h-[15px] flex items-center justify-center leading-none">
                            {{ auth()->user()->carts()->count() }}
                        </span>
                    @endif
                </a>

                {{-- Divider --}}
                <div class="w-px h-5 bg-gray-100 mx-2"></div>

                {{-- User dropdown --}}
                <div class="relative" id="user-menu">
                    <button onclick="toggleUserMenu()"
                            class="flex items-center gap-2 pl-2 pr-3 py-1.5 rounded-xl hover:bg-gray-50 transition-all text-gray-700 text-sm font-semibold focus:outline-none cursor-pointer">
                        <div class="w-7 h-7 rounded-lg bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="hidden sm:block max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                        <i class="bi bi-chevron-down text-xs text-gray-400"></i>
                    </button>

                    {{-- Dropdown --}}
                    <div id="user-dropdown"
                         class="hidden absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50 origin-top-right">
                        <div class="px-4 py-3 border-b border-gray-50">
                            <p class="text-xs font-bold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-gray-400 truncate mt-0.5">{{ auth()->user()->email }}</p>
                        </div>
                        @if(auth()->user()->isSeller())
                        <a href="{{ route('seller.dashboard') }}"
                           class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-gray-600 hover:bg-gray-50 transition-colors font-medium">
                            <i class="bi bi-speedometer2 text-gray-400"></i> Dashboard Seller
                        </a>
                        @endif
                        <a href="{{ url('/orders') }}"
                           class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-gray-600 hover:bg-gray-50 transition-colors font-medium">
                            <i class="bi bi-box text-gray-400"></i> Pesanan Saya
                        </a>
                        <div class="border-t border-gray-50"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center gap-2.5 px-4 py-2.5 text-xs text-red-500 hover:bg-red-50 transition-colors font-medium cursor-pointer">
                                <i class="bi bi-box-arrow-left"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>

                @else
                {{-- Guest --}}
                <a href="{{ route('login') }}"
                   class="text-sm font-semibold text-gray-600 hover:text-primary transition-colors px-3 py-2">
                    Masuk
                </a>
                <a href="{{ route('register') }}"
                   class="text-sm font-bold text-white bg-primary hover:bg-primary-dark transition-colors px-4 py-2 rounded-xl">
                    Daftar
                </a>
                @endauth
            </div>
        </header>

        {{-- ── Content: Section Header + Grid ──────────────────── --}}
        <main class="flex-1 overflow-y-auto thin-scroll p-6">

            {{-- Empty State --}}
            @if($products->isEmpty())
            <div class="flex flex-col items-center justify-center text-center py-24 bg-white rounded-3xl border border-dashed border-gray-200">
                <div class="w-16 h-16 rounded-2xl bg-bg-soft/60 flex items-center justify-center mb-4">
                    <i class="bi bi-bag-x text-primary/50 text-3xl"></i>
                </div>
                <h3 class="text-base font-bold text-gray-700">Produk tidak ditemukan</h3>
                <p class="text-xs text-gray-400 mt-1.5 max-w-xs">Coba ubah kata kunci atau filter yang berbeda.</p>
                <a href="{{ url('/products') }}"
                   class="mt-5 inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white font-bold text-xs px-5 py-2.5 rounded-xl transition-colors">
                    Lihat Semua Produk
                </a>
            </div>

            @else

            {{-- Pre-load wishlist IDs to avoid N+1 --}}
            @php
                $wishlistIds = auth()->check()
                    ? auth()->user()->wishlists()->pluck('product_id')->toArray()
                    : [];
            @endphp

            {{-- Product Grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4">
                @foreach($products as $product)
                <div class="group bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-xs hover:shadow-lg hover:border-primary/10 hover:-translate-y-1 transition-all duration-300 flex flex-col relative">

                    {{-- Wishlist toggle --}}
                    <form action="{{ route('wishlist.toggle') }}" method="POST" class="absolute top-2.5 right-2.5 z-20">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit"
                                class="w-7 h-7 rounded-full bg-white/90 backdrop-blur-sm shadow flex items-center justify-center
                                       {{ in_array($product->id, $wishlistIds) ? 'text-accent' : 'text-gray-300 hover:text-accent' }}
                                       active:scale-90 transition-all duration-200 cursor-pointer">
                            <i class="bi {{ in_array($product->id, $wishlistIds) ? 'bi-heart-fill' : 'bi-heart' }} text-xs"></i>
                        </button>
                    </form>

                    <a href="{{ url('/products/'.$product->slug) }}" class="flex flex-col h-full">

                        {{-- Image --}}
                        <div class="aspect-[4/5] w-full overflow-hidden bg-bg-soft relative">
                            @if($product->primaryImage)
                                <img src="{{ $product->primaryImage->image_url }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out"
                                     loading="lazy">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-primary/20 gap-1">
                                    <i class="bi bi-image text-3xl"></i>
                                    <span class="text-[10px] text-gray-300">No Image</span>
                                </div>
                            @endif

                            {{-- Size badge --}}
                            @if($product->size)
                                <span class="absolute top-2 left-2 bg-primary-dark/75 backdrop-blur-sm text-white text-[9px] font-bold px-2 py-0.5 rounded-md">
                                    {{ $product->size }}
                                </span>
                            @endif
                        </div>

                        {{-- Details --}}
                        <div class="p-3 flex-grow flex flex-col justify-between">
                            <div class="space-y-0.5">
                                {{-- Condition badge --}}
                                <span class="inline-block bg-bg-soft text-primary-dark text-[9px] font-extrabold px-2 py-0.5 rounded-full uppercase tracking-wider">
                                    {{ ['new'=>'Baru','like_new'=>'Like New','good'=>'Good','fair'=>'Fair'][$product->condition] ?? 'Good' }}
                                </span>

                                {{-- Brand --}}
                                <p class="text-[10px] text-gray-400 font-bold tracking-widest uppercase truncate mt-1">
                                    {{ $product->brand ?? 'No Brand' }}
                                </p>

                                {{-- Name --}}
                                <h3 class="text-xs sm:text-sm font-bold text-gray-800 group-hover:text-primary transition-colors line-clamp-2 leading-tight">
                                    {{ $product->name }}
                                </h3>
                            </div>

                            <div class="pt-2.5 mt-2.5 border-t border-gray-50">
                                <span class="text-primary font-extrabold text-sm">
                                    {{ $product->formatted_price }}
                                </span>
                                <div class="flex items-center gap-1 mt-1 text-[10px] text-gray-400">
                                    <i class="bi bi-shop text-primary/50"></i>
                                    <span class="truncate">{{ $product->shop->name ?? '—' }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-8 flex justify-center">
                {{ $products->withQueryString()->links('pagination::tailwind') }}
            </div>

            @endif
        </main>

    </div>{{-- end main content --}}

</div>{{-- end app shell --}}

<script>
function toggleUserMenu() {
    const dd = document.getElementById('user-dropdown');
    dd.classList.toggle('hidden');
}
// Close when clicking outside
document.addEventListener('click', (e) => {
    const menu = document.getElementById('user-menu');
    const dd = document.getElementById('user-dropdown');
    if (menu && dd && !menu.contains(e.target)) {
        dd.classList.add('hidden');
    }
});
</script>

</body>
</html>
@props(['categories'])

<section class="py-12 bg-white" id="categories-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header & Title -->
        <div class="mb-8 text-center md:text-left">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-primary-dark tracking-tight">
                Kategori Populer
            </h2>
            <p class="text-sm text-gray-500 mt-1.5 font-medium">
                Temukan item fashion preloved impianmu berdasarkan kategori favorit
            </p>
        </div>

        <!-- Horizontal Scrollable Chips Container -->
        <div class="relative">
            <div class="absolute left-0 top-0 bottom-0 w-8 bg-gradient-to-r from-white to-transparent pointer-events-none z-10"></div>
            <div class="absolute right-0 top-0 bottom-0 w-8 bg-gradient-to-l from-white to-transparent pointer-events-none z-10"></div>
            
            <div class="flex gap-3 overflow-x-auto no-scrollbar py-3 px-4 -mx-4">
                <!-- "Semua" Chip -->
                <a href="{{ url('/products') }}" 
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-bold tracking-wide border transition-all duration-200 whitespace-nowrap
                   {{ !request('category') ? 'bg-primary border-primary text-white shadow-lg shadow-primary/15 scale-105' : 'bg-white border-primary/20 text-primary-dark hover:bg-primary/5 hover:border-primary/40' }}">
                    <i class="bi bi-grid-fill text-xs"></i>
                    <span>Semua Produk</span>
                </a>

                @foreach($categories as $cat)
                    @php $isActive = request('category') === $cat->slug; @endphp
                    <a href="{{ url('/products?category='.$cat->slug) }}" 
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-bold tracking-wide border transition-all duration-200 whitespace-nowrap
                       {{ $isActive ? 'bg-primary border-primary text-white shadow-lg shadow-primary/15 scale-105' : 'bg-white border-primary/20 text-primary-dark hover:bg-primary/5 hover:border-primary/40' }}">
                        <span>{{ $cat->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>

    </div>
</section>

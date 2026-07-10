@props(['products'])

<section class="py-16 bg-white" id="latest-products-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex items-end justify-between mb-10">
            <div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-primary-dark tracking-tight">
                    Produk Terbaru
                </h2>
                <p class="text-sm text-gray-500 mt-1.5 font-medium">
                    Fashion preloved pilihan baru masuk hari ini
                </p>
            </div>
            <a href="{{ url('/products') }}" 
               class="inline-flex items-center gap-1.5 text-primary hover:text-primary-dark font-bold text-sm tracking-wide group transition-colors">
                <span>Lihat Semua</span>
                <i class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @forelse($products as $product)
                <div class="group bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl hover:border-primary/10 hover:-translate-y-1.5 transition-all duration-300 flex flex-col h-full relative">
                    
                    <!-- Wishlist Button Overlay -->
                    <button class="absolute top-3 right-3 z-20 w-8 h-8 rounded-full bg-white/95 backdrop-blur-sm flex items-center justify-center text-gray-400 hover:text-accent active:scale-90 shadow-md border border-gray-100 transition-all duration-200"
                            aria-label="Tambah ke wishlist">
                        <i class="bi bi-heart text-sm"></i>
                    </button>
                    
                    <a href="{{ url('/products/'.$product->slug) }}" class="flex flex-col h-full">
                        
                        <!-- Image Container (4:5 Aspect Ratio) -->
                        <div class="aspect-[4/5] w-full overflow-hidden bg-bg-soft relative">
                            @if($product->primaryImage)
                                <img src="{{ $product->primaryImage->image_url }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-primary/30 bg-bg-soft gap-2">
                                    <i class="bi bi-image text-4xl"></i>
                                    <span class="text-xs text-gray-400">No Image</span>
                                </div>
                            @endif

                            <!-- Size Badge -->
                            @if($product->size)
                                <span class="absolute top-3 left-3 bg-primary-dark/80 backdrop-blur-sm text-white text-[10px] font-bold px-2.5 py-1 rounded-lg">
                                    Size {{ $product->size }}
                                </span>
                            @endif
                        </div>

                        <!-- Card Body Details -->
                        <div class="p-4 sm:p-5 flex-grow flex flex-col justify-between">
                            
                            <div class="space-y-1">
                                <!-- Condition Badge & Rating -->
                                <div class="flex items-center justify-between gap-2 flex-wrap">
                                    <span class="inline-block bg-accent/15 text-accent text-[10px] font-extrabold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                                        {{ ['new' => 'Baru', 'like_new' => 'Like New', 'good' => 'Good', 'fair' => 'Fair'][$product->condition] ?? 'Good' }}
                                    </span>
                                    
                                    @if($product->average_rating > 0)
                                        <div class="flex items-center gap-1 text-amber-500 text-xs font-semibold">
                                            <i class="bi bi-star-fill text-[10px]"></i>
                                            <span>{{ $product->average_rating }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Brand -->
                                <p class="text-[10px] text-gray-400 font-bold tracking-widest uppercase">
                                    {{ $product->brand ?? 'No Brand' }}
                                </p>

                                <!-- Product Name -->
                                <h3 class="text-sm sm:text-base font-bold text-gray-800 group-hover:text-primary transition-colors line-clamp-1 pt-0.5">
                                    {{ $product->name }}
                                </h3>
                            </div>

                            <div class="pt-3 mt-3 border-t border-gray-50 space-y-1">
                                <!-- Price Info -->
                                <div class="flex items-baseline gap-2 flex-wrap">
                                    <span class="text-primary font-extrabold text-base sm:text-lg">
                                        {{ $product->formatted_price }}
                                    </span>
                                    <span class="text-xs text-gray-400 line-through">
                                        Rp {{ number_format($product->price * 1.4, 0, ',', '.') }}
                                    </span>
                                </div>

                                <!-- Shop Info -->
                                <div class="flex items-center gap-1.5 text-xs text-gray-500 pt-1">
                                    <i class="bi bi-shop text-primary/70"></i>
                                    <span class="font-medium truncate">{{ $product->shop->name ?? 'Preloved Seller' }}</span>
                                </div>
                            </div>

                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-16 bg-bg-soft/30 rounded-3xl border border-dashed border-primary/20">
                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-box text-primary text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-primary-dark">Belum Ada Produk</h3>
                    <p class="text-sm text-gray-500 mt-1">Produk preloved terbaru sedang dipersiapkan.</p>
                </div>
            @endforelse
        </div>

    </div>
</section>

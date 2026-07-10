@extends('layouts.tailwind_app')
@section('title', 'Wishlist Saya — Preloved.id')

@section('content')

    <!-- Header / Navbar Component -->
    <x-header />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Title and description -->
        <div class="mb-10 text-center md:text-left">
            <h1 class="text-3xl font-extrabold text-primary-dark tracking-tight">Wishlist Saya</h1>
            <p class="text-sm text-gray-500 mt-1.5 font-medium">Koleksi item fashion preloved yang Anda simpan</p>
        </div>

        @if($wishlists->isEmpty())
            <!-- Empty State -->
            <div class="text-center py-20 bg-bg-soft/30 rounded-3xl border border-dashed border-primary/20 max-w-xl mx-auto px-6">
                <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-5">
                    <i class="bi bi-heart text-primary text-2xl animate-pulse"></i>
                </div>
                <h3 class="text-lg font-bold text-primary-dark">Wishlist Kosong</h3>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                    Belum ada produk yang disimpan. Telusuri katalog kami dan temukan item fashion favorit Anda!
                </p>
                <a href="{{ url('/products') }}" 
                   class="inline-flex items-center justify-center bg-primary text-white hover:bg-primary-dark font-bold text-sm px-6 py-3.5 rounded-2xl transition-all duration-300 mt-6 shadow-md shadow-primary/15">
                    Cari Produk
                </a>
            </div>
        @else
            <!-- Wishlist Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($wishlists as $item)
                    @php $product = $item->product; @endphp
                    @if($product)
                        <div class="group bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl hover:border-primary/10 hover:-translate-y-1.5 transition-all duration-300 flex flex-col h-full relative">
                            
                            <!-- Remove button (heart overlay) -->
                            <form action="{{ url('/wishlist/toggle') }}" method="POST" class="absolute top-3 right-3 z-20">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" 
                                        class="w-8 h-8 rounded-full bg-white/95 backdrop-blur-sm flex items-center justify-center text-accent hover:scale-105 active:scale-95 shadow-md border border-gray-100 transition-all duration-200"
                                        title="Hapus dari wishlist">
                                    <i class="bi bi-heart-fill text-sm"></i>
                                </button>
                            </form>
                            
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
                                            <span class="text-xs text-gray-400 font-medium">No Image</span>
                                        </div>
                                    @endif

                                    <!-- Size Badge -->
                                    @if($product->size)
                                        <span class="absolute top-3 left-3 bg-primary-dark/80 backdrop-blur-sm text-white text-[10px] font-bold px-2.5 py-1 rounded-lg">
                                            Size {{ $product->size }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Details -->
                                <div class="p-4 sm:p-5 flex-grow flex flex-col justify-between">
                                    <div class="space-y-1">
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

                                        <p class="text-[10px] text-gray-400 font-bold tracking-widest uppercase">
                                            {{ $product->brand ?? 'No Brand' }}
                                        </p>

                                        <h3 class="text-sm sm:text-base font-bold text-gray-800 group-hover:text-primary transition-colors line-clamp-1 pt-0.5">
                                            {{ $product->name }}
                                        </h3>
                                    </div>

                                    <div class="pt-3 mt-3 border-t border-gray-50 space-y-1.5">
                                        <div class="flex items-baseline gap-2 flex-wrap">
                                            <span class="text-primary font-extrabold text-base">
                                                {{ $product->formatted_price }}
                                            </span>
                                            <span class="text-xs text-gray-400 line-through">
                                                Rp {{ number_format($product->price * 1.4, 0, ',', '.') }}
                                            </span>
                                        </div>

                                        <!-- Seller shop info -->
                                        <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                            <i class="bi bi-shop text-primary/70"></i>
                                            <span class="font-medium truncate">{{ $product->shop->name ?? 'Preloved Seller' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>

    <!-- Footer Component -->
    <x-footer />

@endsection

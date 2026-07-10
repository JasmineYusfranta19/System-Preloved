<section class="py-12 bg-white" id="promo-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Grid layout (3 Banners) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Banner 1: Koleksi Wanita -->
            <div class="relative rounded-3xl overflow-hidden shadow-lg h-96 group">
                <!-- Background Image -->
                <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=600&auto=format&fit=crop" 
                     alt="Koleksi Wanita Preloved" 
                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                
                <!-- Black Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                
                <!-- Content -->
                <div class="absolute inset-0 p-6 flex flex-col justify-end text-white z-10 space-y-2">
                    <span class="text-xs font-extrabold bg-accent text-white px-3 py-1 rounded-full uppercase tracking-wider w-max">
                        Koleksi Wanita
                    </span>
                    <h3 class="text-xl sm:text-2xl font-extrabold tracking-tight">
                        Tampil Elegan, Lebih Hemat
                    </h3>
                    <p class="text-xs text-white/80 line-clamp-2 max-w-xs font-medium">
                        Temukan dress, blouse, dan outer preloved berkualitas dari brand favorit dengan harga terbaik.
                    </p>
                    <a href="{{ url('/products?gender=women') }}" 
                       class="inline-flex items-center gap-1 bg-white text-gray-900 hover:bg-accent hover:text-white font-bold text-xs rounded-xl px-4 py-2.5 w-max mt-2 transition-all duration-300 shadow-sm">
                        <span>Shop Now</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Banner 2: Gaya Pria -->
            <div class="relative rounded-3xl overflow-hidden shadow-lg h-96 group">
                <!-- Background Image -->
                <img src="https://images.unsplash.com/photo-1490367532201-b9bc1dc483f6?q=80&w=600&auto=format&fit=crop" 
                     alt="Gaya Pria Preloved" 
                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                
                <!-- Black Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                
                <!-- Content -->
                <div class="absolute inset-0 p-6 flex flex-col justify-end text-white z-10 space-y-2">
                    <span class="text-xs font-extrabold bg-primary text-white px-3 py-1 rounded-full uppercase tracking-wider w-max">
                        Gaya Pria
                    </span>
                    <h3 class="text-xl sm:text-2xl font-extrabold tracking-tight">
                        Kasual & Streetwear
                    </h3>
                    <p class="text-xs text-white/80 line-clamp-2 max-w-xs font-medium">
                        Kemeja flannel, jaket denim, dan celana chino branded untuk menunjang style harianmu.
                    </p>
                    <a href="{{ url('/products?gender=men') }}" 
                       class="inline-flex items-center gap-1 bg-white text-gray-900 hover:bg-primary hover:text-white font-bold text-xs rounded-xl px-4 py-2.5 w-max mt-2 transition-all duration-300 shadow-sm">
                        <span>Shop Now</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Banner 3: Aksesoris & Sepatu (Primary Dark themed background with text in white) -->
            <div class="relative rounded-3xl overflow-hidden shadow-lg h-96 group bg-primary-dark">
                <!-- Background Image with primary-dark tint -->
                <img src="https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=600&auto=format&fit=crop" 
                     alt="Aksesoris & Sepatu Preloved" 
                     class="absolute inset-0 w-full h-full object-cover mix-blend-multiply opacity-40 group-hover:scale-105 transition-transform duration-500 ease-out">
                
                <!-- Colored Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-primary-dark via-primary-dark/60 to-transparent"></div>
                
                <!-- Content -->
                <div class="absolute inset-0 p-6 flex flex-col justify-end text-white z-10 space-y-2">
                    <span class="text-xs font-extrabold bg-white text-primary-dark px-3 py-1 rounded-full uppercase tracking-wider w-max shadow-sm">
                        Aksesoris & Sneakers
                    </span>
                    <h3 class="text-xl sm:text-2xl font-extrabold tracking-tight">
                        Lengkapi Outfit-mu
                    </h3>
                    <p class="text-xs text-white/80 line-clamp-2 max-w-xs font-medium">
                        Tas kulit, topi vintage, kacamata, dan sneakers original untuk menyempurnakan penampilanmu.
                    </p>
                    <a href="{{ url('/products') }}" 
                       class="inline-flex items-center gap-1 bg-white text-primary-dark hover:bg-bg-soft hover:scale-105 font-bold text-xs rounded-xl px-4 py-2.5 w-max mt-2 transition-all duration-300 shadow-sm">
                        <span>Shop Now</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

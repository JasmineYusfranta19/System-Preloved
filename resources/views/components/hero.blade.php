<section class="bg-bg-soft relative overflow-hidden py-16 md:py-24">
    <!-- Decorative subtle geometric background shapes -->
    <div class="absolute -top-12 -left-12 w-64 h-64 bg-accent/10 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-16 -right-16 w-80 h-80 bg-primary/10 rounded-full blur-3xl"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            
            <!-- Left Content Column -->
            <div class="space-y-6 text-center md:text-left">
                <!-- Badge -->
                <div class="inline-flex items-center gap-1.5 bg-primary/15 text-primary-dark font-bold text-xs px-4 py-2 rounded-full tracking-wide shadow-xs uppercase">
                    <span>🌱</span> Sustainable Fashion
                </div>
                
                <!-- Headline -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-primary-dark leading-tight tracking-tight">
                    Temukan Fashion <br class="hidden sm:inline">
                    <span class="text-primary">Preloved</span> Impianmu
                </h1>
                
                <!-- Subheadline -->
                <p class="text-gray-700 text-base sm:text-lg max-w-xl mx-auto md:mx-0 leading-relaxed font-medium">
                    Ribuan pakaian terkurasi dengan harga terjangkau. Tetap tampil stylish, hemat uang, dan kurangi jejak karbon demi bumi yang lebih hijau.
                </p>
                
                <!-- CTA Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start pt-2">
                    <a href="{{ url('/products') }}" 
                       class="inline-flex items-center justify-center bg-primary text-white hover:bg-primary-dark hover:scale-[1.03] active:scale-[0.98] transition-all duration-300 rounded-2xl px-8 py-4 font-bold text-base shadow-lg shadow-primary/20 group">
                        <span>🛍️ Mulai Belanja</span>
                        <i class="bi bi-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a href="{{ route('register') }}" 
                       class="inline-flex items-center justify-center border-2 border-primary text-primary hover:bg-primary/5 hover:scale-[1.03] active:scale-[0.98] transition-all duration-300 rounded-2xl px-8 py-4 font-bold text-base">
                        Daftar Di Sini!
                    </a>
                </div>
                
                <!-- Trust Stats Brief -->
                <div class="flex items-center justify-center md:justify-start gap-8 pt-6 border-t border-primary/10">
                    <div>
                        <span class="block text-2xl font-extrabold text-primary-dark">10K+</span>
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk Terjual</span>
                    </div>
                    <div class="w-px h-8 bg-primary/20"></div>
                    <div>
                        <span class="block text-2xl font-extrabold text-primary-dark">5K+</span>
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Seller Terpercaya</span>
                    </div>
                    <div class="w-px h-8 bg-primary/20"></div>
                    <div>
                        <span class="block text-2xl font-extrabold text-primary-dark">99%</span>
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Ulasan Positif</span>
                    </div>
                </div>
            </div>

            <!-- Right Visual Column (Real Fashion Editorial Photo) -->
            <div class="relative flex justify-center">
                <!-- Outer Frame Accent -->
                <div class="absolute inset-0 bg-gradient-to-tr from-primary/10 to-accent/20 rounded-3xl transform rotate-3 scale-95 -z-10"></div>
                <div class="absolute inset-0 border border-primary/20 rounded-3xl transform -rotate-3 scale-[0.98] -z-10"></div>
                
                <!-- Main Image Wrapper -->
                <div class="relative w-full max-w-md h-[400px] sm:h-[500px] rounded-3xl overflow-hidden shadow-2xl border-4 border-white bg-white">
                    <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=800&auto=format&fit=crop" 
                         alt="Preloved fashion model lifestyle portrait" 
                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-700 ease-out">
                    
                    <!-- Floating Overlays -->
                    <div class="absolute bottom-4 left-4 bg-white/95 backdrop-blur-xs p-3.5 rounded-2xl shadow-lg border border-primary/15 max-w-[200px] flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-accent/20 flex items-center justify-center text-accent text-lg">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-primary-dark">100% Curated</span>
                            <span class="block text-[10px] text-gray-500">Kualitas Terjamin</span>
                        </div>
                    </div>

                    <div class="absolute top-4 right-4 bg-primary text-white font-bold text-xs px-3.5 py-1.5 rounded-full shadow-md flex items-center gap-1.5">
                        <i class="bi bi-tag-fill"></i>
                        <span>Diskon s/d 70%</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<footer class="bg-primary-dark text-white/75 pt-16 pb-8 mt-16 border-t border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Grid Links -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 mb-12">
            
            <!-- Column 1: Brand Info -->
            <div class="lg:col-span-2 space-y-4">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5 text-white font-extrabold text-xl tracking-tight">
                    <span class="bg-white/10 p-2 rounded-xl">
                        <i class="bi bi-bag-heart leading-none"></i>
                    </span>
                    <span>Preloved<span class="text-accent">.id</span></span>
                </a>
                <p class="text-xs text-white/60 leading-relaxed max-w-sm font-medium">
                    Platform e-commerce fashion preloved terpercaya di Indonesia. Kami mempertemukan para pecinta sustainable fashion untuk berbagi gaya hidup hemat, stylish, dan ramah lingkungan.
                </p>
                <!-- Newsletter Signup -->
                <div class="space-y-2 pt-2">
                    <span class="block text-xs font-bold text-white uppercase tracking-wider">Newsletter</span>
                    <form action="#" method="POST" class="flex max-w-sm gap-2">
                        <input type="email" placeholder="Alamat email Anda..." 
                               class="bg-white/10 text-white placeholder-white/40 text-xs rounded-xl px-4 py-2.5 w-full border border-white/10 focus:outline-none focus:bg-white focus:text-gray-800 focus:placeholder-gray-400 focus:border-white transition-all duration-300">
                        <button type="submit" 
                                class="bg-accent hover:bg-accent/80 active:scale-95 text-white font-bold text-xs rounded-xl px-4 py-2.5 transition-all whitespace-nowrap">
                            Gabung
                        </button>
                    </form>
                </div>
            </div>

            <!-- Column 2: Tentang Kami -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold text-white uppercase tracking-widest">Tentang Kami</h4>
                <ul class="space-y-2 text-xs font-medium">
                    <li><a href="{{ url('/#how-it-works') }}" class="hover:text-white transition-colors">Cara Kerja</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Visi & Keberlanjutan</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Karir</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Pers & Media</a></li>
                </ul>
            </div>

            <!-- Column 3: Bantuan -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold text-white uppercase tracking-widest">Bantuan</h4>
                <ul class="space-y-2 text-xs font-medium">
                    <li><a href="#" class="hover:text-white transition-colors">Pusat Bantuan</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Panduan Ukuran</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Kebijakan Pengembalian</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Keamanan Transaksi</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Hubungi Kami</a></li>
                </ul>
            </div>

            <!-- Column 4: Sosial & Pembayaran -->
            <div class="space-y-4">
                <div>
                    <h4 class="text-xs font-bold text-white uppercase tracking-widest mb-3">Sosial Media</h4>
                    <div class="flex items-center gap-2.5">
                        <a href="#" class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center text-white hover:bg-accent hover:scale-105 transition-all duration-200 text-sm" aria-label="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center text-white hover:bg-accent hover:scale-105 transition-all duration-200 text-sm" aria-label="TikTok">
                            <i class="bi bi-tiktok"></i>
                        </a>
                        <a href="#" class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center text-white hover:bg-accent hover:scale-105 transition-all duration-200 text-sm" aria-label="Twitter/X">
                            <i class="bi bi-twitter-x"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="text-[10px] font-bold text-white uppercase tracking-widest mb-2.5">Metode Pembayaran</h4>
                    <div class="flex flex-wrap gap-2 text-white/50 text-base">
                        <i class="bi bi-credit-card" title="Transfer Bank"></i>
                        <i class="bi bi-wallet2" title="E-Wallet"></i>
                        <i class="bi bi-qr-code-scan" title="QRIS"></i>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer Bottom (Copyright) -->
        <div class="pt-8 border-t border-white/5 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-white/35 font-medium">
            <p>© {{ date('Y') }} Preloved.id. Seluruh hak cipta dilindungi.</p>
            <div class="flex gap-4">
                <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
            </div>
        </div>

    </div>
</footer>

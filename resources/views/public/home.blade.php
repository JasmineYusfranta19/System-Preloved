@extends('layouts.app')
@section('title', 'Preloved.id')

@section('content')

{{-- Hero --}}
<div style="background: linear-gradient(135deg, var(--dark-blue) 0%, #4a6bb5 100%); padding: 4rem 0 3rem;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-white">
                <div style="background:var(--light-green);color:var(--dark-blue);display:inline-block;padding:.3rem .9rem;border-radius:2rem;font-size:.78rem;font-weight:700;margin-bottom:1rem">
                    🌱 Sustainable Fashion
                </div>
                <h1 style="font-weight:800;font-size:2.5rem;line-height:1.2">
                    Temukan Fashion<br>Preloved Impianmu
                </h1>
                <p style="color:rgba(255,255,255,.75);margin-top:1rem;font-size:1rem">
                    Ribuan pakaian berkualitas dengan harga terjangkau. Hemat uang, jaga bumi.
                </p>
                <div class="d-flex gap-3 mt-4 flex-wrap">
                    <a href="{{ url('/products') }}" class="btn btn-navbar-register px-4 py-2" style="font-size:.95rem">
                        🛍️ Mulai Belanja
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-navbar-login px-4 py-2" style="font-size:.95rem">
                        Jadi Seller
                    </a>
                </div>
                <div class="d-flex gap-4 mt-4" style="font-size:.82rem;color:rgba(255,255,255,.65)">
                    <span>✅ {{ $stats['total_products'] }}+ Produk</span>
                    <span>🏪 {{ $stats['total_shops'] }}+ Toko</span>
                    <span>👥 {{ $stats['total_users'] }}+ Pengguna</span>
                </div>
            </div>
            <div class="col-md-6 d-none d-md-flex justify-content-center mt-4 mt-md-0">
                <div style="font-size:10rem;filter:drop-shadow(0 8px 24px rgba(0,0,0,.2))">👗</div>
            </div>
        </div>
    </div>
</div>

{{-- Kategori --}}
<div class="container mt-5">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <div class="section-title">Kategori</div>
            <div class="section-subtitle">Temukan produk berdasarkan kategori</div>
        </div>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ url('/products') }}" class="cat-pill {{ !request('category') ? 'active' : '' }}">
            🏷️ Semua
        </a>
        @foreach($categories as $cat)
        <a href="{{ url('/products?category='.$cat->slug) }}" class="cat-pill {{ request('category') === $cat->slug ? 'active' : '' }}">
            {{ $cat->icon }} {{ $cat->name }}
        </a>
        @endforeach
    </div>
</div>

{{-- Produk Terbaru --}}
<div class="container mt-5">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <div class="section-title">✨ Produk Terbaru</div>
            <div class="section-subtitle">Baru ditambahkan oleh seller</div>
        </div>
        <a href="{{ url('/products') }}" class="btn btn-outline-main btn-sm px-3">Lihat Semua</a>
    </div>

    <div class="row g-3">
        @forelse($latestProducts as $product)
        <div class="col-6 col-md-4 col-lg-3">
            <a href="{{ url('/products/'.$product->slug) }}" style="text-decoration:none">
                <div class="product-card">
                    @if($product->primaryImage)
                        <img src="{{ $product->primaryImage->image_url }}" alt="{{ $product->name }}">
                    @else
                        <div style="height:220px;background:#f0f4ff;display:flex;align-items:center;justify-content:center;font-size:4rem">👗</div>
                    @endif
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <span class="product-badge {{ $product->status === 'sold' ? 'sold' : '' }}">
                                {{ ['new'=>'Baru','like_new'=>'Seperti Baru','good'=>'Bagus','fair'=>'Cukup'][$product->condition] ?? '-' }}
                            </span>
                            @if($product->size)
                                <span style="font-size:.72rem;color:#6b7280">{{ $product->size }}</span>
                            @endif
                        </div>
                        <div class="fw-600 mt-1" style="font-size:.88rem;color:#1e2a4a;line-height:1.3">
                            {{ Str::limit($product->name, 32) }}
                        </div>
                        @if($product->brand)
                            <div style="font-size:.75rem;color:#9ca3af">{{ $product->brand }}</div>
                        @endif
                        <div class="product-price mt-2">{{ $product->formatted_price }}</div>
                        <div style="font-size:.72rem;color:#9ca3af;margin-top:.25rem">
                            <i class="bi bi-shop me-1"></i>{{ $product->shop->name ?? '-' }}
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted">
            <div style="font-size:3rem">📦</div>
            <p>Belum ada produk tersedia.</p>
        </div>
        @endforelse
    </div>
</div>

{{-- Banner CTA --}}
<div class="container mt-5">
    <div style="background:linear-gradient(135deg,var(--dark-blue),#4a6bb5);border-radius:1.25rem;padding:2.5rem;color:white;text-align:center">
        <div style="font-size:2.5rem">🏪</div>
        <h4 style="font-weight:800;margin-top:.75rem">Punya Pakaian yang Ingin Dijual?</h4>
        <p style="color:rgba(255,255,255,.75);font-size:.9rem">Daftar sebagai seller dan mulai jual pakaian preloved kamu sekarang. Gratis!</p>
        <a href="{{ route('register') }}" class="btn btn-navbar-register px-5 py-2 mt-2" style="font-size:.95rem">
            Mulai Jual Sekarang →
        </a>
    </div>
</div>

@endsection
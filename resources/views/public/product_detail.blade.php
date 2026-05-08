@extends('layouts.app')
@section('title', $product->name)

@section('content')
<div class="container mt-4">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="font-size:.82rem">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" style="color:var(--dark-blue)">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/products') }}" style="color:var(--dark-blue)">Produk</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($product->name, 40) }}</li>
        </ol>
    </nav>

    <div class="row g-4">

        {{-- Foto Produk --}}
        <div class="col-md-5">
            <div style="border-radius:1rem;overflow:hidden;border:1px solid #dde8f8">
                @if($product->primaryImage)
                    <img src="{{ $product->primaryImage->image_url }}" id="mainImg"
                        style="width:100%;height:420px;object-fit:cover" alt="{{ $product->name }}">
                @else
                    <div style="height:420px;background:#f0f4ff;display:flex;align-items:center;justify-content:center;font-size:6rem">👗</div>
                @endif
            </div>
            {{-- Thumbnail --}}
            @if($product->images->count() > 1)
            <div class="d-flex gap-2 mt-2 flex-wrap">
                @foreach($product->images as $img)
                <img src="{{ $img->image_url }}" onclick="document.getElementById('mainImg').src='{{ $img->image_url }}'"
                    style="width:64px;height:64px;object-fit:cover;border-radius:.5rem;cursor:pointer;border:2px solid {{ $img->is_primary?'var(--dark-blue)':'#dde8f8' }}">
                @endforeach
            </div>
            @endif
        </div>

        {{-- Info Produk --}}
        <div class="col-md-7">
            <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                <span class="product-badge">{{ ['new'=>'Baru','like_new'=>'Seperti Baru','good'=>'Bagus','fair'=>'Cukup'][$product->condition] ?? '-' }}</span>
                @if($product->size) <span class="product-badge">{{ $product->size }}</span> @endif
                @if($product->gender) <span class="product-badge">{{ ucfirst($product->gender) }}</span> @endif
            </div>

            <h4 style="font-weight:800;color:var(--dark-blue)">{{ $product->name }}</h4>

            @if($product->brand)
                <div style="font-size:.88rem;color:#6b7280" class="mb-2">Brand: <strong>{{ $product->brand }}</strong></div>
            @endif

            <div style="font-size:1.6rem;font-weight:800;color:var(--dark-blue);margin:1rem 0">
                {{ $product->formatted_price }}
            </div>

            {{-- Rating --}}
            @if($product->reviews->count() > 0)
            <div class="d-flex align-items-center gap-2 mb-3">
                <div style="color:#f59e0b;font-size:.9rem">
                    @for($i=1;$i<=5;$i++)
                        <i class="bi bi-star{{ $i <= round($product->average_rating) ? '-fill' : '' }}"></i>
                    @endfor
                </div>
                <span style="font-size:.85rem;color:#6b7280">{{ $product->average_rating }} ({{ $product->reviews->count() }} ulasan)</span>
            </div>
            @endif

            <p style="font-size:.9rem;color:#4b5563;line-height:1.7">{{ $product->description }}</p>

            <div class="row g-2 mb-4" style="font-size:.85rem">
                <div class="col-6">
                    <div style="background:#f0f4ff;border-radius:.6rem;padding:.6rem .85rem">
                        <div style="color:#6b7280;font-size:.75rem">Stok</div>
                        <div style="font-weight:700;color:{{ $product->stock > 0 ? 'var(--dark-blue)' : '#ef4444' }}">
                            {{ $product->stock > 0 ? $product->stock . ' tersedia' : 'Habis' }}
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div style="background:#f0f4ff;border-radius:.6rem;padding:.6rem .85rem">
                        <div style="color:#6b7280;font-size:.75rem">Kategori</div>
                        <div style="font-weight:700;color:var(--dark-blue)">{{ $product->category->name ?? '-' }}</div>
                    </div>
                </div>
            </div>

            {{-- Aksi --}}
            @if($product->isAvailable())
                @auth
                <div class="d-flex gap-3">
                    <form action="{{ url('/cart/add') }}" method="POST" class="flex-grow-1">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-outline-main w-100 py-2">
                            <i class="bi bi-bag-plus me-2"></i>Tambah ke Keranjang
                        </button>
                    </form>
                    <a href="{{ url('/checkout/'.$product->id) }}" class="btn btn-main flex-grow-1 py-2">
                        Beli Sekarang
                    </a>
                </div>
                @else
                <a href="{{ route('login') }}" class="btn btn-main w-100 py-2">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Login untuk Membeli
                </a>
                @endauth
            @else
                <button class="btn w-100 py-2" style="background:#f3f4f6;color:#9ca3af" disabled>
                    Stok Habis
                </button>
            @endif

            {{-- Wishlist --}}
            @auth
            <form action="{{ url('/wishlist/toggle') }}" method="POST" class="mt-2">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="btn w-100" style="background:#f0f4ff;color:var(--dark-blue);font-size:.85rem">
                    <i class="bi bi-heart me-1"></i> Simpan ke Wishlist
                </button>
            </form>
            @endauth
        </div>
    </div>

    {{-- Info Toko --}}
    <div class="card mt-4 p-3">
        <div class="d-flex align-items-center gap-3">
            <div style="width:52px;height:52px;border-radius:50%;background:linear-gradient(135deg,var(--dark-blue),var(--light-blue));display:flex;align-items:center;justify-content:center;color:white;font-weight:800;font-size:1.2rem">
                {{ strtoupper(substr($product->shop->name,0,1)) }}
            </div>
            <div class="flex-grow-1">
                <div style="font-weight:700;color:var(--dark-blue)">{{ $product->shop->name }}</div>
                <div style="font-size:.8rem;color:#6b7280">
                    <i class="bi bi-geo-alt me-1"></i>{{ $product->shop->city }}, {{ $product->shop->province }}
                </div>
            </div>
            <a href="{{ url('/shops/'.$product->shop->slug) }}" class="btn btn-outline-main btn-sm px-3">
                Kunjungi Toko
            </a>
        </div>
    </div>

    {{-- Ulasan --}}
    @if($product->reviews->count() > 0)
    <div class="mt-4">
        <h5 style="font-weight:700;color:var(--dark-blue)" class="mb-3">⭐ Ulasan Pembeli</h5>
        @foreach($product->reviews->take(5) as $review)
        <div class="card p-3 mb-3">
            <div class="d-flex align-items-center gap-3 mb-2">
                <div style="width:36px;height:36px;border-radius:50%;background:var(--light-blue);display:flex;align-items:center;justify-content:center;color:var(--dark-blue);font-weight:700">
                    {{ strtoupper(substr($review->user->name,0,1)) }}
                </div>
                <div>
                    <div style="font-weight:600;font-size:.88rem">{{ $review->user->name }}</div>
                    <div style="color:#f59e0b;font-size:.8rem">
                        @for($i=1;$i<=5;$i++)
                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                        @endfor
                    </div>
                </div>
                <div class="ms-auto" style="font-size:.75rem;color:#9ca3af">{{ $review->created_at->diffForHumans() }}</div>
            </div>
            @if($review->comment)
                <p style="font-size:.88rem;color:#4b5563;margin:0">{{ $review->comment }}</p>
            @endif
        </div>
        @endforeach
    </div>
    @endif

</div>
@endsection
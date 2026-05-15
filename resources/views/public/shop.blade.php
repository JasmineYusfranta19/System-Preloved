@extends('layouts.app')
@section('title', $shop->name)

@section('content')

{{-- Banner Toko --}}
<div style="background:linear-gradient(135deg,var(--dark-blue),#4a6bb5);height:160px;position:relative">
    @if($shop->banner)
        <img src="{{ Storage::url($shop->banner) }}" style="width:100%;height:100%;object-fit:cover;opacity:.5">
    @endif
</div>

<div class="container" style="margin-top:-40px">

    {{-- Profil Toko --}}
    <div class="card p-4 mb-4">
        <div class="d-flex align-items-end gap-4 flex-wrap">
            @if($shop->logo)
                <img src="{{ Storage::url($shop->logo) }}"
                    style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:4px solid white;margin-top:-20px">
            @else
                <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,var(--dark-blue),var(--light-blue));display:flex;align-items:center;justify-content:center;color:white;font-weight:800;font-size:2rem;border:4px solid white;margin-top:-20px">
                    {{ strtoupper(substr($shop->name,0,1)) }}
                </div>
            @endif
            <div class="flex-grow-1">
                <h4 style="font-weight:800;color:var(--dark-blue);margin:0">{{ $shop->name }}</h4>
                <div style="font-size:.85rem;color:#6b7280" class="mt-1">
                    <i class="bi bi-geo-alt me-1"></i>{{ $shop->city }}, {{ $shop->province }}
                    <span class="ms-3"><i class="bi bi-box-seam me-1"></i>{{ $products->total() }} Produk</span>
                </div>
            </div>
        </div>
        @if($shop->description)
            <p style="font-size:.88rem;color:#4b5563;margin-top:1rem;margin-bottom:0">{{ $shop->description }}</p>
        @endif
    </div>

    {{-- Produk Toko --}}
    <h5 style="font-weight:700;color:var(--dark-blue)" class="mb-3">Produk dari {{ $shop->name }}</h5>

    @if($products->isEmpty())
    <div class="text-center py-5 text-muted">
        <div style="font-size:3rem">📦</div>
        <p class="mt-2">Toko ini belum punya produk.</p>
    </div>
    @else
    <div class="row g-3">
        @foreach($products as $product)
        <div class="col-6 col-md-4 col-lg-3">
            <a href="{{ url('/products/'.$product->slug) }}" style="text-decoration:none">
                <div class="product-card">
                    @if($product->primaryImage)
                        <img src="{{ $product->primaryImage->image_url }}" alt="{{ $product->name }}">
                    @else
                        <div style="height:220px;background:#f0f4ff;display:flex;align-items:center;justify-content:center;font-size:4rem">👗</div>
                    @endif
                    <div class="card-body">
                        <span class="product-badge">{{ ['new'=>'Baru','like_new'=>'Seperti Baru','good'=>'Bagus','fair'=>'Cukup'][$product->condition] ?? '-' }}</span>
                        <div class="fw-600 mt-1" style="font-size:.88rem;color:#1e2a4a">{{ Str::limit($product->name, 30) }}</div>
                        <div class="product-price mt-1">{{ $product->formatted_price }}</div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $products->links() }}</div>
    @endif
</div>
@endsection
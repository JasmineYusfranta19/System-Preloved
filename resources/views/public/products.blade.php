@extends('layouts.app')
@section('title', 'Semua Produk')

@section('content')
<div class="container mt-4">
    <div class="row g-4">

        {{-- Sidebar Filter --}}
        <div class="col-lg-3">
            <div class="card p-3 sticky-top" style="top:80px">
                <h6 class="fw-700 mb-3" style="font-weight:700;color:var(--dark-blue)">🔍 Filter Produk</h6>
                <form action="{{ url('/products') }}" method="GET">

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#6b7280">CARI</label>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Nama produk, brand...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#6b7280">KATEGORI</label>
                        <select name="category" class="form-select form-select-sm">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <optgroup label="{{ $cat->name }}">
                                    @foreach($cat->children as $child)
                                        <option value="{{ $child->slug }}" {{ request('category')===$child->slug?'selected':'' }}>
                                            {{ $child->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#6b7280">KONDISI</label>
                        @foreach(['new'=>'Baru','like_new'=>'Seperti Baru','good'=>'Bagus','fair'=>'Cukup'] as $val=>$label)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="condition[]" value="{{ $val }}" id="cond_{{ $val }}"
                                {{ in_array($val, request('condition',[])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="cond_{{ $val }}" style="font-size:.85rem">{{ $label }}</label>
                        </div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#6b7280">UKURAN</label>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach(['XS','S','M','L','XL','XXL'] as $s)
                            <input type="checkbox" class="btn-check" name="size[]" value="{{ $s }}" id="size_{{ $s }}"
                                {{ in_array($s, request('size',[])) ? 'checked' : '' }}>
                            <label class="btn btn-sm btn-outline-main" for="size_{{ $s }}" style="padding:.2rem .5rem;font-size:.78rem">{{ $s }}</label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#6b7280">GENDER</label>
                        <select name="gender" class="form-select form-select-sm">
                            <option value="">Semua</option>
                            <option value="women" {{ request('gender')==='women'?'selected':'' }}>Wanita</option>
                            <option value="men" {{ request('gender')==='men'?'selected':'' }}>Pria</option>
                            <option value="unisex" {{ request('gender')==='unisex'?'selected':'' }}>Unisex</option>
                            <option value="kids" {{ request('gender')==='kids'?'selected':'' }}>Anak-anak</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label" style="font-size:.82rem;font-weight:600;color:#6b7280">HARGA (Rp)</label>
                        <div class="d-flex gap-2">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" class="form-control form-control-sm" placeholder="Min">
                            <input type="number" name="max_price" value="{{ request('max_price') }}" class="form-control form-control-sm" placeholder="Max">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-main w-100 mb-2">Terapkan Filter</button>
                    <a href="{{ url('/products') }}" class="btn btn-outline-main w-100" style="font-size:.85rem">Reset</a>
                </form>
            </div>
        </div>

        {{-- Product Grid --}}
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div>
                    <span class="section-title" style="font-size:1.1rem">Semua Produk</span>
                    <span class="text-muted ms-2" style="font-size:.85rem">({{ $products->total() }} produk)</span>
                </div>
                <select name="sort" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                    <option>Terbaru</option>
                    <option>Harga Termurah</option>
                    <option>Harga Termahal</option>
                </select>
            </div>

            @if($products->isEmpty())
            <div class="text-center py-5 text-muted">
                <div style="font-size:3.5rem">🔍</div>
                <h6 class="mt-3">Produk tidak ditemukan</h6>
                <p style="font-size:.85rem">Coba kata kunci atau filter yang berbeda.</p>
                <a href="{{ url('/products') }}" class="btn btn-main px-4">Lihat Semua Produk</a>
            </div>
            @else
            <div class="row g-3">
                @foreach($products as $product)
                <div class="col-6 col-md-4">
                    <a href="{{ url('/products/'.$product->slug) }}" style="text-decoration:none">
                        <div class="product-card">
                            @if($product->primaryImage)
                                <img src="{{ $product->primaryImage->image_url }}" alt="{{ $product->name }}">
                            @else
                                <div style="height:220px;background:#f0f4ff;display:flex;align-items:center;justify-content:center;font-size:4rem">👗</div>
                            @endif
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <span class="product-badge">
                                        {{ ['new'=>'Baru','like_new'=>'Seperti Baru','good'=>'Bagus','fair'=>'Cukup'][$product->condition] ?? '-' }}
                                    </span>
                                    @if($product->size)
                                        <span style="font-size:.72rem;color:#6b7280">{{ $product->size }}</span>
                                    @endif
                                </div>
                                <div class="fw-600 mt-1" style="font-size:.88rem;line-height:1.3;color:#1e2a4a">
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
                @endforeach
            </div>

            <div class="mt-4">{{ $products->withQueryString()->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
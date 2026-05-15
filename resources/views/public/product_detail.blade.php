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
                    <button type="button" class="btn btn-outline-main flex-grow-1 py-2"
                        data-bs-toggle="modal" data-bs-target="#modalKeranjang">
                        <i class="bi bi-bag-plus me-2"></i>Tambah ke Keranjang
                    </button>
                    <button type="button" class="btn btn-main flex-grow-1 py-2"
                        data-bs-toggle="modal" data-bs-target="#modalBeliSekarang">
                        Beli Sekarang
                    </button>
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
            @if($product->shop->logo)
                <img src="{{ Storage::url($product->shop->logo) }}"
                    style="width:52px;height:52px;border-radius:50%;object-fit:cover;flex-shrink:0">
            @else
                <div style="width:52px;height:52px;border-radius:50%;background:linear-gradient(135deg,var(--dark-blue),var(--light-blue));display:flex;align-items:center;justify-content:center;color:white;font-weight:800;font-size:1.2rem;flex-shrink:0">
                    {{ strtoupper(substr($product->shop->name,0,1)) }}
                </div>
            @endif
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

@auth
{{-- Modal 1: Tambah ke Keranjang --}}
<div class="modal fade" id="modalKeranjang" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px">
        <div class="modal-content" style="border-radius:1rem;border:none;overflow:hidden">
            <div class="modal-body p-0">
                <div style="background:linear-gradient(135deg,var(--dark-blue),#4a6bb5);padding:1.25rem 1.5rem;color:white">
                    <div class="d-flex align-items-center justify-content-between">
                        <span style="font-weight:700;font-size:.95rem">🛒 Tambah ke Keranjang</span>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                </div>
                <div class="p-4">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        @if($product->primaryImage)
                            <img src="{{ $product->primaryImage->image_url }}"
                                style="width:72px;height:72px;object-fit:cover;border-radius:.65rem;flex-shrink:0;border:2px solid #dde8f8">
                        @else
                            <div style="width:72px;height:72px;border-radius:.65rem;background:#f0f4ff;display:flex;align-items:center;justify-content:center;font-size:2rem;flex-shrink:0">👗</div>
                        @endif
                        <div>
                            <div style="font-weight:700;color:var(--dark-blue);font-size:.95rem;line-height:1.3">
                                {{ Str::limit($product->name, 35) }}
                            </div>
                            @if($product->brand)
                                <div style="font-size:.75rem;color:#9ca3af">{{ $product->brand }}</div>
                            @endif
                            <div style="font-weight:800;color:var(--dark-blue);font-size:1.1rem;margin-top:.3rem">
                                {{ $product->formatted_price }}
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 flex-wrap mb-4">
                        <span style="background:#f0f4ff;border-radius:.5rem;padding:.3rem .7rem;font-size:.78rem;color:var(--dark-blue)">
                            Kondisi: <strong>{{ ['new'=>'Baru','like_new'=>'Seperti Baru','good'=>'Bagus','fair'=>'Cukup'][$product->condition] ?? '-' }}</strong>
                        </span>
                        @if($product->size)
                        <span style="background:#f0f4ff;border-radius:.5rem;padding:.3rem .7rem;font-size:.78rem;color:var(--dark-blue)">
                            Ukuran: <strong>{{ $product->size }}</strong>
                        </span>
                        @endif
                        <span style="background:#f0f4ff;border-radius:.5rem;padding:.3rem .7rem;font-size:.78rem;color:var(--dark-blue)">
                            Stok: <strong>{{ $product->stock }}</strong>
                        </span>
                    </div>
                    <div class="mb-4">
                        <label style="font-size:.85rem;font-weight:700;color:var(--dark-blue);display:block;margin-bottom:.5rem">Jumlah</label>
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center" style="border:2px solid #dde8f8;border-radius:.6rem;overflow:hidden">
                                <button type="button" onclick="changeQty('cart', -1)"
                                    style="width:40px;height:40px;border:none;background:#f0f4ff;color:var(--dark-blue);font-size:1.2rem;font-weight:700;cursor:pointer">−</button>
                                <input type="number" id="cartQty" value="1" min="1" max="{{ $product->stock }}"
                                    oninput="syncQty('cart')"
                                    style="width:50px;text-align:center;border:none;font-size:1rem;font-weight:700;color:var(--dark-blue);outline:none">
                                <button type="button" onclick="changeQty('cart', 1)"
                                    style="width:40px;height:40px;border:none;background:#f0f4ff;color:var(--dark-blue);font-size:1.2rem;font-weight:700;cursor:pointer">+</button>
                            </div>
                            <span style="font-size:.8rem;color:#9ca3af">Maks. {{ $product->stock }}</span>
                        </div>
                    </div>
                    <div style="background:linear-gradient(135deg,var(--dark-blue),#4a6bb5);border-radius:.75rem;padding:.85rem 1rem;margin-bottom:1.25rem">
                        <div class="d-flex justify-content-between align-items-center">
                            <span style="color:rgba(255,255,255,.75);font-size:.85rem">Total Harga</span>
                            <span id="cartTotal" style="color:white;font-weight:800;font-size:1.15rem">{{ $product->formatted_price }}</span>
                        </div>
                    </div>
                    <form action="{{ url('/cart/add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" id="cartQtyHidden" value="1">
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-main flex-grow-1 py-2" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-main flex-grow-1 py-2">
                                <i class="bi bi-bag-plus me-1"></i> Masukkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal 2: Beli Sekarang --}}
<div class="modal fade" id="modalBeliSekarang" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:500px">
        <div class="modal-content" style="border-radius:1rem;border:none;overflow:hidden">
            <div class="modal-body p-0">
                <div style="background:linear-gradient(135deg,var(--dark-blue),#4a6bb5);padding:1.25rem 1.5rem;color:white">
                    <div class="d-flex align-items-center justify-content-between">
                        <span style="font-weight:700;font-size:.95rem">⚡ Beli Sekarang</span>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                </div>
                <div class="p-4">
                    <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                        @if($product->primaryImage)
                            <img src="{{ $product->primaryImage->image_url }}"
                                style="width:60px;height:60px;object-fit:cover;border-radius:.6rem;flex-shrink:0">
                        @else
                            <div style="width:60px;height:60px;border-radius:.6rem;background:#f0f4ff;display:flex;align-items:center;justify-content:center;font-size:1.8rem;flex-shrink:0">👗</div>
                        @endif
                        <div class="flex-grow-1">
                            <div style="font-weight:700;color:var(--dark-blue);font-size:.9rem">{{ Str::limit($product->name, 35) }}</div>
                            <div style="font-size:.75rem;color:#9ca3af">
                                {{ ['new'=>'Baru','like_new'=>'Seperti Baru','good'=>'Bagus','fair'=>'Cukup'][$product->condition] ?? '-' }}
                                @if($product->size) · {{ $product->size }} @endif
                            </div>
                        </div>
                        <div style="font-weight:800;color:var(--dark-blue)">{{ $product->formatted_price }}</div>
                    </div>
                    <div class="mb-4">
                        <label style="font-size:.85rem;font-weight:700;color:var(--dark-blue);display:block;margin-bottom:.5rem">Jumlah</label>
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center" style="border:2px solid #dde8f8;border-radius:.6rem;overflow:hidden">
                                <button type="button" onclick="changeQty('buy', -1)"
                                    style="width:40px;height:40px;border:none;background:#f0f4ff;color:var(--dark-blue);font-size:1.2rem;font-weight:700;cursor:pointer">−</button>
                                <input type="number" id="buyQty" value="1" min="1" max="{{ $product->stock }}"
                                    oninput="syncQty('buy')"
                                    style="width:50px;text-align:center;border:none;font-size:1rem;font-weight:700;color:var(--dark-blue);outline:none">
                                <button type="button" onclick="changeQty('buy', 1)"
                                    style="width:40px;height:40px;border:none;background:#f0f4ff;color:var(--dark-blue);font-size:1.2rem;font-weight:700;cursor:pointer">+</button>
                            </div>
                            <span style="font-size:.8rem;color:#9ca3af">Maks. {{ $product->stock }}</span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label style="font-size:.85rem;font-weight:700;color:var(--dark-blue);display:block;margin-bottom:.5rem">📍 Alamat Pengiriman</label>
                        @php $addresses = auth()->user()->addresses; @endphp
                        @if($addresses->isEmpty())
                            <div style="background:#fff8e1;border-radius:.65rem;padding:.75rem 1rem;font-size:.82rem;color:#92400e">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                Belum ada alamat. <a href="{{ url('/checkout') }}" style="color:var(--dark-blue);font-weight:700">Tambah di checkout</a>
                            </div>
                        @else
                            <select id="buyAddressId" style="width:100%;border:2px solid #dde8f8;border-radius:.6rem;padding:.6rem .85rem;font-size:.88rem;color:var(--dark-blue);outline:none;background:white">
                                @foreach($addresses as $addr)
                                <option value="{{ $addr->id }}" {{ $addr->is_default ? 'selected' : '' }}>
                                    {{ $addr->label }} — {{ $addr->recipient_name }}, {{ $addr->city }}
                                </option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <div style="background:#f0f4ff;border-radius:.75rem;padding:1rem;margin-bottom:1.25rem;font-size:.88rem">
                        <div class="d-flex justify-content-between mb-2">
                            <span style="color:#6b7280">Harga Produk</span>
                            <span id="buySubtotal" style="font-weight:600;color:var(--dark-blue)">{{ $product->formatted_price }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span style="color:#6b7280">Ongkos Kirim</span>
                            <span style="font-weight:600;color:var(--dark-blue)">Rp 15.000</span>
                        </div>
                        <div style="border-top:1px solid #dde8f8;margin:.5rem 0"></div>
                        <div class="d-flex justify-content-between">
                            <span style="font-weight:700;color:var(--dark-blue)">Total</span>
                            <span id="buyTotal" style="font-weight:800;color:var(--dark-blue);font-size:1rem">
                                Rp {{ number_format($product->price + 15000, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                    <form action="{{ url('/cart/add') }}" method="POST" id="formBeliSekarang">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" id="buyQtyHidden" value="1">
                        <input type="hidden" name="redirect_checkout" value="1">
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-main flex-grow-1 py-2" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-main flex-grow-1 py-2" {{ $addresses->isEmpty() ? 'disabled' : '' }}>
                                Pesan Sekarang →
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endauth

@push('scripts')
<script>
const harga   = {{ $product->price }};
const stokMax = {{ $product->stock }};
const ongkir  = 15000;

function changeQty(type, delta) {
    const id  = type === 'cart' ? 'cartQty' : 'buyQty';
    const inp = document.getElementById(id);
    let val   = parseInt(inp.value) + delta;
    if (val < 1) val = 1;
    if (val > stokMax) val = stokMax;
    inp.value = val;
    updateTotal(type, val);
}

function syncQty(type) {
    const id = type === 'cart' ? 'cartQty' : 'buyQty';
    let val  = parseInt(document.getElementById(id).value) || 1;
    if (val < 1) val = 1;
    if (val > stokMax) val = stokMax;
    document.getElementById(id).value = val;
    updateTotal(type, val);
}

function updateTotal(type, qty) {
    const subtotal = qty * harga;
    const fmt = v => 'Rp ' + v.toLocaleString('id-ID');
    if (type === 'cart') {
        document.getElementById('cartQtyHidden').value = qty;
        document.getElementById('cartTotal').textContent = fmt(subtotal);
    } else {
        document.getElementById('buyQtyHidden').value = qty;
        document.getElementById('buySubtotal').textContent = fmt(subtotal);
        document.getElementById('buyTotal').textContent = fmt(subtotal + ongkir);
    }
}
</script>
@endpush
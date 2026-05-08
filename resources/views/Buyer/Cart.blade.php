@extends('layouts.app')
@section('title', 'Keranjang Belanja')

@section('content')
<div class="container mt-4">
    <h5 style="font-weight:800;color:var(--dark-blue)" class="mb-4">🛒 Keranjang Belanja</h5>

    @if($carts->isEmpty())
    <div class="text-center py-5">
        <div style="font-size:4rem">🛒</div>
        <h6 class="mt-3" style="color:var(--dark-blue)">Keranjang kamu kosong</h6>
        <p class="text-muted" style="font-size:.88rem">Yuk mulai belanja produk preloved pilihan!</p>
        <a href="{{ url('/products') }}" class="btn btn-main px-4 mt-2">Mulai Belanja</a>
    </div>
    @else
    <div class="row g-4">
        {{-- Cart Items --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-0">
                    <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                        <span style="font-size:.85rem;font-weight:600;color:#6b7280">{{ $carts->count() }} produk di keranjang</span>
                        <form action="{{ url('/cart/clear') }}" method="POST" onsubmit="return confirm('Kosongkan keranjang?')">
                            @csrf
                            <button class="btn btn-sm" style="color:#ef4444;background:#fff1f2;font-size:.78rem">
                                <i class="bi bi-trash me-1"></i>Kosongkan
                            </button>
                        </form>
                    </div>

                    @foreach($carts as $cart)
                    <div class="d-flex gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }} align-items-center">
                        {{-- Gambar --}}
                        @if($cart->product->primaryImage)
                            <img src="{{ $cart->product->primaryImage->image_url }}"
                                style="width:80px;height:80px;object-fit:cover;border-radius:.6rem;flex-shrink:0">
                        @else
                            <div style="width:80px;height:80px;border-radius:.6rem;background:#f0f4ff;display:flex;align-items:center;justify-content:center;font-size:2rem;flex-shrink:0">👗</div>
                        @endif

                        {{-- Info --}}
                        <div class="flex-grow-1">
                            <div style="font-weight:600;font-size:.9rem;color:var(--dark-blue)">
                                {{ Str::limit($cart->product->name, 40) }}
                            </div>
                            <div style="font-size:.78rem;color:#9ca3af">
                                {{ $cart->product->shop->name ?? '-' }}
                                @if($cart->product->size) · {{ $cart->product->size }} @endif
                            </div>
                            <div style="font-weight:700;color:var(--dark-blue);margin-top:.25rem">
                                {{ $cart->product->formatted_price }}
                            </div>
                        </div>

                        {{-- Qty & Hapus --}}
                        <div class="d-flex flex-column align-items-end gap-2">
                            <form action="{{ url('/cart/'.$cart->id) }}" method="POST" class="d-flex align-items-center gap-1">
                                @csrf @method('PUT')
                                <button type="button" onclick="changeQty(this,-1)" class="btn btn-sm" style="background:#f0f4ff;color:var(--dark-blue);width:28px;height:28px;padding:0">−</button>
                                <input type="number" name="quantity" value="{{ $cart->quantity }}" min="1" max="{{ $cart->product->stock }}"
                                    style="width:40px;text-align:center;border:1.5px solid #dde8f8;border-radius:.4rem;font-size:.85rem;padding:.1rem"
                                    onchange="this.form.submit()">
                                <button type="button" onclick="changeQty(this,1)" class="btn btn-sm" style="background:#f0f4ff;color:var(--dark-blue);width:28px;height:28px;padding:0">+</button>
                            </form>
                            <div style="font-weight:700;color:var(--dark-blue);font-size:.95rem">
                                Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}
                            </div>
                            <form action="{{ url('/cart/'.$cart->id.'/remove') }}" method="POST">
                                @csrf
                                <button class="btn btn-sm" style="color:#ef4444;font-size:.75rem;padding:.1rem .4rem">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Summary --}}
        <div class="col-lg-4">
            <div class="card p-3 sticky-top" style="top:80px">
                <h6 style="font-weight:700;color:var(--dark-blue)" class="mb-3">Ringkasan Belanja</h6>

                <div class="d-flex justify-content-between mb-2" style="font-size:.88rem">
                    <span class="text-muted">Subtotal ({{ $carts->count() }} produk)</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2" style="font-size:.88rem">
                    <span class="text-muted">Ongkos Kirim</span>
                    <span>Rp 15.000</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-700 mb-4" style="font-size:1rem;color:var(--dark-blue)">
                    <span>Total</span>
                    <span>Rp {{ number_format($total + 15000, 0, ',', '.') }}</span>
                </div>

                <a href="{{ url('/checkout') }}" class="btn btn-main w-100 py-2">
                    Lanjut ke Checkout →
                </a>
                <a href="{{ url('/products') }}" class="btn btn-outline-main w-100 mt-2 py-2" style="font-size:.85rem">
                    + Tambah Produk Lagi
                </a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function changeQty(btn, delta) {
    const form = btn.closest('form');
    const input = form.querySelector('input[name="quantity"]');
    const newVal = parseInt(input.value) + delta;
    const max = parseInt(input.max);
    if (newVal >= 1 && newVal <= max) {
        input.value = newVal;
        form.submit();
    }
}
</script>
@endpush
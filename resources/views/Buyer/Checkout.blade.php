@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="container mt-4">
    <h5 style="font-weight:800;color:var(--dark-blue)" class="mb-4">💳 Checkout</h5>

    <form action="{{ url('/checkout/process') }}" method="POST">
        @csrf
        <div class="row g-4">
            {{-- Kiri --}}
            <div class="col-lg-8">

                {{-- Pilih Alamat --}}
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 style="font-weight:700;color:var(--dark-blue)" class="mb-3">📍 Alamat Pengiriman</h6>

                        @if($addresses->isEmpty())
                            <div class="alert alert-warning border-0 rounded-3" style="font-size:.85rem">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Kamu belum punya alamat. <a href="{{ url('/profile/address/create') }}" style="color:var(--dark-blue);font-weight:700">Tambah alamat dulu</a>.
                            </div>
                        @else
                            @foreach($addresses as $address)
                            <div class="form-check mb-3 p-0">
                                <div style="border:2px solid {{ $address->is_default ? 'var(--dark-blue)' : '#dde8f8' }};border-radius:.75rem;padding:1rem;cursor:pointer;transition:.2s"
                                    onclick="selectAddress({{ $address->id }}, this)">
                                    <div class="d-flex align-items-start gap-3">
                                        <input class="form-check-input mt-1" type="radio" name="address_id"
                                            value="{{ $address->id }}" id="addr_{{ $address->id }}"
                                            {{ $address->is_default ? 'checked' : '' }} required>
                                        <div>
                                            <div style="font-weight:700;font-size:.9rem;color:var(--dark-blue)">
                                                {{ $address->label }}
                                                @if($address->is_default)
                                                    <span style="background:var(--light-green);color:var(--dark-blue);font-size:.68rem;padding:.15rem .5rem;border-radius:2rem;font-weight:700;margin-left:.4rem">Utama</span>
                                                @endif
                                            </div>
                                            <div style="font-size:.85rem;color:#4b5563;margin-top:.25rem">
                                                {{ $address->recipient_name }} · {{ $address->phone }}
                                            </div>
                                            <div style="font-size:.82rem;color:#6b7280;margin-top:.1rem">
                                                {{ $address->full_address }}, {{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                {{-- Detail Produk --}}
                <div class="card">
                    <div class="card-body">
                        <h6 style="font-weight:700;color:var(--dark-blue)" class="mb-3">📦 Produk yang Dipesan</h6>
                        @foreach($carts as $cart)
                        <div class="d-flex align-items-center gap-3 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                            @if($cart->product->primaryImage)
                                <img src="{{ $cart->product->primaryImage->image_url }}"
                                    style="width:56px;height:56px;object-fit:cover;border-radius:.5rem;flex-shrink:0">
                            @else
                                <div style="width:56px;height:56px;border-radius:.5rem;background:#f0f4ff;display:flex;align-items:center;justify-content:center;font-size:1.5rem;flex-shrink:0">👗</div>
                            @endif
                            <div class="flex-grow-1">
                                <div style="font-weight:600;font-size:.88rem;color:var(--dark-blue)">{{ Str::limit($cart->product->name, 35) }}</div>
                                <div style="font-size:.75rem;color:#9ca3af">{{ $cart->product->shop->name ?? '-' }} · {{ $cart->quantity }}x</div>
                            </div>
                            <div style="font-weight:700;color:var(--dark-blue);font-size:.9rem">
                                Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Kanan: Summary --}}
            <div class="col-lg-4">
                <div class="card p-3 sticky-top" style="top:80px">
                    <h6 style="font-weight:700;color:var(--dark-blue)" class="mb-3">Ringkasan Pembayaran</h6>

                    <div class="d-flex justify-content-between mb-2" style="font-size:.88rem">
                        <span class="text-muted">Subtotal</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2" style="font-size:.88rem">
                        <span class="text-muted">Ongkos Kirim</span>
                        <span>Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-700 mb-4" style="font-size:1.1rem;color:var(--dark-blue)">
                        <span>Total</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <div class="mb-3 p-2 rounded-3" style="background:#f0f4ff;font-size:.8rem;color:#6b7280">
                        <i class="bi bi-info-circle me-1"></i>
                        Pembayaran akan diproses melalui Midtrans setelah konfirmasi pesanan.
                    </div>

                    <button type="submit" class="btn btn-main w-100 py-2"
                        {{ $addresses->isEmpty() ? 'disabled' : '' }}>
                        Buat Pesanan 🚀
                    </button>
                    <a href="{{ url('/cart') }}" class="btn btn-outline-main w-100 mt-2 py-2" style="font-size:.85rem">
                        ← Kembali ke Keranjang
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function selectAddress(id, el) {
    document.querySelectorAll('[onclick^="selectAddress"]').forEach(e => {
        e.style.borderColor = '#dde8f8';
    });
    el.style.borderColor = 'var(--dark-blue)';
    document.getElementById('addr_' + id).checked = true;
}
</script>
@endpush
@extends('layouts.app')
@section('title', 'Pembayaran')

@section('content')
<div class="container mt-4" style="max-width:640px">
    <div class="card p-4">
        <div class="text-center mb-4">
            <div style="font-size:3rem">💳</div>
            <h5 style="font-weight:800;color:var(--dark-blue)" class="mt-2">Selesaikan Pembayaran</h5>
            <p class="text-muted" style="font-size:.85rem">Order: <strong>{{ $order->order_number }}</strong></p>
        </div>

        {{-- Total --}}
        <div style="background:linear-gradient(135deg,var(--dark-blue),#4a6bb5);border-radius:.85rem;padding:1.25rem;color:white;text-align:center;margin-bottom:1.5rem">
            <div style="font-size:.85rem;opacity:.75">Total Pembayaran</div>
            <div style="font-size:2rem;font-weight:800;margin-top:.25rem">{{ $order->formatted_total }}</div>
            <div style="font-size:.75rem;opacity:.65;margin-top:.25rem">
                Bayar sebelum {{ $order->expires_at?->format('d M Y, H:i') ?? '-' }} WIB
            </div>
        </div>

        {{-- Items --}}
        <div class="mb-4">
            <div style="font-weight:700;color:var(--dark-blue);font-size:.88rem;margin-bottom:.75rem">Detail Pesanan</div>
            @foreach($order->items as $item)
            <div class="d-flex align-items-center gap-3 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                @if($item->product?->primaryImage)
                    <img src="{{ $item->product->primaryImage->image_url }}" style="width:48px;height:48px;object-fit:cover;border-radius:.5rem;flex-shrink:0">
                @else
                    <div style="width:48px;height:48px;border-radius:.5rem;background:#f0f4ff;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0">👗</div>
                @endif
                <div class="flex-grow-1">
                    <div style="font-size:.85rem;font-weight:600;color:var(--dark-blue)">{{ Str::limit($item->product->name ?? '-', 30) }}</div>
                    <div style="font-size:.75rem;color:#9ca3af">{{ $item->quantity }}x · Rp {{ number_format($item->price,0,',','.') }}</div>
                </div>
                <div style="font-weight:700;font-size:.88rem;color:var(--dark-blue)">Rp {{ number_format($item->subtotal,0,',','.') }}</div>
            </div>
            @endforeach
        </div>

        {{-- Alamat --}}
        <div style="background:#f0f4ff;border-radius:.75rem;padding:1rem;margin-bottom:1.5rem;font-size:.85rem">
            <div style="font-weight:700;color:var(--dark-blue);margin-bottom:.3rem">📍 Dikirim ke</div>
            <div>{{ $order->address->recipient_name }} · {{ $order->address->phone }}</div>
            <div style="color:#6b7280">{{ $order->address->full_address }}, {{ $order->address->city }}</div>
        </div>

        {{-- Tombol Bayar via Midtrans (akan diintegrasikan) --}}
        <button id="pay-button" class="btn btn-main w-100 py-3" style="font-size:1rem">
            <i class="bi bi-credit-card me-2"></i>Bayar Sekarang
        </button>

        <a href="{{ url('/orders') }}" class="btn btn-outline-main w-100 mt-2 py-2" style="font-size:.85rem">
            Lihat Semua Pesanan
        </a>

        <p class="text-center text-muted mt-3 mb-0" style="font-size:.75rem">
            🔒 Pembayaran aman diproses oleh Midtrans
        </p>
    </div>
</div>
@endsection
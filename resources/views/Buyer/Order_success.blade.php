@extends('layouts.app')
@section('title', 'Pesanan Berhasil')

@section('content')
<div class="container mt-5" style="max-width:520px">
    <div class="card p-4 text-center">
        <div style="font-size:4rem">🎉</div>
        <h5 style="font-weight:800;color:var(--dark-blue);margin-top:1rem">Pesanan Berhasil Dibuat!</h5>
        <p class="text-muted" style="font-size:.88rem">
            Pesanan <strong>{{ $order->order_number }}</strong> sudah kami terima.
            Selesaikan pembayaran agar pesanan segera diproses.
        </p>
        <div style="background:#f0f4ff;border-radius:.75rem;padding:1rem;margin:1rem 0;text-align:left;font-size:.85rem">
            <div class="d-flex justify-content-between mb-1">
                <span class="text-muted">No. Pesanan</span>
                <span class="fw-700">{{ $order->order_number }}</span>
            </div>
            <div class="d-flex justify-content-between mb-1">
                <span class="text-muted">Total</span>
                <span class="fw-700" style="color:var(--dark-blue)">{{ $order->formatted_total }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span class="text-muted">Status</span>
                <span class="badge bg-warning">Menunggu Pembayaran</span>
            </div>
        </div>
        <a href="{{ route('orders.payment', $order) }}" class="btn btn-main w-100 py-2 mb-2">
            💳 Bayar Sekarang
        </a>
        <a href="{{ url('/orders') }}" class="btn btn-outline-main w-100 py-2" style="font-size:.85rem">
            Lihat Semua Pesanan
        </a>
    </div>
</div>
@endsection
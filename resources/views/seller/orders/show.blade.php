@extends('layouts.seller')
@section('title', 'Detail Pesanan')
@section('page-title', '📋 Detail Pesanan')

@section('content')
<div class="row g-4">
    {{-- Kiri: Info Pesanan --}}
    <div class="col-lg-8">
        {{-- Header --}}
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                    <div>
                        <h6 class="fw-700 mb-1" style="font-weight:700;color:#1e1b4b">{{ $order->order_number }}</h6>
                        <p class="text-muted mb-0" style="font-size:.82rem">{{ $order->created_at->format('d F Y, H:i') }} WIB</p>
                    </div>
                    @php
                    $statusColors = ['pending'=>'warning','paid'=>'info','shipped'=>'secondary','completed'=>'success','cancelled'=>'danger'];
                    $statusLabels = ['pending'=>'Menunggu Pembayaran','paid'=>'Sudah Dibayar','shipped'=>'Dalam Pengiriman','completed'=>'Selesai','cancelled'=>'Dibatalkan'];
                    @endphp
                    <span class="badge bg-{{ $statusColors[$order->status]??'secondary' }} px-3 py-2" style="font-size:.82rem">
                        {{ $statusLabels[$order->status]??$order->status }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Items --}}
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="fw-700 mb-3" style="font-weight:700">📦 Item Pesanan</h6>
                @foreach($order->items as $item)
                <div class="d-flex align-items-center gap-3 py-3 {{ !$loop->last?'border-bottom':'' }}">
                    @if($item->product?->primaryImage)
                        <img src="{{ $item->product->primaryImage->image_url }}" style="width:64px;height:64px;object-fit:cover;border-radius:.6rem">
                    @else
                        <div style="width:64px;height:64px;border-radius:.6rem;background:#f3f4f6;display:flex;align-items:center;justify-content:center;font-size:1.8rem">👗</div>
                    @endif
                    <div class="flex-grow-1">
                        <div class="fw-600" style="font-size:.9rem">{{ $item->product->name ?? 'Produk dihapus' }}</div>
                        <div class="text-muted" style="font-size:.78rem">{{ $item->quantity }}x · Rp {{ number_format($item->price,0,',','.') }}</div>
                    </div>
                    <div class="fw-700" style="color:#8b5cf6">Rp {{ number_format($item->subtotal,0,',','.') }}</div>
                </div>
                @endforeach

                <div class="border-top pt-3 mt-1">
                    <div class="d-flex justify-content-between" style="font-size:.88rem">
                        <span class="text-muted">Subtotal</span>
                        <span>Rp {{ number_format($order->subtotal,0,',','.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between" style="font-size:.88rem">
                        <span class="text-muted">Ongkos Kirim</span>
                        <span>Rp {{ number_format($order->shipping_cost,0,',','.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between fw-700 mt-2" style="font-size:1rem;color:#1e1b4b">
                        <span>Total</span>
                        <span style="color:#8b5cf6">{{ $order->formatted_total }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Input Resi --}}
        @if($order->isPaid() && !$order->shipment)
        <div class="card border-2" style="border-color:#8b5cf6!important">
            <div class="card-body">
                <h6 class="fw-700 mb-3" style="font-weight:700;color:#8b5cf6">🚚 Input Nomor Resi</h6>
                <form action="{{ route('seller.orders.ship', $order) }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label" style="font-size:.85rem;font-weight:600">Kurir</label>
                            <select name="courier" class="form-select" required>
                                <option value="">Pilih kurir</option>
                                @foreach(['JNE','J&T Express','SiCepat','AnterAja','Pos Indonesia','Ninja Express'] as $k)
                                    <option>{{ $k }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" style="font-size:.85rem;font-weight:600">Layanan</label>
                            <input type="text" name="service" class="form-control" placeholder="REG / YES / OKE">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label" style="font-size:.85rem;font-weight:600">No. Resi <span class="text-danger">*</span></label>
                            <input type="text" name="tracking_number" class="form-control" placeholder="Nomor resi pengiriman" required>
                        </div>
                    </div>
                    <button type="submit" class="btn text-white mt-3" style="background:linear-gradient(135deg,#8b5cf6,#ec4899)">
                        <i class="bi bi-truck me-1"></i> Tandai Sudah Dikirim
                    </button>
                </form>
            </div>
        </div>
        @endif

        {{-- Info Pengiriman (jika sudah ada resi) --}}
        @if($order->shipment)
        <div class="card" style="border-left:4px solid #14b8a6">
            <div class="card-body">
                <h6 class="fw-700 mb-3" style="font-weight:700;color:#14b8a6">🚚 Info Pengiriman</h6>
                <div class="row g-2" style="font-size:.88rem">
                    <div class="col-6"><span class="text-muted">Kurir</span><div class="fw-600">{{ $order->shipment->courier }} {{ $order->shipment->service }}</div></div>
                    <div class="col-6"><span class="text-muted">No. Resi</span><div class="fw-600">{{ $order->shipment->tracking_number }}</div></div>
                    <div class="col-6"><span class="text-muted">Dikirim</span><div class="fw-600">{{ $order->shipment->shipped_at?->format('d M Y') ?? '-' }}</div></div>
                    <div class="col-6"><span class="text-muted">Status</span><div class="fw-600">{{ ucfirst(str_replace('_',' ',$order->shipment->status)) }}</div></div>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Kanan: Info Pembeli --}}
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="fw-700 mb-3" style="font-weight:700">👤 Info Pembeli</h6>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-700"
                        style="width:44px;height:44px;background:linear-gradient(135deg,#8b5cf6,#ec4899);min-width:44px">
                        {{ strtoupper(substr($order->buyer->name,0,1)) }}
                    </div>
                    <div>
                        <div class="fw-600" style="font-size:.9rem">{{ $order->buyer->name }}</div>
                        <div class="text-muted" style="font-size:.78rem">{{ $order->buyer->email }}</div>
                        <div class="text-muted" style="font-size:.78rem">{{ $order->buyer->phone }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h6 class="fw-700 mb-3" style="font-weight:700">📍 Alamat Pengiriman</h6>
                <div style="font-size:.85rem">
                    <div class="fw-600">{{ $order->address->recipient_name }}</div>
                    <div class="text-muted">{{ $order->address->phone }}</div>
                    <div class="mt-1">{{ $order->address->full_address }}</div>
                    <div>{{ $order->address->city }}, {{ $order->address->province }} {{ $order->address->postal_code }}</div>
                </div>
            </div>
        </div>

        @if($order->payment)
        <div class="card">
            <div class="card-body">
                <h6 class="fw-700 mb-3" style="font-weight:700">💳 Info Pembayaran</h6>
                <div style="font-size:.85rem">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Metode</span>
                        <span class="fw-600">{{ str_replace('_',' ', ucfirst($order->payment->method ?? '-')) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Status</span>
                        <span class="badge bg-{{ $order->payment->isPaid()?'success':'warning' }} badge-status">
                            {{ $order->payment->isPaid()?'Lunas':'Belum' }}
                        </span>
                    </div>
                    @if($order->payment->paid_at)
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Waktu Bayar</span>
                        <span class="fw-600">{{ $order->payment->paid_at->format('d M Y') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <a href="{{ route('seller.orders.index') }}" class="btn btn-outline-secondary w-100 mt-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>
@endsection
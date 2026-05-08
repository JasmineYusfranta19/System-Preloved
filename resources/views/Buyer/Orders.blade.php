@extends('layouts.app')
@section('title', 'Pesanan Saya')

@section('content')
<div class="container mt-4">
    <h5 style="font-weight:800;color:var(--dark-blue)" class="mb-4">📦 Pesanan Saya</h5>

    @if($orders->isEmpty())
    <div class="text-center py-5">
        <div style="font-size:4rem">📭</div>
        <h6 class="mt-3" style="color:var(--dark-blue)">Belum ada pesanan</h6>
        <p class="text-muted" style="font-size:.88rem">Yuk mulai belanja!</p>
        <a href="{{ url('/products') }}" class="btn btn-main px-4 mt-2">Mulai Belanja</a>
    </div>
    @else
    @foreach($orders as $order)
    @php
    $statusColors = ['pending'=>'warning','paid'=>'info','processing'=>'primary','shipped'=>'secondary','completed'=>'success','cancelled'=>'danger'];
    $statusLabels = ['pending'=>'Menunggu Bayar','paid'=>'Dibayar','processing'=>'Diproses','shipped'=>'Dikirim','completed'=>'Selesai','cancelled'=>'Dibatalkan'];
    @endphp
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <div>
                    <div style="font-weight:700;font-size:.9rem;color:var(--dark-blue)">{{ $order->order_number }}</div>
                    <div style="font-size:.75rem;color:#9ca3af">{{ $order->created_at->format('d M Y, H:i') }}</div>
                </div>
                <span class="badge bg-{{ $statusColors[$order->status]??'secondary' }} badge-status px-3 py-2">
                    {{ $statusLabels[$order->status]??$order->status }}
                </span>
            </div>

            @foreach($order->items->take(2) as $item)
            <div class="d-flex align-items-center gap-3 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                @if($item->product?->primaryImage)
                    <img src="{{ $item->product->primaryImage->image_url }}" style="width:52px;height:52px;object-fit:cover;border-radius:.5rem;flex-shrink:0">
                @else
                    <div style="width:52px;height:52px;border-radius:.5rem;background:#f0f4ff;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0">👗</div>
                @endif
                <div class="flex-grow-1">
                    <div style="font-size:.88rem;font-weight:600;color:var(--dark-blue)">{{ Str::limit($item->product->name ?? '-', 40) }}</div>
                    <div style="font-size:.75rem;color:#9ca3af">{{ $item->quantity }}x · Rp {{ number_format($item->price,0,',','.') }}</div>
                </div>
            </div>
            @endforeach

            @if($order->items->count() > 2)
            <div class="text-muted mt-1" style="font-size:.78rem">+{{ $order->items->count()-2 }} produk lainnya</div>
            @endif

            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top flex-wrap gap-2">
                <div>
                    <span style="font-size:.8rem;color:#6b7280">Total Pembayaran</span>
                    <div style="font-weight:800;color:var(--dark-blue);font-size:1rem">{{ $order->formatted_total }}</div>
                </div>
                <div class="d-flex gap-2">
                    @if($order->isPending())
                    <a href="{{ route('orders.payment', $order) }}" class="btn btn-main btn-sm px-3">
                        Bayar Sekarang
                    </a>
                    @endif
                    @if($order->status === 'shipped' && !$order->shipment?->isDelivered())
                    <form action="{{ url('/orders/'.$order->id.'/confirm') }}" method="POST">
                        @csrf
                        <button class="btn btn-sm" style="background:var(--light-green);color:var(--dark-blue);font-weight:600">
                            Konfirmasi Terima
                        </button>
                    </form>
                    @endif
                    @if($order->isCompleted() && $order->items->whereNull('review')->count() > 0)
                    <a href="{{ url('/orders/'.$order->id.'/review') }}" class="btn btn-sm btn-outline-main">
                        Beri Ulasan
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <div class="mt-2">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
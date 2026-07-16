@extends('layouts.seller')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard Seller')

@section('content')

{{-- Greeting --}}
<div class="mb-4">
    <h5 class="fw-700 mb-1" style="font-weight:700;color:#8C2438">
        Halo, {{ auth()->user()->name }}! 👋
    </h5>
    <p class="text-muted mb-0" style="font-size:.88rem">Berikut ringkasan toko kamu hari ini.</p>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    @php
    $cards = [
        ['label'=>'Total Produk',    'value'=>$stats['total_products'],  'icon'=>'box-seam',    'bg'=>'#8C2438', 'emoji'=>'📦'],
        ['label'=>'Produk Aktif',    'value'=>$stats['active_products'], 'icon'=>'check-circle','bg'=>'#8C2438', 'emoji'=>'✅'],
        ['label'=>'Total Pesanan',   'value'=>$stats['total_orders'],    'icon'=>'bag-check',   'bg'=>'#8C2438', 'emoji'=>'🛍️'],
        ['label'=>'Perlu Diproses',  'value'=>$stats['pending_orders'],  'icon'=>'clock',       'bg'=>'#8C2438', 'emoji'=>'⏳'],
        ['label'=>'Total Ulasan',    'value'=>$stats['total_reviews'],   'icon'=>'star',        'bg'=>'#8C2438', 'emoji'=>'⭐'],
        ['label'=>'Total Pendapatan','value'=>'Rp '.number_format($stats['total_revenue'],0,',','.'), 'icon'=>'cash-stack','bg'=>'#8C2438', 'emoji'=>'💰'],
    ];
    @endphp

    @foreach($cards as $card)
    <div class="col-sm-6 col-lg-4">
        <div class="card stat-card h-100" style="background:{{ $card['bg'] }}">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="{{ isset($card['text_dark']) ? 'text-dark' : 'text-white' }} opacity-75 mb-1" style="font-size:.78rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em">
                            {{ $card['label'] }}
                        </p>
                        <h4 class="{{ isset($card['text_dark']) ? 'text-dark' : 'text-white' }} fw-800 mb-0" style="font-weight:800;font-size:1.4rem">{{ $card['value'] }}</h4>
                    </div>
                    <div style="font-size:2rem;opacity:.8">{{ $card['emoji'] }}</div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row g-4">
    {{-- Pesanan Terbaru --}}
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-700 mb-0" style="font-weight:700;color:#8C2438">🛍️ Pesanan Terbaru</h6>
                    <a href="{{ route('seller.orders.index') }}" class="btn btn-sm"
                        style="background:#FFF8F9;color:#8C2438;font-weight:600;font-size:.78rem">Lihat Semua</a>
                </div>

                @forelse($recentOrders as $order)
                <div class="d-flex align-items-center gap-3 py-2 border-bottom">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-700"
                        style="width:40px;height:40px;min-width:40px;background:linear-gradient(135deg,#8C2438,#FCE8EA);font-size:.85rem">
                        {{ strtoupper(substr($order->buyer->name,0,1)) }}
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-600" style="font-size:.88rem;color:#8C2438">{{ $order->buyer->name }}</div>
                        <div class="text-muted" style="font-size:.75rem">{{ $order->order_number }} · {{ $order->items->count() }} item</div>
                    </div>
                    <div class="text-end">
                        <div class="fw-700" style="font-size:.88rem;color:#8C2438">{{ $order->formatted_total }}</div>
                        @php
                        $badgeStyle = [
                            'pending'    => 'background:#ff9800;color:white',
                            'paid'       => 'background:#2196f3;color:white',
                            'processing' => 'background:#4caf50;color:white',
                            'shipped'    => 'background:#9c27b0;color:white',
                            'completed'  => 'background:#009688;color:white',
                            'cancelled'  => 'background:#f44336;color:white',
                            'refunded'   => 'background:#343a40;color:white',
                        ];
                        $style = $badgeStyle[$order->status] ?? 'background:#6c757d;color:white';
                        @endphp
                        <span class="badge badge-status" style="{{ $style }}">{{ $order->status }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted">
                    <div style="font-size:2.5rem">📭</div>
                    <p class="mt-2 mb-0" style="font-size:.85rem">Belum ada pesanan masuk</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Produk Terlaris --}}
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-700 mb-0" style="font-weight:700;color:#8C2438">🔥 Produk Terlaris</h6>
                    <a href="{{ route('seller.products.index') }}" class="btn btn-sm"
                        style="background:#FFF8F9;color:#8C2438;font-weight:600;font-size:.78rem">Kelola</a>
                </div>

                @forelse($topProducts as $i => $product)
                <div class="d-flex align-items-center gap-3 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div class="fw-800 text-center" style="width:24px;font-size:1rem">
                        {{ $i===0?'🥇':($i===1?'🥈':($i===2?'🥉':'#'.($i+1))) }}
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-600" style="font-size:.85rem;color:#8C2438">{{ Str::limit($product->name,30) }}</div>
                        <div class="text-muted" style="font-size:.75rem">{{ $product->order_items_count }} terjual</div>
                    </div>
                    <div class="fw-700" style="font-size:.82rem;color:#8C2438">{{ $product->formatted_price }}</div>
                </div>
                @empty
                <div class="text-center py-4 text-muted">
                    <div style="font-size:2.5rem">📦</div>
                    <p class="mt-2 mb-0" style="font-size:.85rem">Belum ada produk</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
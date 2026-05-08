@extends('layouts.seller')
@section('title', 'Pesanan Masuk')
@section('page-title', '🛍️ Pesanan Masuk')

@section('content')
{{-- Filter --}}
<div class="card mb-4">
    <div class="card-body py-3">
        <form action="{{ route('seller.orders.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    @foreach(['pending'=>'Menunggu','paid'=>'Dibayar','processing'=>'Diproses','shipped'=>'Dikirim','completed'=>'Selesai','cancelled'=>'Dibatalkan'] as $v=>$l)
                        <option value="{{ $v }}" {{ request('status')===$v?'selected':'' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto d-flex gap-2">
                <button type="submit" class="btn" style="background:#364C84;color:white">Filter</button>
                <a href="{{ route('seller.orders.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Orders --}}
<div class="card">
    <div class="card-body p-0">
        @if($orders->isEmpty())
            <div class="text-center py-5 text-muted">
                <div style="font-size:3.5rem">📭</div>
                <h6 class="mt-3">Belum ada pesanan</h6>
                <p style="font-size:.85rem">Pesanan dari pembeli akan muncul di sini.</p>
            </div>
        @else
        <div class="table-responsive">
            <table class="table mb-0">
                <thead style="background:#f9fafb">
                    <tr>
                        <th class="ps-4">No. Pesanan</th>
                        <th>Pembeli</th>
                        <th>Produk</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                        <th class="pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    @php
                    $statusColors = ['pending'=>'warning','paid'=>'info','processing'=>'primary','shipped'=>'secondary','completed'=>'success','cancelled'=>'danger','refunded'=>'dark'];
                    $statusLabels = ['pending'=>'Menunggu','paid'=>'Dibayar','processing'=>'Diproses','shipped'=>'Dikirim','completed'=>'Selesai','cancelled'=>'Batal'];
                    @endphp
                    <tr>
                        <td class="ps-4">
                            <div class="fw-600" style="font-size:.82rem;color:#1e1b4b">{{ $order->order_number }}</div>
                            <div class="text-muted" style="font-size:.72rem">{{ $order->created_at->format('d M Y') }}</div>
                        </td>
                        <td>
                            <div class="fw-600" style="font-size:.85rem">{{ $order->buyer->name }}</div>
                            <div class="text-muted" style="font-size:.75rem">{{ $order->buyer->phone }}</div>
                        </td>
                        <td style="font-size:.82rem">
                            @foreach($order->items->take(2) as $item)
                                <div>{{ Str::limit($item->product->name ?? '-', 28) }}</div>
                            @endforeach
                            @if($order->items->count() > 2)
                                <div class="text-muted">+{{ $order->items->count()-2 }} lainnya</div>
                            @endif
                        </td>
                        <td class="fw-700" style="color:#364C84;font-size:.88rem">{{ $order->formatted_total }}</td>
                        <td>
                            @if($order->payment)
                            <span class="badge bg-{{ $order->payment->isPaid()?'success':'warning' }} badge-status">
                                {{ $order->payment->isPaid()?'Lunas':'Belum Bayar' }}
                            </span>
                            @else
                                <span class="text-muted" style="font-size:.78rem">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $statusColors[$order->status]??'secondary' }} badge-status">
                                {{ $statusLabels[$order->status]??$order->status }}
                            </span>
                        </td>
                        <td class="pe-4">
                            <a href="{{ route('seller.orders.show', $order) }}" class="btn btn-sm" style="background:#364C84;color:#E7F1A8;font-size:.78rem">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-top">{{ $orders->links() }}</div>
        @endif
    </div>
</div>
@endsection
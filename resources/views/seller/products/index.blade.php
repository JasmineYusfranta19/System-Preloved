@extends('layouts.seller')
@section('title', 'Produk Saya')
@section('page-title', '📦 Produk Saya')

@section('content')
{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-muted mb-0" style="font-size:.88rem">Kelola semua produk yang kamu jual.</p>
    </div>
    <a href="{{ route('seller.products.create') }}" class="btn text-white" style="background:linear-gradient(135deg,#70020F,#FFA6B9 )">
        <i class="bi bi-plus-lg me-1"></i> Tambah Produk
    </a>
</div>

{{-- Filter --}}
<div class="card mb-4">
    <div class="card-body py-3">
        <form action="{{ route('seller.products.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-6">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="🔍 Cari nama produk...">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status')==='active'?'selected':'' }}>Aktif</option>
                    <option value="inactive" {{ request('status')==='inactive'?'selected':'' }}>Nonaktif</option>
                    <option value="sold" {{ request('status')==='sold'?'selected':'' }}>Terjual</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1" style="background:#70020F;border-color:#70020F">Filter</button>
                <a href="{{ route('seller.products.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card">
    <div class="card-body p-0">
        @if($products->isEmpty())
            <div class="text-center py-5 text-muted">
                <div style="font-size:3.5rem">📦</div>
                <h6 class="mt-3">Belum ada produk</h6>
                <p style="font-size:.85rem">Mulai jual pakaian preloved kamu sekarang!</p>
                <a href="{{ route('seller.products.create') }}" class="btn text-white" style="background:linear-gradient(135deg,#70020F,#FFA6B9)">
                    + Tambah Produk Pertama
                </a>
            </div>
        @else
        <div class="table-responsive">
            <table class="table mb-0">
                <thead style="background:#f9fafb">
                    <tr>
                        <th class="ps-4">Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Kondisi</th>
                        <th>Status</th>
                        <th class="pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                @if($product->primaryImage)
                                    <img src="{{ $product->primaryImage->image_url }}" alt=""
                                        style="width:48px;height:48px;object-fit:cover;border-radius:.5rem;">
                                @else
                                    <div style="width:48px;height:48px;border-radius:.5rem;background:#f3f4f6;display:flex;align-items:center;justify-content:center;font-size:1.4rem">👗</div>
                                @endif
                                <div>
                                    <div class="fw-600" style="font-size:.88rem;color:#1e1b4b">{{ Str::limit($product->name,35) }}</div>
                                    <div class="text-muted" style="font-size:.75rem">{{ $product->brand ?? '-' }} · {{ $product->size ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:.85rem">{{ $product->category->name ?? '-' }}</td>
                        <td class="fw-600" style="color:#70020F;font-size:.88rem">{{ $product->formatted_price }}</td>
                        <td>
                            <span class="fw-600" style="font-size:.88rem;color:{{ $product->stock > 0 ? '#10b981' : '#ef4444' }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td>
                            @php $cLabel = ['new'=>'Baru','like_new'=>'Seperti Baru','good'=>'Bagus','fair'=>'Cukup']; @endphp
                            <span style="font-size:.8rem;color:#6b7280">{{ $cLabel[$product->condition] ?? '-' }}</span>
                        </td>
                        <td>
                            @php $sc = ['active'=>['success','Aktif'],  'inactive'=>['secondary','Nonaktif'], 'sold'=>['warning','Terjual']]; @endphp
                            <span class="badge bg-{{ $sc[$product->status][0] ?? 'secondary' }} badge-status">
                                {{ $sc[$product->status][1] ?? $product->status }}
                            </span>
                        </td>
                        <td class="pe-4">
                            <div class="d-flex gap-1">
                                <a href="{{ route('seller.products.edit', $product) }}" class="btn btn-sm" style="background:#f5f3ff;color:#8b5cf6;font-size:.78rem">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('seller.products.destroy', $product) }}" method="POST"
                                    onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm" style="background:#fff1f2;color:#ef4444;font-size:.78rem">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-top">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
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
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 style="font-weight:700;color:var(--dark-blue);margin:0">📍 Alamat Pengiriman</h6>
                            <button type="button" class="btn btn-sm btn-outline-main"
                                data-bs-toggle="modal" data-bs-target="#modalTambahAlamat">
                                <i class="bi bi-plus-lg me-1"></i> Tambah Alamat
                            </button>
                        </div>

                        @if($addresses->isEmpty())
                            <div class="alert alert-warning border-0 rounded-3" style="font-size:.85rem">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Belum ada alamat. Klik <strong>Tambah Alamat</strong> untuk menambahkan.
                            </div>
                        @else
                            @foreach($addresses as $address)
                            <div class="mb-3">
                                <div class="addr-card" id="addrCard_{{ $address->id }}"
                                    style="border:2px solid {{ $address->is_default ? 'var(--dark-blue)' : '#dde8f8' }};border-radius:.75rem;padding:1rem;cursor:pointer;transition:.2s"
                                    onclick="selectAddress({{ $address->id }})">
                                    <div class="d-flex align-items-start gap-3">
                                        <input class="form-check-input mt-1" type="radio" name="address_id"
                                            value="{{ $address->id }}" id="addr_{{ $address->id }}"
                                            {{ $address->is_default ? 'checked' : '' }} required>
                                        <div class="flex-grow-1">
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
                                        {{-- Tombol Edit & Hapus --}}
                                        <div class="d-flex gap-1" onclick="event.stopPropagation()">
                                            <button type="button"
                                                class="btn btn-sm"
                                                style="background:#f0f4ff;color:var(--dark-blue);font-size:.75rem;padding:.2rem .5rem"
                                                onclick="editAlamat({{ $address->id }}, '{{ $address->label }}', '{{ $address->recipient_name }}', '{{ $address->phone }}', '{{ addslashes($address->full_address) }}', '{{ $address->city }}', '{{ $address->province }}', '{{ $address->postal_code }}', {{ $address->is_default ? 'true' : 'false' }})">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form action="{{ url('/profile/address/'.$address->id.'/delete') }}" method="POST"
                                                onsubmit="return confirm('Hapus alamat ini?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm"
                                                    style="background:#fff1f2;color:#ef4444;font-size:.75rem;padding:.2rem .5rem">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
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
                        Pembayaran diproses melalui Midtrans setelah konfirmasi pesanan.
                    </div>
                    <button type="submit" class="btn btn-main w-100 py-2" {{ $addresses->isEmpty() ? 'disabled' : '' }}>
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

{{-- ══ Modal Tambah Alamat ══ --}}
<div class="modal fade" id="modalTambahAlamat" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:500px">
        <div class="modal-content" style="border-radius:1rem;border:none;overflow:hidden">
            <div style="background:linear-gradient(135deg,var(--dark-blue),#4a6bb5);padding:1.25rem 1.5rem;color:white">
                <div class="d-flex justify-content-between align-items-center">
                    <span style="font-weight:700">📍 Tambah Alamat Baru</span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
            </div>
            <div class="p-4">
                <form action="{{ url('/profile/address') }}" method="POST">
                    @csrf
                    <input type="hidden" name="redirect" value="{{ url('/checkout') }}">
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label" style="font-size:.82rem;font-weight:600;color:var(--dark-blue)">Label</label>
                            <input type="text" name="label" class="form-control" placeholder="Rumah / Kantor" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label" style="font-size:.82rem;font-weight:600;color:var(--dark-blue)">Nama Penerima</label>
                            <input type="text" name="recipient_name" class="form-control" placeholder="Nama lengkap" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="font-size:.82rem;font-weight:600;color:var(--dark-blue)">No. HP</label>
                            <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxxxx" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="font-size:.82rem;font-weight:600;color:var(--dark-blue)">Alamat Lengkap</label>
                            <textarea name="full_address" class="form-control" rows="2" placeholder="Jl. ..., RT/RW, Kelurahan" required></textarea>
                        </div>
                        <div class="col-6">
                            <label class="form-label" style="font-size:.82rem;font-weight:600;color:var(--dark-blue)">Kota</label>
                            <input type="text" name="city" class="form-control" placeholder="Jakarta Selatan" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label" style="font-size:.82rem;font-weight:600;color:var(--dark-blue)">Provinsi</label>
                            <input type="text" name="province" class="form-control" placeholder="DKI Jakarta" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label" style="font-size:.82rem;font-weight:600;color:var(--dark-blue)">Kode Pos</label>
                            <input type="text" name="postal_code" class="form-control" placeholder="12345" required>
                        </div>
                        <div class="col-6 d-flex align-items-end">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_default" id="isDefault" value="1">
                                <label class="form-check-label" for="isDefault" style="font-size:.85rem">Jadikan alamat utama</label>
                            </div>
                        </div>
                        <div class="col-12 d-flex gap-2 mt-1">
                            <button type="button" class="btn btn-outline-main flex-grow-1" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-main flex-grow-1">Simpan Alamat</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ══ Modal Edit Alamat ══ --}}
<div class="modal fade" id="modalEditAlamat" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:500px">
        <div class="modal-content" style="border-radius:1rem;border:none;overflow:hidden">
            <div style="background:linear-gradient(135deg,var(--dark-blue),#4a6bb5);padding:1.25rem 1.5rem;color:white">
                <div class="d-flex justify-content-between align-items-center">
                    <span style="font-weight:700">✏️ Edit Alamat</span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
            </div>
            <div class="p-4">
                <form id="formEditAlamat" action="" method="POST">
                    @csrf @method('PUT')
                    <input type="hidden" name="redirect" value="{{ url('/checkout') }}">
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label" style="font-size:.82rem;font-weight:600;color:var(--dark-blue)">Label</label>
                            <input type="text" name="label" id="editLabel" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label" style="font-size:.82rem;font-weight:600;color:var(--dark-blue)">Nama Penerima</label>
                            <input type="text" name="recipient_name" id="editRecipient" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="font-size:.82rem;font-weight:600;color:var(--dark-blue)">No. HP</label>
                            <input type="text" name="phone" id="editPhone" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="font-size:.82rem;font-weight:600;color:var(--dark-blue)">Alamat Lengkap</label>
                            <textarea name="full_address" id="editAddress" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="col-6">
                            <label class="form-label" style="font-size:.82rem;font-weight:600;color:var(--dark-blue)">Kota</label>
                            <input type="text" name="city" id="editCity" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label" style="font-size:.82rem;font-weight:600;color:var(--dark-blue)">Provinsi</label>
                            <input type="text" name="province" id="editProvince" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label" style="font-size:.82rem;font-weight:600;color:var(--dark-blue)">Kode Pos</label>
                            <input type="text" name="postal_code" id="editPostal" class="form-control" required>
                        </div>
                        <div class="col-6 d-flex align-items-end">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_default" id="editIsDefault" value="1">
                                <label class="form-check-label" for="editIsDefault" style="font-size:.85rem">Jadikan utama</label>
                            </div>
                        </div>
                        <div class="col-12 d-flex gap-2 mt-1">
                            <button type="button" class="btn btn-outline-main flex-grow-1" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-main flex-grow-1">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function selectAddress(id) {
    document.querySelectorAll('.addr-card').forEach(e => {
        e.style.borderColor = '#dde8f8';
    });
    document.getElementById('addrCard_' + id).style.borderColor = 'var(--dark-blue)';
    document.getElementById('addr_' + id).checked = true;
}

function editAlamat(id, label, recipient, phone, address, city, province, postal, isDefault) {
    document.getElementById('formEditAlamat').action = '/profile/address/' + id;
    document.getElementById('editLabel').value     = label;
    document.getElementById('editRecipient').value = recipient;
    document.getElementById('editPhone').value     = phone;
    document.getElementById('editAddress').value   = address;
    document.getElementById('editCity').value      = city;
    document.getElementById('editProvince').value  = province;
    document.getElementById('editPostal').value    = postal;
    document.getElementById('editIsDefault').checked = isDefault;

    new bootstrap.Modal(document.getElementById('modalEditAlamat')).show();
}
</script>
@endpush
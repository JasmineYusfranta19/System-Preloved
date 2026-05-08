@extends('layouts.seller')
@section('title', 'Buat Toko')
@section('page-title', '🏪 Buat Toko')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <div style="font-size:3rem">🏪</div>
                    <h5 class="fw-700 mt-2" style="font-weight:700;color:#1e1b4b">Buat Toko Kamu</h5>
                    <p class="text-muted" style="font-size:.88rem">Lengkapi profil toko untuk mulai berjualan</p>
                </div>

                <form action="{{ route('seller.shop.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" style="font-weight:600;font-size:.88rem">Nama Toko <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror"
                            placeholder="Nama unik tokomu" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-weight:600;font-size:.88rem">Deskripsi Toko <span class="text-danger">*</span></label>
                        <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror"
                            placeholder="Ceritakan tentang toko dan jenis produk kamu...">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label" style="font-weight:600;font-size:.88rem">Kota <span class="text-danger">*</span></label>
                            <input type="text" name="city" value="{{ old('city') }}" class="form-control" placeholder="Jakarta Selatan" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label" style="font-weight:600;font-size:.88rem">Provinsi <span class="text-danger">*</span></label>
                            <input type="text" name="province" value="{{ old('province') }}" class="form-control" placeholder="DKI Jakarta" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <label class="form-label" style="font-weight:600;font-size:.88rem">Logo Toko</label>
                            <input type="file" name="logo" class="form-control" accept="image/*">
                            <div class="text-muted mt-1" style="font-size:.75rem">JPG/PNG maks 2MB</div>
                        </div>
                        <div class="col-6">
                            <label class="form-label" style="font-weight:600;font-size:.88rem">Banner Toko</label>
                            <input type="file" name="banner" class="form-control" accept="image/*">
                            <div class="text-muted mt-1" style="font-size:.75rem">JPG/PNG maks 4MB</div>
                        </div>
                    </div>

                    <button type="submit" class="btn text-white w-100 py-2" style="background:linear-gradient(135deg,#8b5cf6,#ec4899);font-weight:700">
                        🚀 Buat Toko Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
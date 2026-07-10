@extends('layouts.seller')
@section('title', 'Edit Toko')
@section('page-title', '✏️ Edit Profil Toko')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('seller.shop.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label" style="font-weight:600;font-size:.88rem">Nama Toko <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $shop->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-weight:600;font-size:.88rem">Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="description" rows="3" class="form-control">{{ old('description', $shop->description) }}</textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label" style="font-weight:600;font-size:.88rem">Kota</label>
                            <input type="text" name="city" value="{{ old('city', $shop->city) }}" class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="form-label" style="font-weight:600;font-size:.88rem">Provinsi</label>
                            <input type="text" name="province" value="{{ old('province', $shop->province) }}" class="form-control">
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <label class="form-label" style="font-weight:600;font-size:.88rem">Logo Baru</label>
                            @if($shop->logo)
                                <img src="{{ Storage::url($shop->logo) }}" alt="Logo" class="d-block mb-2" style="height:60px;border-radius:.5rem">
                            @endif
                            <input type="file" name="logo" class="form-control" accept="image/*">
                        </div>
                        <div class="col-6">
                            <label class="form-label" style="font-weight:600;font-size:.88rem">Banner Baru</label>
                            @if($shop->banner)
                                <img src="{{ Storage::url($shop->banner) }}" alt="Banner" class="d-block mb-2" style="height:60px;width:100%;object-fit:cover;border-radius:.5rem">
                            @endif
                            <input type="file" name="banner" class="form-control" accept="image/*">
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <a href="{{ route('seller.dashboard') }}" class="btn btn-outline-secondary px-4">Batal</a>
                        <button type="submit" class="btn text-white flex-grow-1" style="background:linear-gradient(135deg,#70020F,#FFA6B9);font-weight:700">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
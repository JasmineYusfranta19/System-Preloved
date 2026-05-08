@extends('layouts.seller')
@section('title', 'Tambah Produk')
@section('page-title', '➕ Tambah Produk')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">
                {{-- Info Produk --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="fw-700 mb-4" style="font-weight:700;color:#1e1b4b">📝 Informasi Produk</h6>

                            <div class="mb-3">
                                <label class="form-label fw-600" style="font-size:.88rem;font-weight:600">Nama Produk <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Contoh: Kemeja Flannel Kotak-kotak">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-600" style="font-size:.88rem;font-weight:600">Kategori <span class="text-danger">*</span></label>
                                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $cat)
                                            <optgroup label="{{ $cat->name }}">
                                                @foreach($cat->children as $child)
                                                    <option value="{{ $child->id }}" {{ old('category_id')==$child->id?'selected':'' }}>
                                                        {{ $child->name }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-600" style="font-size:.88rem;font-weight:600">Brand</label>
                                    <input type="text" name="brand" value="{{ old('brand') }}" class="form-control" placeholder="Uniqlo, Zara, dll">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-600" style="font-size:.88rem;font-weight:600">Deskripsi <span class="text-danger">*</span></label>
                                <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Jelaskan kondisi, ukuran, bahan, dan detail lain...">{{ old('description') }}</textarea>
                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label fw-600" style="font-size:.88rem;font-weight:600">Harga (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" name="price" value="{{ old('price') }}" class="form-control @error('price') is-invalid @enderror" placeholder="50000" min="1000">
                                    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-600" style="font-size:.88rem;font-weight:600">Stok <span class="text-danger">*</span></label>
                                    <input type="number" name="stock" value="{{ old('stock',1) }}" class="form-control" min="1">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-600" style="font-size:.88rem;font-weight:600">Ukuran</label>
                                    <select name="size" class="form-select">
                                        <option value="">-- Pilih --</option>
                                        @foreach(['XS','S','M','L','XL','XXL','XXXL'] as $s)
                                            <option value="{{ $s }}" {{ old('size')===$s?'selected':'' }}>{{ $s }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-600" style="font-size:.88rem;font-weight:600">Warna</label>
                                    <input type="text" name="color" value="{{ old('color') }}" class="form-control" placeholder="Hitam, Putih...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kondisi & Gender --}}
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="fw-700 mb-3" style="font-weight:700;color:#1e1b4b">✨ Kondisi</h6>
                            @foreach(['new'=>['Baru','Belum pernah dipakai'],'like_new'=>['Seperti Baru','1-2x pakai, mulus'],'good'=>['Bagus','Sedikit tanda pemakaian'],'fair'=>['Cukup','Ada tanda pemakaian']] as $val=>$label)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="condition" value="{{ $val }}" id="cond_{{ $val }}"
                                    {{ old('condition','good')===$val?'checked':'' }}>
                                <label class="form-check-label" for="cond_{{ $val }}" style="font-size:.88rem">
                                    <span class="fw-600">{{ $label[0] }}</span>
                                    <span class="text-muted"> — {{ $label[1] }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="fw-700 mb-3" style="font-weight:700;color:#1e1b4b">👤 Target Gender</h6>
                            @foreach(['men'=>'Pria 👨','women'=>'Wanita 👩','unisex'=>'Unisex 🧑','kids'=>'Anak-anak 🧒'] as $val=>$label)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="gender" value="{{ $val }}" id="gen_{{ $val }}"
                                    {{ old('gender','unisex')===$val?'checked':'' }}>
                                <label class="form-check-label" for="gen_{{ $val }}" style="font-size:.88rem">{{ $label }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Upload Foto --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="fw-700 mb-1" style="font-weight:700;color:#1e1b4b">📸 Foto Produk <span class="text-danger">*</span></h6>
                            <p class="text-muted mb-3" style="font-size:.8rem">Upload 1-5 foto. Foto pertama jadi foto utama. Maks 2MB per foto.</p>
                            <input type="file" name="images[]" id="images" class="form-control @error('images') is-invalid @enderror"
                                accept="image/*" multiple onchange="previewImages(this)">
                            @error('images')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div id="preview" class="d-flex gap-2 flex-wrap mt-3"></div>
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="col-12 d-flex gap-3 justify-content-end">
                    <a href="{{ route('seller.products.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                    <button type="submit" class="btn text-white px-5" style="background:linear-gradient(135deg,#8b5cf6,#ec4899)">
                        <i class="bi bi-check-lg me-1"></i> Simpan Produk
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImages(input) {
    const preview = document.getElementById('preview');
    preview.innerHTML = '';
    [...input.files].forEach((file, i) => {
        const reader = new FileReader();
        reader.onload = e => {
            const div = document.createElement('div');
            div.style.cssText = 'position:relative;';
            div.innerHTML = `
                <img src="${e.target.result}" style="width:90px;height:90px;object-fit:cover;border-radius:.6rem;border:2px solid ${i===0?'#8b5cf6':'#e5e7eb'}">
                ${i===0?'<span style="position:absolute;bottom:4px;left:4px;background:#8b5cf6;color:white;font-size:.6rem;padding:1px 5px;border-radius:4px">Utama</span>':''}
            `;
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}
</script>
@endpush
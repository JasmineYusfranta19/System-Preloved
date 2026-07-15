@extends('layouts.seller')
@section('title', 'Tambah Produk')
@section('page-title', '➕ Tambah Produk')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
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
                                    placeholder="Contoh: Adidas Adizero">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-600" style="font-size:.88rem;font-weight:600">Kategori <span class="text-danger">*</span></label>
                                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                        <option value="">- Pilih Kategori -</option>
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
                                    <input type="text" name="brand" value="{{ old('brand') }}" class="form-control" placeholder="Contoh: Adidas">
                                </div>
                            </div>

                            {{-- DESKRIPSI - minimal 1000 karakter dengan live counter --}}
                            <div class="mb-3">
                                <label class="form-label fw-600" style="font-size:.88rem;font-weight:600">
                                    Deskripsi <span class="text-danger">*</span>
                                </label>
                                <textarea name="description" id="description" rows="4"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Jelaskan detail produk secara lengkap"
                                    oninput="updateCharCount(this)">{{ old('description') }}</textarea>
                                <div class="d-flex justify-content-end mt-1">
                                    <small id="charCount" class="fw-600 text-muted">0 / 1000</small>
                                </div>
                            </div>

                            <div class="row g-3">
                                {{-- HARGA - dengan format ribuan otomatis --}}
                                <div class="col-md-3">
                                    <label class="form-label fw-600" style="font-size:.88rem;font-weight:600">Harga (Rp) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" inputmode="numeric" id="price_display"
                                            class="form-control @error('price') is-invalid @enderror"
                                            placeholder="50.000" value="{{ old('price') ? number_format(old('price'),0,',','.') : '' }}"
                                            oninput="formatPrice(this)">
                                        <input type="hidden" name="price" id="price_raw" value="{{ old('price') }}">
                                    </div>
                                    <small class="text-muted" id="price_preview"></small>
                                    @error('price')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-600" style="font-size:.88rem;font-weight:600">Stok <span class="text-danger">*</span></label>
                                    <input type="number" name="stock" value="{{ old('stock',1) }}" class="form-control" min="1">
                                </div>

                                {{-- UKURAN - fleksibel untuk semua jenis produk fashion --}}
                                <div class="col-md-3">
                                    <label class="form-label fw-600" style="font-size:.88rem;font-weight:600">Ukuran</label>
                                    <select name="size" class="form-select">
                                        <option value="">- Pilih Ukuran -</option>
                                        <optgroup label="Pakaian (Huruf)">
                                            @foreach(['XXS','XS','S','M','L','XL','XXL','XXXL'] as $s)
                                                <option value="{{ $s }}" {{ old('size')===$s?'selected':'' }}>{{ $s }}</option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="Celana / Pinggang (Angka)">
                                            @foreach(['26','27','28','29','30','31','32','33','34','36','38','40'] as $s)
                                                <option value="{{ $s }}" {{ old('size')===$s?'selected':'' }}>{{ $s }}</option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="Sepatu (EU)">
                                            @foreach(['35','36','37','38','39','40','41','42','43','44','45'] as $s)
                                                <option value="Sepatu {{ $s }}" {{ old('size')==='Sepatu '.$s?'selected':'' }}>EU {{ $s }}</option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="Lainnya">
                                            <option value="All Size" {{ old('size')==='All Size'?'selected':'' }}>All Size</option>
                                            <option value="One Size" {{ old('size')==='One Size'?'selected':'' }}>One Size (Tas/Aksesoris)</option>
                                        </optgroup>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-600" style="font-size:.88rem;font-weight:600">Warna</label>
                                    <input type="text" name="color" value="{{ old('color') }}" class="form-control" placeholder="Contoh: Putih">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KONDISI - 3 opsi saja --}}
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="fw-700 mb-3" style="font-weight:700;color:#1e1b4b">✨ Kondisi</h6>
                            <select name="condition" class="form-select @error('condition') is-invalid @enderror">
                                <option value="">- Pilih Kondisi -</option>
                                <option value="new">Baru</option>
                                <option value="like_new">Like New</option>
                                <option value="second">Second</option>
                            </select>
                            @error('condition')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- GENDER - dropdown, 3 opsi saja --}}
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="fw-700 mb-3" style="font-weight:700;color:#1e1b4b">👤 Target Gender</h6>
                            <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                                <option value="">- Pilih Target -</option>
                                <option value="men"   {{ old('gender')==='men'?'selected':'' }}>Pria</option>
                                <option value="women" {{ old('gender')==='women'?'selected':'' }}>Wanita</option>
                                <option value="unisex"{{ old('gender','unisex')==='unisex'?'selected':'' }}>Unisex</option>
                            </select>
                            @error('gender')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- Upload Foto dengan Preview --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="fw-700 mb-1" style="font-weight:700;color:#1e1b4b">📸 Foto Produk <span class="text-danger">*</span></h6>
                            <p class="text-muted mb-3" style="font-size:.8rem">Upload 1-5 foto. Foto pertama jadi foto utama. Maks 2MB per foto.</p>
                            <input type="file" name="images[]" id="images" class="form-control @error('images') is-invalid @enderror"
                                accept="image/*" multiple onchange="previewImages(this)">
                            @error('images')<div class="invalid-feedback">{{ $message }}</div>@enderror

                            {{-- Preview grid --}}
                            <div id="preview" class="d-flex gap-3 flex-wrap mt-3"></div>
                            <small id="previewHint" class="text-muted d-none mt-2 d-block">
                                💡 Klik tanda ✕ pada foto untuk menghapusnya dari daftar upload sebelum disimpan.
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="col-12 d-flex gap-3 justify-content-end">
                    <a href="{{ route('seller.products.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                    <button type="submit" class="btn text-white px-5" style="background:#B8324A">
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
function updateCharCount(el) {
    const count = el.value.length;
    const remaining = 1000 - count;
    const counter = document.getElementById('charCount');
    counter.textContent = `${count} / 1000`;
 
    if (remaining <= 0) {
        counter.className = 'fw-600 text-danger';
    } else if (remaining <= 100) {
        counter.className = 'fw-600 text-warning';
    } else {
        counter.className = 'fw-600 text-muted';
    }
}
document.addEventListener('DOMContentLoaded', () => {
    updateCharCount(document.getElementById('description'));
});
 
function formatPrice(el) {
    let raw = el.value.replace(/\D/g, '');
    document.getElementById('price_raw').value = raw;
    el.value = raw ? new Intl.NumberFormat('id-ID').format(raw) : '';
    document.getElementById('price_preview').textContent = raw ? `Rp ${new Intl.NumberFormat('id-ID').format(raw)},-` : '';
}
 
let selectedFiles = [];
 
function previewImages(input) {
    selectedFiles = [...input.files];
    renderPreview();
}
 
function renderPreview() {
    const preview = document.getElementById('preview');
    preview.innerHTML = '';
 
    selectedFiles.forEach((file, i) => {
        const reader = new FileReader();
        reader.onload = e => {
            const div = document.createElement('div');
            div.style.cssText = 'position:relative;';
            div.innerHTML = `
                <img src="${e.target.result}" style="width:100px;height:100px;object-fit:cover;border-radius:.6rem;border:2px solid #e5e7eb">
                <button type="button" onclick="removeImage(${i})"
                    style="position:absolute;top:-6px;right:-6px;width:22px;height:22px;border-radius:50%;background:#ef4444;color:white;border:2px solid white;font-size:.7rem;line-height:1;cursor:pointer;">
                    ✕
                </button>
            `;
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}
 
function removeImage(index) {
    selectedFiles.splice(index, 1);
    const dt = new DataTransfer();
    selectedFiles.forEach(file => dt.items.add(file));
    document.getElementById('images').files = dt.files;
    renderPreview();
}
 
 
</script>
@endpush
@extends('layouts.seller')
@section('title', 'Edit Produk')
@section('page-title', '✏️ Edit Produk')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <form action="{{ route('seller.products.update', $product) }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf
            @method('PUT')

            <div class="row g-4">
                {{-- Info Produk --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="fw-700 mb-4" style="font-weight:700;color:#1e1b4b">📝 Informasi Produk</h6>

                            <div class="mb-3">
                                <label class="form-label fw-600" style="font-size:.88rem;font-weight:600">Nama Produk <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control @error('name') is-invalid @enderror">
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
                                                    <option value="{{ $child->id }}" {{ old('category_id', $product->category_id)==$child->id?'selected':'' }}>
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
                                    <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" class="form-control">
                                </div>
                            </div>

                            {{-- DESKRIPSI --}}
                            <div class="mb-3">
                                <label class="form-label fw-600" style="font-size:.88rem;font-weight:600">
                                    Deskripsi <span class="text-danger">*</span>
                                    <span class="text-muted fw-normal">(maksimal 1000 karakter)</span>
                                </label>
                                <textarea name="description" id="description" rows="8" maxlength="1000"
                                    class="form-control @error('description') is-invalid @enderror"
                                    oninput="updateCharCount(this)">{{ old('description', $product->description) }}</textarea>
                                <div class="d-flex justify-content-between mt-1">
                                    @error('description')
                                        <div class="invalid-feedback d-block mb-0">{{ $message }}</div>
                                    @else
                                        <small class="text-muted">Deskripsi yang detail membantu produk lebih cepat terjual</small>
                                    @enderror
                                    <small id="charCount" class="fw-600 text-muted">0 / 1000</small>
                                </div>
                            </div>

                            <div class="row g-3">
                                {{-- HARGA --}}
                                <div class="col-md-3">
                                    <label class="form-label fw-600" style="font-size:.88rem;font-weight:600">Harga (Rp) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" inputmode="numeric" id="price_display"
                                            class="form-control @error('price') is-invalid @enderror"
                                            value="{{ number_format(old('price', $product->price), 0, ',', '.') }}"
                                            oninput="formatPrice(this)">
                                        <input type="hidden" name="price" id="price_raw" value="{{ old('price', $product->price) }}">
                                    </div>
                                    <small class="text-muted" id="price_preview"></small>
                                    @error('price')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-600" style="font-size:.88rem;font-weight:600">Stok <span class="text-danger">*</span></label>
                                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="form-control" min="0">
                                </div>

                                {{-- UKURAN --}}
                                <div class="col-md-3">
                                    <label class="form-label fw-600" style="font-size:.88rem;font-weight:600">Ukuran</label>
                                    @php $currentSize = old('size', $product->size); @endphp
                                    <select name="size" class="form-select">
                                        <option value="">- Pilih Ukuran -</option>
                                        <optgroup label="Pakaian (Huruf)">
                                            @foreach(['XXS','XS','S','M','L','XL','XXL','XXXL'] as $s)
                                                <option value="{{ $s }}" {{ $currentSize===$s?'selected':'' }}>{{ $s }}</option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="Celana / Pinggang (Angka)">
                                            @foreach(['26','27','28','29','30','31','32','33','34','36','38','40'] as $s)
                                                <option value="{{ $s }}" {{ $currentSize===$s?'selected':'' }}>{{ $s }}</option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="Sepatu (EU)">
                                            @foreach(['35','36','37','38','39','40','41','42','43','44','45'] as $s)
                                                <option value="Sepatu {{ $s }}" {{ $currentSize==='Sepatu '.$s?'selected':'' }}>EU {{ $s }}</option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="Lainnya">
                                            <option value="All Size" {{ $currentSize==='All Size'?'selected':'' }}>All Size</option>
                                            <option value="One Size" {{ $currentSize==='One Size'?'selected':'' }}>One Size (Tas/Aksesoris)</option>
                                        </optgroup>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-600" style="font-size:.88rem;font-weight:600">Warna</label>
                                    <input type="text" name="color" value="{{ old('color', $product->color) }}" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KONDISI --}}
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="fw-700 mb-3" style="font-weight:700;color:#1e1b4b">✨ Kondisi</h6>
                            @foreach([
                                'new'      => ['Baru', 'Belum pernah dipakai, dengan/tanpa tag'],
                                'like_new' => ['Like New', 'Beberapa kali pakai, kondisi sangat mulus'],
                                'second'   => ['Second', 'Sudah sering dipakai, ada tanda pemakaian wajar'],
                            ] as $val=>$label)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="condition" value="{{ $val }}" id="cond_{{ $val }}"
                                    {{ old('condition', $product->condition)===$val?'checked':'' }}>
                                <label class="form-check-label" for="cond_{{ $val }}" style="font-size:.88rem">
                                    <span class="fw-600">{{ $label[0] }}</span>
                                    <span class="text-muted"> — {{ $label[1] }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- GENDER --}}
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="fw-700 mb-3" style="font-weight:700;color:#1e1b4b">👤 Target Gender</h6>
                            <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                                <option value="">- Pilih Target -</option>
                                <option value="men"   {{ old('gender', $product->gender)==='men'?'selected':'' }}>Pria</option>
                                <option value="women" {{ old('gender', $product->gender)==='women'?'selected':'' }}>Wanita</option>
                                <option value="unisex"{{ old('gender', $product->gender)==='unisex'?'selected':'' }}>Unisex</option>
                            </select>
                            @error('gender')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- STATUS --}}
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="fw-700 mb-3" style="font-weight:700;color:#1e1b4b">🟢 Status Produk</h6>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="active"   {{ old('status', $product->status)==='active'?'selected':'' }}>Aktif (tampil di toko)</option>
                                <option value="inactive" {{ old('status', $product->status)==='inactive'?'selected':'' }}>Nonaktif (disembunyikan)</option>
                            </select>
                            @error('status')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- FOTO EXISTING - dengan opsi hapus --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="fw-700 mb-1" style="font-weight:700;color:#1e1b4b">📸 Foto Saat Ini</h6>
                            <p class="text-muted mb-3" style="font-size:.8rem">Centang foto yang ingin dihapus. Foto dengan label "Utama" akan otomatis digantikan foto lain jika dihapus.</p>

                            <div class="d-flex gap-3 flex-wrap">
                                @forelse($product->images as $image)
                                <div style="position:relative;">
                                    <img src="{{ $image->image_url }}"
                                         style="width:100px;height:100px;object-fit:cover;border-radius:.6rem;border:2px solid {{ $image->is_primary ? '#8b5cf6' : '#e5e7eb' }}">
                                    @if($image->is_primary)
                                        <span style="position:absolute;bottom:4px;left:4px;background:#8b5cf6;color:white;font-size:.6rem;padding:1px 5px;border-radius:4px">Utama</span>
                                    @endif
                                    <label style="position:absolute;top:-6px;right:-6px;width:22px;height:22px;border-radius:50%;background:white;border:2px solid #ef4444;display:flex;align-items:center;justify-content:center;cursor:pointer;">
                                        <input type="checkbox" name="delete_images[]" value="{{ $image->id }}"
                                               class="d-none" onchange="this.parentElement.style.background = this.checked ? '#ef4444' : 'white'">
                                        <span style="color:#ef4444;font-size:.7rem;">✕</span>
                                    </label>
                                </div>
                                @empty
                                <p class="text-muted" style="font-size:.85rem">Belum ada foto.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Upload Foto Baru --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="fw-700 mb-1" style="font-weight:700;color:#1e1b4b">➕ Tambah Foto Baru</h6>
                            <p class="text-muted mb-3" style="font-size:.8rem">Opsional. Upload maks 5 foto tambahan, maks 2MB per foto.</p>
                            <input type="file" name="images[]" id="images" class="form-control @error('images') is-invalid @enderror"
                                accept="image/*" multiple onchange="previewImages(this)">
                            @error('images')<div class="invalid-feedback">{{ $message }}</div>@enderror

                            <div id="preview" class="d-flex gap-3 flex-wrap mt-3"></div>
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="col-12 d-flex gap-3 justify-content-end">
                    <a href="{{ route('seller.products.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                    <button type="submit" class="btn text-white px-5" style="background:linear-gradient(135deg,#8b5cf6,#ec4899)">
                        <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
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
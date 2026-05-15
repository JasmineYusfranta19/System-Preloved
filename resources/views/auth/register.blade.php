<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — Preloved.id</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background:#364C84; min-height:100vh; display:flex; align-items:center; padding: 2rem 0; }
        .auth-card { border:none; border-radius:1.25rem; box-shadow:0 20px 60px rgba(0,0,0,.3); }
        .form-control, .form-select { border-radius:.65rem; border:1.5px solid #e5e7eb; padding:.65rem 1rem; font-size:.9rem; }
        .form-control:focus, .form-select:focus { border-color:#364C84 ; box-shadow:0 0 0 3px rgba(54, 76, 132, 0.15); }
        .btn-register { background:linear-gradient(135deg,#364C84 , #95B1EE ); border:none; color:white; padding:.7rem; border-radius:.65rem; font-weight:700; width:100%; font-size:1rem; }
        .btn-register:hover { opacity:.9; color:white; }
        .role-card { border:2px solid #e5e7eb; border-radius:.75rem; padding:1rem; cursor:pointer; transition:.2s; text-align:center; }
        .role-card:hover { border-color:#364C84 ; background:#f5f3ff; }
        .role-card.selected { border-color:#364C84 ; background:#f5f3ff; }
        .role-card input { display:none; }
        .role-emoji { font-size:2rem; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="auth-card bg-white p-4 p-md-5">
                <div class="text-center mb-4">
                    <span style="font-size:2.5rem">👗</span>
                    <h4 class="fw-800 mt-2 mb-1" style="font-weight:800;color:#1e1b4b">Buat Akun Baru</h4>
                    <p class="text-muted" style="font-size:.88rem">Bergabung dengan ribuan pengguna Preloved.id</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger border-0 rounded-3 py-2 mb-3" style="font-size:.85rem">
                        <i class="bi bi-exclamation-circle me-1"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    {{-- Pilih Role --}}
                    <div class="mb-4">
                        <label class="form-label fw-600" style="font-weight:600;font-size:.88rem">Saya ingin</label>
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="role-card {{ old('role') === 'buyer' || !old('role') ? 'selected' : '' }}" id="label-buyer">
                                    <input type="radio" name="role" value="buyer" {{ old('role','buyer') === 'buyer' ? 'checked' : '' }}>
                                    <div class="role-emoji">🛍️</div>
                                    <div class="fw-600 mt-1" style="font-size:.9rem">Belanja</div>
                                    <div class="text-muted" style="font-size:.75rem">Cari & beli produk</div>
                                </label>
                            </div>
                            <div class="col-6">
                                <label class="role-card {{ old('role') === 'seller' ? 'selected' : '' }}" id="label-seller">
                                    <input type="radio" name="role" value="seller" {{ old('role') === 'seller' ? 'checked' : '' }}>
                                    <div class="role-emoji">🏪</div>
                                    <div class="fw-600 mt-1" style="font-size:.9rem">Berjualan</div>
                                    <div class="text-muted" style="font-size:.75rem">Jual pakaian preloved</div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-weight:600;font-size:.88rem">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Nama kamu" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-weight:600;font-size:.88rem">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="email@kamu.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-weight:600;font-size:.88rem">No. HP / WhatsApp</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="08xxxxxxxxxx" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label" style="font-weight:600;font-size:.88rem">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Min. 8 karakter" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label" style="font-weight:600;font-size:.88rem">Ulangi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-register mb-3">Daftar Sekarang 🚀</button>
                </form>

                <p class="text-center mb-0" style="font-size:.88rem">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" style="color:#364C84 ;font-weight:600;text-decoration:none">Masuk</a>
                </p>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll('input[name="role"]').forEach(radio => {
    radio.addEventListener('change', () => {
        document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
        radio.closest('.role-card').classList.add('selected');
    });
});
</script>
</body>
</html>
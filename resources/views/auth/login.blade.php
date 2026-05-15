<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Preloved.id</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: #FFFDF5 ; min-height: 100vh; display: flex; align-items: center; }
        .auth-card { border: none; border-radius: 1.25rem; box-shadow: 0 20px 60px rgba(0,0,0,.3); overflow: hidden; }
        .auth-left { background: linear-gradient(160deg, #364C84 , #95B1EE ); padding: 3rem 2rem; color: white; }
        .auth-left h2 { font-weight: 800; font-size: 2rem; }
        .auth-right { padding: 2.5rem; }
        .form-control { border-radius: .65rem; border: 1.5px solid #e5e7eb; padding: .65rem 1rem; }
        .form-control:focus { border-color: #364C84 ; box-shadow: 0 0 0 3px rgba(139,92,246,.15); }
        .btn-login { background: linear-gradient(135deg, #364C84 , #95B1EE ); border: none; color: white; padding: .7rem; border-radius: .65rem; font-weight: 700; width: 100%; font-size: 1rem; }
        .btn-login:hover { opacity: .9; color: white; }
        .divider { color: #9ca3af; font-size: .85rem; text-align: center; position: relative; }
        .divider::before, .divider::after { content: ''; position: absolute; top: 50%; width: 42%; height: 1px; background: #e5e7eb; }
        .divider::before { left: 0; } .divider::after { right: 0; }
        .floating-emoji { font-size: 3rem; animation: float 3s ease-in-out infinite; }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-8">
            <div class="auth-card">
                <div class="row g-0">
                    {{-- Kiri --}}
                    <div class="col-md-5 auth-left d-flex flex-column justify-content-center">
                        <div class="floating-emoji text-center mb-3">👗</div>
                        <h2 class="text-center">Preloved.id</h2>
                        <p class="text-center opacity-75 mt-2">Platform jual beli pakaian preloved terpercaya di Indonesia</p>
                        <div class="mt-4">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span>✅</span><small>100% aman & terpercaya</small>
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span>🚀</span><small>Pengiriman ke seluruh Indonesia</small>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span>💸</span><small>Harga terjangkau, kualitas oke</small>
                            </div>
                        </div>
                    </div>

                    {{-- Kanan --}}
                    <div class="col-md-7 auth-right bg-white">
                        <h4 class="fw-800 mb-1" style="font-weight:800;color:#1e1b4b">Selamat Datang! 👋</h4>
                        <p class="text-muted mb-4" style="font-size:.88rem">Masuk ke akun kamu</p>

                        @if($errors->any())
                            <div class="alert alert-danger border-0 rounded-3 py-2 mb-3" style="font-size:.85rem">
                                <i class="bi bi-exclamation-circle me-1"></i>
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-600" style="font-weight:600;font-size:.88rem">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0" style="border-radius:.65rem 0 0 .65rem;border:1.5px solid #e5e7eb"><i class="bi bi-envelope text-muted"></i></span>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control border-start-0 ps-0"
                                        style="border-radius:0 .65rem .65rem 0"
                                        placeholder="email@kamu.com" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-600" style="font-weight:600;font-size:.88rem">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0" style="border-radius:.65rem 0 0 .65rem;border:1.5px solid #e5e7eb"><i class="bi bi-lock text-muted"></i></span>
                                    <input type="password" name="password" id="password"
                                        class="form-control border-start-0 ps-0"
                                        style="border-radius:0 .65rem .65rem 0"
                                        placeholder="••••••••" required>
                                    <button type="button" class="input-group-text bg-white" style="border-radius:0 .65rem .65rem 0;border:1.5px solid #e5e7eb;border-left:none;cursor:pointer"
                                        onclick="togglePwd()"><i class="bi bi-eye" id="eyeIcon"></i></button>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label" for="remember" style="font-size:.85rem">Ingat saya</label>
                                </div>
                            </div>
                            <button type="submit" class="btn-login mb-3">Masuk</button>
                        </form>

                        <div class="divider my-3">atau</div>

                        <p class="text-center mt-3 mb-0" style="font-size:.88rem">
                            Belum punya akun?
                            <a href="{{ route('register') }}" style="color:#364C84  ;font-weight:600;text-decoration:none">Daftar sekarang</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePwd() {
    const p = document.getElementById('password');
    const i = document.getElementById('eyeIcon');
    p.type = p.type === 'password' ? 'text' : 'password';
    i.className = p.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
</body>
</html>
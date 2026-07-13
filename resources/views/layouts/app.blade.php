<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Preloved.id') — Jual Beli Pakaian Preloved</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --dark-blue:   #8C2438; /* Primary Dark */
            --light-blue:  #FCE8EA; /* Soft Pink / Bg Soft */
            --light-green: #E85D75; /* Accent */
            --base-white:  #FFFFFF; /* White main background */
            --primary:      #B8324A; /* Solid Primary */
        }
        body { background: var(--base-white); font-family: 'Segoe UI', sans-serif; color: #2D2D2D; }

        /* Navbar */
        .navbar-main {
            background: var(--dark-blue);
            padding: .75rem 0;
            position: sticky;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            box-shadow: 0 2px 12px rgba(140,36,56,.2);
        }
        .navbar-brand-text { font-weight: 800; font-size: 1.3rem; color: white; text-decoration: none; }
        .navbar-brand-text span { color: var(--light-blue); }
        .nav-search .form-control {
            border: none; border-radius: .5rem 0 0 .5rem;
            font-size: .88rem; background: white;
            width: 320px;
        }
        .nav-search .btn-search {
            background: var(--light-blue); border: none;
            border-radius: 0 .5rem .5rem 0; color: var(--dark-blue);
            font-weight: 700; padding: .45rem .9rem;
        }
        .nav-link-custom { color: rgba(255,255,255,.85) !important; font-size: .88rem; font-weight: 500; }
        .nav-link-custom:hover { color: var(--light-blue) !important; }
        .btn-navbar-login {
            background: transparent; border: 1.5px solid var(--light-blue);
            color: white; border-radius: .5rem; font-size: .85rem;
            padding: .35rem .9rem; font-weight: 600;
        }
        .btn-navbar-login:hover { background: var(--light-blue); color: var(--dark-blue); }
        .btn-navbar-register {
            background: var(--light-blue); border: none;
            color: var(--dark-blue); border-radius: .5rem; font-size: .85rem;
            padding: .35rem .9rem; font-weight: 700;
        }
        .btn-navbar-register:hover { background: #ffd2d9; }
        .cart-badge { position: relative; }
        .cart-badge .badge { position: absolute; top: -6px; right: -6px; font-size: .6rem; }

        /* Cards */
        .product-card {
            border: 1px solid var(--light-blue); border-radius: .85rem;
            overflow: hidden; transition: .2s; background: white;
            height: 100%;
        }
        .product-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(140,36,56,.12); border-color: var(--light-green); }
        .product-card img { width: 100%; height: 220px; object-fit: cover; }
        .product-card .card-body { padding: .85rem; }
        .product-price { color: var(--primary); font-weight: 700; font-size: 1rem; }
        .product-badge {
            font-size: .68rem; padding: .2em .55em; border-radius: 2rem;
            background: var(--light-blue); color: var(--dark-blue); font-weight: 600;
        }
        .product-badge.sold { background: #fde8e8; color: #c0392b; }

        /* Section titles */
        .section-title { font-weight: 800; color: var(--dark-blue); font-size: 1.3rem; }
        .section-subtitle { color: #6b7280; font-size: .88rem; }

        /* Category pills */
        .cat-pill {
            border: 1.5px solid var(--light-blue); border-radius: 2rem;
            padding: .4rem 1rem; font-size: .82rem; font-weight: 600;
            color: var(--dark-blue); background: white; cursor: pointer;
            text-decoration: none; transition: .2s; white-space: nowrap;
        }
        .cat-pill:hover, .cat-pill.active {
            background: var(--dark-blue); color: white; border-color: var(--dark-blue);
        }

        /* Footer */
        .footer-main { background: var(--dark-blue); color: rgba(255,255,255,.8); padding: 2.5rem 0 1.5rem; margin-top: 4rem; }
        .footer-main h6 { color: var(--light-blue); font-weight: 700; margin-bottom: 1rem; }
        .footer-main a { color: rgba(255,255,255,.65); text-decoration: none; font-size: .85rem; display: block; margin-bottom: .35rem; }
        .footer-main a:hover { color: var(--light-blue); }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,.1); margin-top: 1.5rem; padding-top: 1rem; font-size: .78rem; color: rgba(255,255,255,.4); }

        /* Misc */
        .btn-main { background: var(--primary); color: white; border: none; border-radius: .6rem; font-weight: 600; }
        .btn-main:hover { background: var(--dark-blue); color: white; }
        .btn-outline-main { border: 1.5px solid var(--primary); color: var(--dark-blue); border-radius: .6rem; font-weight: 600; background: transparent; }
        .btn-outline-main:hover { background: var(--primary); color: white; }
        .form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(184,50,74,.15); }
        .card { border: 1px solid var(--light-blue); border-radius: .85rem; }

        /* Mascot animations */
        .animate-float {
            animation: floating 3.5s ease-in-out infinite;
        }
        @keyframes floating {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- Navbar --}}
<nav class="navbar-main">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">

            {{-- Brand --}}
            <a href="{{ url('/') }}" class="navbar-brand-text">
                👗 Preloved<span>.</span>id
            </a>

            {{-- Search --}}
            <form action="{{ url('/products') }}" method="GET" class="nav-search d-flex d-none d-md-flex">
                <input type="text" name="search" class="form-control" placeholder="Cari produk, brand, kategori..." value="{{ request('search') }}">
                <button type="submit" class="btn-search"><i class="bi bi-search"></i></button>
            </form>

            {{-- Nav Actions --}}
            <div class="d-flex align-items-center gap-2">
                @auth
                    {{-- Cart --}}
                    <a href="{{ url('/cart') }}" class="nav-link-custom cart-badge px-2">
                        <i class="bi bi-bag" style="font-size:1.2rem"></i>
                        @if(auth()->user()->carts()->count() > 0)
                            <span class="badge bg-danger rounded-pill">{{ auth()->user()->carts()->count() }}</span>
                        @endif
                    </a>

                    {{-- User dropdown --}}
                    <div class="dropdown">
                        <button class="btn btn-navbar-login dropdown-toggle" data-bs-toggle="dropdown">
                            {{ auth()->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @if(auth()->user()->isSeller())
                                <li><a class="dropdown-item" href="{{ route('seller.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard Seller</a></li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-left me-2"></i>Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-navbar-login">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-navbar-register">Daftar</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- Flash Messages (Floating Toast) --}}
@if(session('success') || session('error'))
<div id="flash-toast" class="position-fixed" style="top:20px;right:20px;z-index:9999;min-width:280px;max-width:360px">
    @if(session('success'))
        <div class="d-flex align-items-center gap-2 bg-white border-start border-success border-4 rounded-3 shadow-lg p-3 mb-2">
            <i class="bi bi-check-circle-fill text-success"></i>
            <span class="text-dark fw-semibold flex-grow-1" style="font-size:.82rem">{{ session('success') }}</span>
            <button onclick="this.closest('.d-flex').remove()" class="btn-close btn-close-sm ms-auto" style="width:.8em;height:.8em"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="d-flex align-items-center gap-2 bg-white border-start border-danger border-4 rounded-3 shadow-lg p-3 mb-2">
            <i class="bi bi-exclamation-circle-fill text-danger"></i>
            <span class="text-dark fw-semibold flex-grow-1" style="font-size:.82rem">{{ session('error') }}</span>
            <button onclick="this.closest('.d-flex').remove()" class="btn-close btn-close-sm ms-auto" style="width:.8em;height:.8em"></button>
        </div>
    @endif
</div>
<script>
    setTimeout(() => {
        const t = document.getElementById('flash-toast');
        if (t) { t.style.transition = 'opacity .5s'; t.style.opacity = '0'; setTimeout(() => t.remove(), 500); }
    }, 4500);
</script>
@endif

{{-- Content --}}
@yield('content')

{{-- Footer --}}
<footer class="footer-main">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5 style="color:white;font-weight:800">👗 Preloved.id</h5>
                <p style="font-size:.85rem;color:rgba(255,255,255,.6);margin-top:.5rem">
                    Platform jual beli pakaian preloved terpercaya di Indonesia. Hemat, stylish, ramah lingkungan.
                </p>
            </div>
            <div class="col-md-2">
                <h6>Belanja</h6>
                <a href="{{ url('/products') }}">Semua Produk</a>
                <a href="{{ url('/products?gender=women') }}">Wanita</a>
                <a href="{{ url('/products?gender=men') }}">Pria</a>
                <a href="{{ url('/products?gender=kids') }}">Anak-anak</a>
            </div>
            <div class="col-md-2">
                <h6>Jual</h6>
                <a href="{{ route('register') }}">Daftar Seller</a>
                <a href="{{ route('seller.dashboard') }}">Dashboard</a>
            </div>
            <div class="col-md-4">
                <h6>Tentang</h6>
                <a href="#">Cara Kerja</a>
                <a href="#">Syarat & Ketentuan</a>
                <a href="#">Kebijakan Privasi</a>
                <a href="#">Hubungi Kami</a>
            </div>
        </div>
        <div class="footer-bottom text-center">
            © {{ date('Y') }} Preloved.id — Made with ❤️ in Indonesia
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
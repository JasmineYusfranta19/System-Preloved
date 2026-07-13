<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Preloved Seller</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #8C2438;      /* Primary Dark */
            --sidebar-hover: #701c2c;   /* Darker Red */
            --accent-blue: #FCE8EA;     /* Soft Pink / Bg Soft */
            --accent-dark: #8C2438;
            --accent-green: #E85D75;    /* Accent */
            --accent-base: #FFF8F9;
            --primary: #B8324A;         /* Solid Primary */
        }
        body { background: #FFF8F9; font-family: 'Segoe UI', sans-serif; }
        .sidebar {
            width: 250px; 
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed; 
            top: 0; 
            left: 0; 
            z-index: 1010;
        }
        .sidebar-brand {
            padding: 1.5rem 1rem;
            background: linear-gradient(135deg, var(--sidebar-bg), var(--accent-green));
            font-size: 1.2rem; font-weight: 800; color: white;
            display: flex; align-items: center; gap: .5rem;
        }
        .sidebar-brand span { font-size: 1.5rem; }
        .nav-label {
            font-size: .65rem; font-weight: 700; letter-spacing: .1em;
            color: #FFDEE2; text-transform: uppercase;
            padding: 1rem 1.25rem .25rem;
        }
        .sidebar .nav-link {
            color: #ffdce1; padding: .6rem 1.25rem;
            border-radius: .5rem; margin: .1rem .75rem;
            display: flex; align-items: center; gap: .6rem;
            font-size: .88rem; transition: .2s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: var(--sidebar-hover); color: white;
        }
        .sidebar .nav-link i { font-size: 1rem; width: 1.2rem; text-align: center; }
        .main-content { margin-left: 250px; min-height: 100vh; background: #FFF8F9; }
        .topbar {
            background: white; 
            padding: .75rem 1.5rem;
            border-bottom: 1px solid var(--accent-blue);
            display: flex; 
            align-items: center; 
            justify-content: space-between;
            position: sticky; 
            top: 0; 
            z-index: 1020;
            box-shadow: 0 2px 8px rgba(140,36,56,.05);
        }
        .topbar-title { font-weight: 700; font-size: 1.1rem; color: var(--sidebar-bg); }
        .content-area { padding: 1.5rem; }
        .stat-card { border: none; border-radius: 1rem; overflow: hidden; transition: .2s; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(140,36,56,.15); }
        .table th { font-size: .78rem; text-transform: uppercase; letter-spacing: .05em; color: var(--sidebar-bg); font-weight: 600; }
        .table td { vertical-align: middle; font-size: .88rem; }
        .table thead tr { background: rgba(252,232,234,.4); }
        .badge-status { font-size: .72rem; padding: .3em .7em; border-radius: 2rem; }
        .alert { border: none; border-radius: .75rem; }
        .alert-success { background: var(--accent-blue); color: var(--sidebar-bg); }
        .alert-danger { background: #fde8e8; color: #9b1c1c; }
        .form-control, .form-select { border-radius: .6rem; border: 1.5px solid var(--accent-blue); font-size: .9rem; background: white; }
        .form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(184,50,74,.15); }
        .form-label { color: var(--sidebar-bg); font-weight: 600; font-size: .88rem; }
        .btn { border-radius: .6rem; font-weight: 600; font-size: .88rem; }
        .btn-primary { background: var(--primary); border-color: var(--primary); color: white; }
        .btn-primary:hover { background: var(--sidebar-bg); border-color: var(--sidebar-bg); color: white; }
        .btn-outline-primary { border-color: var(--primary); color: var(--primary); }
        .btn-outline-primary:hover { background: var(--primary); color: white; }
        .btn-outline-secondary { border-color: var(--accent-blue); color: var(--sidebar-bg); }
        .btn-outline-secondary:hover { background: var(--accent-blue); border-color: var(--accent-blue); color: var(--sidebar-bg); }
        .btn-success { background: var(--accent-green); border-color: var(--accent-green); color: white; }
        .btn-success:hover { background: #d04d64; border-color: #d04d64; color: white; }
        .card { border: none; border-radius: 1rem; box-shadow: 0 1px 8px rgba(140,36,56,.08); background: white; }
        .card-header { background: white; border-bottom: 1.5px solid var(--accent-blue); font-weight: 700; color: var(--sidebar-bg); border-radius: 1rem 1rem 0 0 !important; }
        .page-link { color: var(--sidebar-bg); border-color: var(--accent-blue); }
        .page-link:hover { background: var(--accent-blue); color: var(--sidebar-bg); border-color: var(--accent-blue); }
        .page-item.active .page-link { background: var(--primary); border-color: var(--primary); color: white; }
        h1,h2,h3,h4,h5,h6 { color: var(--sidebar-bg); }
        a { color: var(--sidebar-bg); }
        a:hover { color: var(--accent-green); }
        hr { border-color: var(--accent-blue); }
        .text-muted { color: #8e6c70 !important; }
    </style>
    @stack('styles')
</head>
<body>

{{-- Sidebar --}}
<div class="sidebar">
    <div class="sidebar-brand">
        <span>👗</span> Preloved<span style="color:var(--accent-green)">.</span>id
    </div>

    {{-- Info Toko --}}
    @if(auth()->user()->shop)
    <div class="px-3 py-3" style="border-bottom:1px solid rgba(255,222,226,.2)">
        <div class="d-flex align-items-center gap-2">
            @if(auth()->user()->shop->logo)
                <img src="{{ Storage::url(auth()->user()->shop->logo) }}"
                    style="width:36px;height:36px;border-radius:50%;object-fit:cover;flex-shrink:0">
            @else
                <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--accent-blue),var(--sidebar-bg));display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:.9rem;flex-shrink:0">
                    {{ strtoupper(substr(auth()->user()->shop->name,0,1)) }}
                </div>
            @endif
            <div style="overflow:hidden">
                <div style="color:white;font-size:.82rem;font-weight:600;line-height:1.2;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                    {{ auth()->user()->shop->name }}
                </div>
                <div style="color:#FFDEE2;font-size:.72rem">
                    {{ auth()->user()->name }}
                </div>
            </div>
        </div>
    </div>
    @endif

    <nav class="mt-2">
        <div class="nav-label">Menu Utama</div>
        <a href="{{ route('seller.dashboard') }}" class="nav-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('seller.products.index') }}" class="nav-link {{ request()->routeIs('seller.products.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Produk Saya
        </a>
        <a href="{{ route('seller.orders.index') }}" class="nav-link {{ request()->routeIs('seller.orders.*') ? 'active' : '' }}">
            <i class="bi bi-bag-check"></i> Pesanan Masuk
        </a>

        <div class="nav-label mt-2">Toko</div>
        <a href="{{ route('seller.shop.edit') }}" class="nav-link {{ request()->routeIs('seller.shop.edit') ? 'active' : '' }}">
            <i class="bi bi-shop"></i> Profil Toko
        </a>

        <div class="nav-label mt-2">Akun</div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-link w-100 border-0 text-start" style="background:none;cursor:pointer;">
                <i class="bi bi-box-arrow-left"></i> Keluar
            </button>
        </form>
    </nav>
</div>

{{-- Main Content --}}
<div class="main-content">
    <div class="topbar">
        <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ url('/') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-globe"></i> Lihat Toko
            </a>

            @if(auth()->user()->shop && auth()->user()->shop->logo)
                <img src="{{ Storage::url(auth()->user()->shop->logo) }}"
                    style="width:36px;height:36px;border-radius:50%;object-fit:cover;flex-shrink:0; border: 1.5px solid var(--accent-blue);">
            @else
                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                    style="width:36px;height:36px;background:linear-gradient(135deg,var(--sidebar-bg),var(--accent-blue));font-size:.85rem;flex-shrink:0;">
                    {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                </div>
            @endif
        </div>
    </div>

    <div class="content-area">
        @foreach(['success'=>'success','error'=>'danger','info'=>'info'] as $key => $type)
            @if(session($key))
                <div class="alert alert-{{ $type }} alert-dismissible fade show mb-3" role="alert">
                    <i class="bi bi-{{ $key === 'success' ? 'check-circle' : ($key === 'error' ? 'x-circle' : 'info-circle') }} me-2"></i>
                    {{ session($key) }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        @endforeach

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
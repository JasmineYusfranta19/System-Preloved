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
            --sidebar-bg: #364C84;
            --sidebar-hover: #2a3d6e;
            --accent-blue: #95B1EE;
            --accent-dark: #364C84;
            --accent-green: #E7F1A8;
            --accent-base: #FFFDF5;
        }
        body { background: #FFFDF5; font-family: 'Segoe UI', sans-serif; }
        .sidebar {
            width: 250px; min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed; top: 0; left: 0; z-index: 100;
        }
        .sidebar-brand {
            padding: 1.5rem 1rem;
            background: linear-gradient(135deg, #364C84, #95B1EE);
            font-size: 1.2rem; font-weight: 800; color: white;
            display: flex; align-items: center; gap: .5rem;
        }
        .sidebar-brand span { font-size: 1.5rem; }
        .nav-label {
            font-size: .65rem; font-weight: 700; letter-spacing: .1em;
            color: #95B1EE; text-transform: uppercase;
            padding: 1rem 1.25rem .25rem;
        }
        .sidebar .nav-link {
            color: #c7d2fe; padding: .6rem 1.25rem;
            border-radius: .5rem; margin: .1rem .75rem;
            display: flex; align-items: center; gap: .6rem;
            font-size: .88rem; transition: .2s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: var(--sidebar-hover); color: white;
        }
        .sidebar .nav-link i { font-size: 1rem; width: 1.2rem; text-align: center; }
        .main-content { margin-left: 250px; min-height: 100vh; background: #FFFDF5; }
        .topbar {
            background: white; padding: .75rem 1.5rem;
            border-bottom: 1px solid #dce6f5;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 99;
        }
        .topbar-title { font-weight: 700; font-size: 1.1rem; color: #364C84; }
        .content-area { padding: 1.5rem; }
        .stat-card { border: none; border-radius: 1rem; overflow: hidden; transition: .2s; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(54,76,132,.15); }
        .table th { font-size: .78rem; text-transform: uppercase; letter-spacing: .05em; color: #364C84; font-weight: 600; }
        .table td { vertical-align: middle; font-size: .88rem; }
        .table thead tr { background: rgba(149,177,238,.15); }
        .badge-status { font-size: .72rem; padding: .3em .7em; border-radius: 2rem; }
        .alert { border: none; border-radius: .75rem; }
        .alert-success { background: #E7F1A8; color: #364C84; }
        .alert-danger { background: #fde8e8; color: #9b1c1c; }
        .form-control, .form-select { border-radius: .6rem; border: 1.5px solid #dce6f5; font-size: .9rem; background: white; }
        .form-control:focus, .form-select:focus { border-color: #364C84; box-shadow: 0 0 0 3px rgba(54,76,132,.15); }
        .form-label { color: #364C84; font-weight: 600; font-size: .88rem; }
        .btn { border-radius: .6rem; font-weight: 600; font-size: .88rem; }
        .btn-primary { background: #364C84; border-color: #364C84; color: white; }
        .btn-primary:hover { background: #2a3d6e; border-color: #2a3d6e; color: white; }
        .btn-outline-primary { border-color: #364C84; color: #364C84; }
        .btn-outline-primary:hover { background: #364C84; color: white; }
        .btn-outline-secondary { border-color: #95B1EE; color: #364C84; }
        .btn-outline-secondary:hover { background: #95B1EE; border-color: #95B1EE; color: white; }
        .btn-success { background: #E7F1A8; border-color: #E7F1A8; color: #364C84; }
        .btn-success:hover { background: #d9e994; border-color: #d9e994; color: #364C84; }
        .card { border: none; border-radius: 1rem; box-shadow: 0 1px 8px rgba(54,76,132,.08); background: white; }
        .card-header { background: white; border-bottom: 1.5px solid #dce6f5; font-weight: 700; color: #364C84; border-radius: 1rem 1rem 0 0 !important; }
        .page-link { color: #364C84; border-color: #dce6f5; }
        .page-link:hover { background: #95B1EE; color: white; border-color: #95B1EE; }
        .page-item.active .page-link { background: #364C84; border-color: #364C84; }
        h1,h2,h3,h4,h5,h6 { color: #364C84; }
        a { color: #364C84; }
        a:hover { color: #95B1EE; }
        hr { border-color: #dce6f5; }
        .text-muted { color: #7a92b8 !important; }
    </style>
    @stack('styles')
</head>
<body>

{{-- Sidebar --}}
<div class="sidebar">
    <div class="sidebar-brand">
        <span>👗</span> Preloved<span style="color:#E7F1A8">.</span>id
    </div>

    {{-- Info Toko --}}
    @if(auth()->user()->shop)
    <div class="px-3 py-3" style="border-bottom:1px solid rgba(149,177,238,.2)">
        <div class="d-flex align-items-center gap-2">
            @if(auth()->user()->shop->logo)
                <img src="{{ Storage::url(auth()->user()->shop->logo) }}"
                    style="width:36px;height:36px;border-radius:50%;object-fit:cover;flex-shrink:0">
            @else
                <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#95B1EE,#364C84);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:.9rem;flex-shrink:0">
                    {{ strtoupper(substr(auth()->user()->shop->name,0,1)) }}
                </div>
            @endif
            <div style="overflow:hidden">
                <div style="color:white;font-size:.82rem;font-weight:600;line-height:1.2;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                    {{ auth()->user()->shop->name }}
                </div>
                <div style="color:#95B1EE;font-size:.72rem">
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
            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                style="width:36px;height:36px;background:linear-gradient(135deg,#364C84,#95B1EE);font-size:.85rem;">
                {{ strtoupper(substr(auth()->user()->name,0,1)) }}
            </div>
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
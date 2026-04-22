<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — ReWear</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #1e1008;
            --sidebar-width: 250px;
            --accent: #c4786a;
            --gold: #b89a72;
        }
        body { font-family: 'Jost', sans-serif; background: #f8f4f1; }
        h1,h2,h3,.brand { font-family: 'Cormorant Garamond', serif; }

        /* Sidebar */
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
        }
        .sidebar-brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.7rem;
            color: #fff;
            padding: 1.5rem 1.5rem 1rem;
            border-bottom: 1px solid #3d2920;
            letter-spacing: .05em;
        }
        .sidebar-brand span { color: var(--accent); }
        .sidebar-nav { padding: 1rem 0; flex: 1; }
        .sidebar-label {
            font-size: .65rem;
            letter-spacing: .15em;
            text-transform: uppercase;
            color: #7a5c4e;
            padding: 1rem 1.5rem .3rem;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: .8rem;
            padding: .65rem 1.5rem;
            color: #c8b0a4;
            text-decoration: none;
            font-size: .88rem;
            letter-spacing: .03em;
            transition: all .2s;
        }
        .sidebar-link:hover, .sidebar-link.active {
            background: rgba(196,120,106,.15);
            color: #fff;
            border-left: 3px solid var(--accent);
        }
        .sidebar-link i { width: 18px; text-align: center; }

        /* Main */
        #main { margin-left: var(--sidebar-width); min-height: 100vh; }
        .topbar {
            background: #fff;
            border-bottom: 1px solid #ede5df;
            padding: .8rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .page-content { padding: 1.5rem; }

        /* Cards */
        .stat-card {
            border: none;
            border-radius: 6px;
            overflow: hidden;
            background: #fff;
        }
        .stat-card .stat-icon {
            width: 52px; height: 52px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
        }

        /* Table */
        .table { font-size: .88rem; }
        .table th { font-weight: 500; font-size: .78rem; text-transform: uppercase; letter-spacing: .06em; color: #7a5c4e; border-top: none; }

        /* Badges */
        .badge-pending   { background: #fff3cd; color: #856404; }
        .badge-confirmed { background: #cfe2ff; color: #084298; }
        .badge-shipped   { background: #d1ecf1; color: #0c5460; }
        .badge-delivered { background: #d4edda; color: #155724; }
        .badge-cancelled { background: #f8d7da; color: #842029; }

        .btn-accent { background: var(--accent); color: #fff; border: none; border-radius: 4px; }
        .btn-accent:hover { background: #b06658; color: #fff; }
        .alert { border-radius: 4px; }
    </style>
    @stack('styles')
</head>
<body>

{{-- Sidebar --}}
<div id="sidebar">
    <div class="sidebar-brand">Re<span>Wear</span> <small style="font-size:.65rem;color:#7a5c4e;display:block;margin-top:-6px">Admin Panel</small></div>

    <nav class="sidebar-nav">
        <div class="sidebar-label">Overview</div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fa fa-gauge-high"></i> Dashboard
        </a>

        <div class="sidebar-label">Catalogue</div>
        <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="fa fa-shirt"></i> Products
        </a>
        <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="fa fa-tags"></i> Categories
        </a>

        <div class="sidebar-label">Sales</div>
        <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fa fa-bag-shopping"></i> Orders
        </a>

        <div class="sidebar-label mt-3"></div>
        <a href="{{ route('shop.index') }}" class="sidebar-link" target="_blank">
            <i class="fa fa-store"></i> View Store
        </a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="sidebar-link w-100 text-start border-0 bg-transparent" style="cursor:pointer">
                <i class="fa fa-right-from-bracket"></i> Logout
            </button>
        </form>
    </nav>
</div>

{{-- Main --}}
<div id="main">
    <div class="topbar">
        <div>
            <h5 class="mb-0 fw-normal">@yield('title', 'Dashboard')</h5>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted" style="font-size:.85rem"><i class="fa fa-user-circle me-1"></i>{{ auth()->user()->name }}</span>
        </div>
    </div>

    <div class="page-content">
        @foreach(['success','error','warning','info'] as $type)
            @if(session($type))
                <div class="alert alert-{{ $type === 'error' ? 'danger' : $type }} alert-dismissible fade show">
                    {{ session($type) }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        @endforeach

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>

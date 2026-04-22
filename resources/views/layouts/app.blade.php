<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ReWear') — Women's Fashion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --blush:   #e8c4b8;
            --nude:    #f5ede8;
            --espresso:#2c1a12;
            --rose:    #c4786a;
            --gold:    #b89a72;
        }
        body { font-family: 'Jost', sans-serif; color: var(--espresso); background: #fdfaf8; }
        h1,h2,h3,.brand { font-family: 'Cormorant Garamond', serif; }

        /* Navbar */
        .navbar-rewear {
            background: #fff;
            border-bottom: 1px solid #f0e8e2;
            padding: 1rem 0;
        }
        .navbar-brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            color: var(--espresso) !important;
        }
        .navbar-brand span { color: var(--rose); }
        .nav-link { color: var(--espresso) !important; font-size: .9rem; letter-spacing: .05em; text-transform: uppercase; }
        .nav-link:hover { color: var(--rose) !important; }
        .btn-cart {
            background: var(--espresso);
            color: #fff !important;
            border-radius: 0;
            padding: .4rem 1.2rem;
            font-size: .85rem;
            letter-spacing: .08em;
        }
        .btn-cart:hover { background: var(--rose); }
        .cart-badge {
            background: var(--rose);
            color: #fff;
            border-radius: 50%;
            font-size: .7rem;
            padding: 1px 5px;
            vertical-align: super;
        }

        /* Buttons */
        .btn-rewear {
            background: var(--espresso);
            color: #fff;
            border-radius: 0;
            letter-spacing: .08em;
            text-transform: uppercase;
            font-size: .85rem;
            padding: .65rem 2rem;
            transition: background .25s;
        }
        .btn-rewear:hover { background: var(--rose); color: #fff; }
        .btn-outline-rewear {
            border: 1px solid var(--espresso);
            color: var(--espresso);
            background: transparent;
            border-radius: 0;
            letter-spacing: .08em;
            text-transform: uppercase;
            font-size: .85rem;
            padding: .6rem 1.8rem;
            transition: all .25s;
        }
        .btn-outline-rewear:hover { background: var(--espresso); color: #fff; }

        /* Product card */
        .product-card { border: none; border-radius: 0; overflow: hidden; transition: transform .3s; }
        .product-card:hover { transform: translateY(-4px); }
        .product-card .card-img-top { height: 320px; object-fit: cover; background: var(--nude); }
        .product-card .card-body { padding: 1rem 0; }
        .product-card .price { font-size: 1rem; color: var(--espresso); }
        .product-card .price .sale { color: var(--rose); font-weight: 600; }
        .product-card .price .original { text-decoration: line-through; color: #aaa; font-size: .85rem; }

        /* Badge */
        .badge-sale { background: var(--rose); color: #fff; font-size: .7rem; padding: 3px 8px; border-radius: 0; }

        /* Footer */
        footer { background: var(--espresso); color: #e0d4cc; padding: 3rem 0 1.5rem; }
        footer a { color: var(--blush); text-decoration: none; font-size: .85rem; }
        footer a:hover { color: #fff; }
        footer h6 { color: #fff; letter-spacing: .1em; text-transform: uppercase; font-size: .8rem; margin-bottom: 1.2rem; }
        .footer-brand { font-family: 'Cormorant Garamond', serif; font-size: 1.8rem; color: #fff; }

        /* Alerts */
        .alert { border-radius: 0; border: none; font-size: .9rem; }

        /* Placeholder image */
        .img-placeholder { background: var(--nude); display:flex; align-items:center; justify-content:center; color: var(--blush); }
    </style>
    @stack('styles')
</head>
<body>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-rewear sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('shop.index') }}">Re<span>Wear</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav mx-auto gap-3">
                <li class="nav-item"><a class="nav-link" href="{{ route('shop.index') }}">Shop</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('shop.index', ['category' => 'dresses']) }}">Dresses</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('shop.index', ['category' => 'tops']) }}">Tops</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('shop.index', ['category' => 'outerwear']) }}">Outerwear</a></li>
            </ul>
            <div class="d-flex align-items-center gap-3">
                @guest
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-rewear">Join</a>
                @endguest
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="fa fa-gauge-high"></i> Admin</a>
                    @endif
                    <a href="{{ route('orders.index') }}" class="nav-link">My Orders</a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="nav-link btn btn-link p-0" style="text-decoration:none">Logout</button>
                    </form>
                @endauth
                <a href="{{ route('cart.index') }}" class="btn btn-cart">
                    <i class="fa fa-bag-shopping"></i>
                    @php $cartCount = count(session('cart', [])); @endphp
                    @if($cartCount > 0)<span class="cart-badge">{{ $cartCount }}</span>@endif
                </a>
            </div>
        </div>
    </div>
</nav>

{{-- Flash messages --}}
<div class="container mt-3">
    @foreach(['success','error','warning','info'] as $type)
        @if(session($type))
            <div class="alert alert-{{ $type === 'error' ? 'danger' : $type }} alert-dismissible fade show">
                {{ session($type) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    @endforeach
</div>

{{-- Page Content --}}
@yield('content')

{{-- Footer --}}
<footer class="mt-5">
    <div class="container">
        <div class="row g-4 pb-4">
            <div class="col-md-4">
                <div class="footer-brand mb-2">ReWear</div>
                <p style="font-size:.85rem;color:#b8a89e;">Curated women's fashion for the modern wardrobe. Quality, style, and confidence delivered to your door.</p>
            </div>
            <div class="col-md-2">
                <h6>Shop</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('shop.index', ['category'=>'dresses']) }}">Dresses</a></li>
                    <li><a href="{{ route('shop.index', ['category'=>'tops']) }}">Tops</a></li>
                    <li><a href="{{ route('shop.index', ['category'=>'pants']) }}">Pants</a></li>
                    <li><a href="{{ route('shop.index', ['category'=>'outerwear']) }}">Outerwear</a></li>
                </ul>
            </div>
            <div class="col-md-2">
                <h6>Account</h6>
                <ul class="list-unstyled">
                    @guest
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                    @endguest
                    @auth
                    <li><a href="{{ route('orders.index') }}">My Orders</a></li>
                    @endauth
                </ul>
            </div>
            <div class="col-md-4">
                <h6>Contact</h6>
                <p style="font-size:.85rem;color:#b8a89e;">
                    <i class="fa fa-envelope me-2"></i>hello@rewear.ma<br>
                    <i class="fa fa-phone me-2"></i>+212 522 000 000<br>
                    <i class="fa fa-location-dot me-2"></i>Casablanca, Morocco
                </p>
            </div>
        </div>
        <hr style="border-color:#3d2920">
        <p class="text-center mb-0" style="font-size:.8rem;color:#7a5c4e;">© {{ date('Y') }} ReWear. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>

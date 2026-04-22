@extends('layouts.app')
@section('title','Shop')

@section('content')

{{-- Hero --}}
@if(!request()->filled('q') && !request()->filled('category'))
<section style="background:linear-gradient(135deg,#f5ede8 60%,#e8c4b8 100%);padding:5rem 0 4rem">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <p style="letter-spacing:.2em;text-transform:uppercase;font-size:.8rem;color:#c4786a">New Collection 2025</p>
                <h1 style="font-family:'Cormorant Garamond',serif;font-size:3.8rem;line-height:1.1;color:#2c1a12">
                    Dress for<br><em>the Woman</em><br>You Are
                </h1>
                <p class="mt-3 mb-4" style="color:#5a3e34;max-width:400px">Curated pieces that celebrate femininity, crafted with intention and worn with confidence.</p>
                <a href="{{ route('shop.index', ['sort'=>'newest']) }}" class="btn btn-rewear me-2">Shop Now</a>
                <a href="{{ route('shop.index', ['category'=>'dresses']) }}" class="btn btn-outline-rewear">Explore Dresses</a>
            </div>
        </div>
    </div>
</section>
@endif

<div class="container py-5">

    {{-- Filters --}}
    <div class="row align-items-center mb-4">
        <div class="col-md-7">
            <form method="GET" class="d-flex gap-2 flex-wrap">
                <input type="text" name="q" class="form-control" style="max-width:220px;border-radius:0"
                       placeholder="Search..." value="{{ request('q') }}">
                <select name="category" class="form-select" style="max-width:160px;border-radius:0" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                <select name="sort" class="form-select" style="max-width:160px;border-radius:0" onchange="this.form.submit()">
                    <option value="">Featured</option>
                    <option value="newest"     {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
                    <option value="price_asc"  {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low → High</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High → Low</option>
                </select>
                <button class="btn btn-rewear">Search</button>
                @if(request()->hasAny(['q','category','sort']))
                    <a href="{{ route('shop.index') }}" class="btn btn-outline-rewear">Clear</a>
                @endif
            </form>
        </div>
        <div class="col-md-5 text-md-end mt-2 mt-md-0">
            <span class="text-muted" style="font-size:.85rem">{{ $products->total() }} items</span>
        </div>
    </div>

    {{-- Product Grid --}}
    @if($products->isEmpty())
        <div class="text-center py-5">
            <i class="fa fa-magnifying-glass fa-3x mb-3" style="color:#e8c4b8"></i>
            <h5>No products found</h5>
            <a href="{{ route('shop.index') }}" class="btn btn-outline-rewear mt-2">Browse All</a>
        </div>
    @else
        <div class="row g-4">
            @foreach($products as $product)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="product-card card h-100">
                    <a href="{{ route('shop.show', $product) }}" class="position-relative d-block overflow-hidden">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        @else
                            <div class="card-img-top img-placeholder" style="height:320px">
                                <i class="fa fa-shirt fa-2x"></i>
                            </div>
                        @endif
                        @if($product->sale_price)
                            <span class="badge-sale position-absolute top-0 start-0 m-2">SALE</span>
                        @endif
                        @if($product->is_featured)
                            <span class="position-absolute top-0 end-0 m-2 badge" style="background:#2c1a12;color:#fff;border-radius:0;font-size:.65rem">★ Featured</span>
                        @endif
                    </a>
                    <div class="card-body">
                        <p class="mb-1" style="font-size:.75rem;color:#c4786a;text-transform:uppercase;letter-spacing:.08em">
                            {{ $product->category->name }}
                        </p>
                        <h6 class="mb-1"><a href="{{ route('shop.show', $product) }}" style="color:#2c1a12;text-decoration:none">{{ $product->name }}</a></h6>
                        <div class="price">
                            @if($product->sale_price)
                                <span class="sale">${{ number_format($product->sale_price, 2) }}</span>
                                <span class="original ms-1">${{ number_format($product->price, 2) }}</span>
                            @else
                                <span>${{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-2">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button class="btn btn-outline-rewear w-100" style="padding:.4rem;font-size:.78rem">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4">{{ $products->links() }}</div>
    @endif
</div>
@endsection

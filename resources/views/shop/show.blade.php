@extends('layouts.app')
@section('title', $product->name)

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb" style="font-size:.82rem">
            <li class="breadcrumb-item"><a href="{{ route('shop.index') }}" style="color:#c4786a">Shop</a></li>
            <li class="breadcrumb-item"><a href="{{ route('shop.index',['category'=>$product->category->slug]) }}" style="color:#c4786a">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        {{-- Image --}}
        <div class="col-md-6">
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" class="w-100" style="max-height:600px;object-fit:cover" alt="{{ $product->name }}">
            @else
                <div class="img-placeholder w-100" style="height:500px">
                    <i class="fa fa-shirt fa-4x"></i>
                </div>
            @endif
        </div>

        {{-- Details --}}
        <div class="col-md-6">
            <p style="color:#c4786a;text-transform:uppercase;letter-spacing:.1em;font-size:.8rem">{{ $product->category->name }}</p>
            <h1 style="font-family:'Cormorant Garamond',serif;font-size:2.5rem">{{ $product->name }}</h1>

            <div class="my-3" style="font-size:1.5rem">
                @if($product->sale_price)
                    <span style="color:#c4786a;font-weight:600">${{ number_format($product->sale_price,2) }}</span>
                    <span style="text-decoration:line-through;color:#aaa;font-size:1rem;margin-left:.5rem">${{ number_format($product->price,2) }}</span>
                    <span class="badge-sale ms-2">SALE</span>
                @else
                    <span>${{ number_format($product->price,2) }}</span>
                @endif
            </div>

            @if($product->description)
                <p class="text-muted mb-4" style="line-height:1.8">{{ $product->description }}</p>
            @endif

            <form action="{{ route('cart.add', $product) }}" method="POST">
                @csrf

                @if($product->sizes_array)
                <div class="mb-3">
                    <label class="form-label fw-medium" style="text-transform:uppercase;font-size:.8rem;letter-spacing:.08em">Size</label>
                    <div class="d-flex gap-2 flex-wrap">
                        @foreach($product->sizes_array as $size)
                            <input type="radio" class="btn-check" name="size" id="size_{{ $size }}" value="{{ $size }}" {{ $loop->first ? 'checked':'' }}>
                            <label class="btn btn-outline-secondary" for="size_{{ $size }}" style="border-radius:0;min-width:48px;font-size:.82rem">{{ $size }}</label>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($product->colors_array)
                <div class="mb-4">
                    <label class="form-label fw-medium" style="text-transform:uppercase;font-size:.8rem;letter-spacing:.08em">Color</label>
                    <div class="d-flex gap-2 flex-wrap">
                        @foreach($product->colors_array as $color)
                            <input type="radio" class="btn-check" name="color" id="color_{{ $color }}" value="{{ $color }}" {{ $loop->first ? 'checked':'' }}>
                            <label class="btn btn-outline-secondary" for="color_{{ $color }}" style="border-radius:0;font-size:.82rem">{{ $color }}</label>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="mb-4 d-flex align-items-center gap-3">
                    <label class="fw-medium" style="text-transform:uppercase;font-size:.8rem;letter-spacing:.08em">Qty</label>
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                           class="form-control text-center" style="width:80px;border-radius:0">
                    <span class="text-muted" style="font-size:.82rem">{{ $product->stock }} in stock</span>
                </div>

                @if($product->stock > 0)
                    <button class="btn btn-rewear w-100 py-3" style="font-size:1rem">
                        <i class="fa fa-bag-shopping me-2"></i>Add to Cart
                    </button>
                @else
                    <button class="btn btn-secondary w-100 py-3" disabled>Out of Stock</button>
                @endif
            </form>

            <div class="mt-4 pt-4 border-top" style="font-size:.82rem;color:#7a5c4e">
                <p><i class="fa fa-truck me-2"></i>Free shipping on orders over $100</p>
                <p><i class="fa fa-rotate-left me-2"></i>Easy 14-day returns</p>
                <p class="mb-0"><i class="fa fa-shield me-2"></i>Secure checkout</p>
            </div>
        </div>
    </div>

    {{-- Related Products --}}
    @if($related->count())
    <div class="mt-5 pt-4 border-top">
        <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.8rem" class="mb-4">You May Also Like</h3>
        <div class="row g-4">
            @foreach($related as $rel)
            <div class="col-6 col-md-3">
                <div class="product-card card">
                    <a href="{{ route('shop.show', $rel) }}">
                        @if($rel->image)
                            <img src="{{ asset('storage/'.$rel->image) }}" class="card-img-top" alt="{{ $rel->name }}">
                        @else
                            <div class="card-img-top img-placeholder" style="height:240px"><i class="fa fa-shirt fa-2x"></i></div>
                        @endif
                    </a>
                    <div class="card-body">
                        <h6 class="mb-1"><a href="{{ route('shop.show', $rel) }}" style="color:#2c1a12;text-decoration:none">{{ $rel->name }}</a></h6>
                        <div class="price">${{ number_format($rel->effective_price,2) }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

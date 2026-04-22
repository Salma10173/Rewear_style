@extends('layouts.app')
@section('title','Your Cart')

@section('content')
<div class="container py-5">
    <h1 style="font-family:'Cormorant Garamond',serif;font-size:2.5rem" class="mb-4">Your Cart</h1>

    @if(empty(session('cart')))
        <div class="text-center py-5">
            <i class="fa fa-bag-shopping fa-4x mb-3" style="color:#e8c4b8"></i>
            <h4>Your cart is empty</h4>
            <p class="text-muted">Discover our collection and add your favourites.</p>
            <a href="{{ route('shop.index') }}" class="btn btn-rewear mt-2">Start Shopping</a>
        </div>
    @else
        <div class="row g-4">
            {{-- Cart Items --}}
            <div class="col-lg-8">
                @foreach(session('cart') as $key => $item)
                <div class="card border-0 mb-3" style="border-radius:0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-3 col-md-2">
                                @if($item['image'])
                                    <img src="{{ asset('storage/'.$item['image']) }}" class="w-100" style="height:80px;object-fit:cover" alt="">
                                @else
                                    <div class="img-placeholder" style="height:80px"><i class="fa fa-shirt"></i></div>
                                @endif
                            </div>
                            <div class="col-5 col-md-6">
                                <h6 class="mb-1">{{ $item['name'] }}</h6>
                                <small class="text-muted">
                                    @if($item['size']) Size: {{ $item['size'] }} @endif
                                    @if($item['color']) · Color: {{ $item['color'] }} @endif
                                </small>
                                <div class="mt-1" style="font-weight:600">${{ number_format($item['price'],2) }}</div>
                            </div>
                            <div class="col-4 col-md-4 d-flex align-items-center justify-content-end gap-2">
                                <form action="{{ route('cart.update', $key) }}" method="POST" class="d-flex align-items-center gap-1">
                                    @csrf @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="10"
                                           class="form-control text-center" style="width:60px;border-radius:0;font-size:.85rem"
                                           onchange="this.form.submit()">
                                </form>
                                <form action="{{ route('cart.remove', $key) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-link text-danger p-0" title="Remove"><i class="fa fa-trash-can"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="d-flex justify-content-between mt-2">
                    <a href="{{ route('shop.index') }}" class="btn btn-outline-rewear">← Continue Shopping</a>
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-link text-muted" onclick="return confirm('Clear cart?')">Clear All</button>
                    </form>
                </div>
            </div>

            {{-- Summary --}}
            <div class="col-lg-4">
                <div class="card border-0" style="border-radius:0;background:#f5ede8">
                    <div class="card-body p-4">
                        <h5 class="mb-4" style="font-family:'Cormorant Garamond',serif;font-size:1.5rem">Order Summary</h5>
                        @php $shipping = $total >= 100 ? 0 : 5.99; @endphp
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>${{ number_format($total,2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping</span>
                            <span>{{ $shipping == 0 ? 'Free' : '$'.number_format($shipping,2) }}</span>
                        </div>
                        @if($shipping > 0)
                            <p class="text-muted" style="font-size:.78rem">Add ${{ number_format(100-$total,2) }} more for free shipping</p>
                        @endif
                        <hr>
                        <div class="d-flex justify-content-between mb-4 fw-bold" style="font-size:1.1rem">
                            <span>Total</span>
                            <span>${{ number_format($total+$shipping,2) }}</span>
                        </div>
                        @auth
                            <a href="{{ route('orders.checkout') }}" class="btn btn-rewear w-100 py-3">Proceed to Checkout</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-rewear w-100 py-3">Login to Checkout</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@extends('layouts.app')
@section('title','Checkout')

@section('content')
<div class="container py-5">
    <h1 style="font-family:'Cormorant Garamond',serif;font-size:2.5rem" class="mb-4">Checkout</h1>

    <div class="row g-4">
        {{-- Form --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm" style="border-radius:0">
                <div class="card-body p-4">
                    <h5 class="mb-3" style="font-family:'Cormorant Garamond',serif">Shipping Details</h5>
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Full Name</label>
                                <input type="text" name="shipping_name" class="form-control @error('shipping_name') is-invalid @enderror"
                                       value="{{ old('shipping_name', auth()->user()->name) }}" required style="border-radius:0">
                                @error('shipping_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Phone</label>
                                <input type="text" name="shipping_phone" class="form-control @error('shipping_phone') is-invalid @enderror"
                                       value="{{ old('shipping_phone', auth()->user()->phone) }}" required style="border-radius:0">
                                @error('shipping_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-medium">Address</label>
                                <textarea name="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror"
                                          rows="2" required style="border-radius:0">{{ old('shipping_address', auth()->user()->address) }}</textarea>
                                @error('shipping_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-medium">City</label>
                                <input type="text" name="shipping_city" class="form-control @error('shipping_city') is-invalid @enderror"
                                       value="{{ old('shipping_city') }}" required style="border-radius:0">
                                @error('shipping_city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-medium">ZIP Code</label>
                                <input type="text" name="shipping_zip" class="form-control" value="{{ old('shipping_zip') }}" style="border-radius:0">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-medium">Order Notes <span class="text-muted">(optional)</span></label>
                                <textarea name="notes" class="form-control" rows="2" style="border-radius:0" placeholder="Special instructions...">{{ old('notes') }}</textarea>
                            </div>
                            <div class="col-12">
                                <div class="p-3" style="background:#f5ede8;border-left:3px solid #c4786a">
                                    <strong style="font-size:.85rem"><i class="fa fa-money-bill me-2"></i>Payment: Cash on Delivery</strong>
                                    <p class="mb-0 text-muted" style="font-size:.8rem">Pay when your order arrives.</p>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-rewear w-100 py-3 mt-4" style="font-size:1rem">
                            Place Order
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Order summary --}}
        <div class="col-lg-5">
            <div class="card border-0" style="border-radius:0;background:#f5ede8">
                <div class="card-body p-4">
                    <h5 class="mb-3" style="font-family:'Cormorant Garamond',serif">Your Order</h5>
                    @php $shipping = $total >= 100 ? 0 : 5.99; @endphp
                    @foreach($cart as $item)
                    <div class="d-flex justify-content-between mb-2 align-items-start" style="font-size:.88rem">
                        <span>{{ $item['name'] }}
                            @if($item['size'] || $item['color'])
                                <small class="text-muted d-block">{{ $item['size'] }} {{ $item['color'] }}</small>
                            @endif
                        </span>
                        <span class="ms-2 text-nowrap">{{ $item['quantity'] }} × ${{ number_format($item['price'],2) }}</span>
                    </div>
                    @endforeach
                    <hr>
                    <div class="d-flex justify-content-between mb-1"><span>Subtotal</span><span>${{ number_format($total,2) }}</span></div>
                    <div class="d-flex justify-content-between mb-3"><span>Shipping</span><span>{{ $shipping == 0 ? 'Free' : '$'.number_format($shipping,2) }}</span></div>
                    <div class="d-flex justify-content-between fw-bold" style="font-size:1.1rem">
                        <span>Total</span><span>${{ number_format($total+$shipping,2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

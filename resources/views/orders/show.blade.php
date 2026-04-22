@extends('layouts.app')
@section('title','Order ' . $order->order_number)

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 style="font-family:'Cormorant Garamond',serif;font-size:2rem" class="mb-0">Order {{ $order->order_number }}</h1>
        <span class="badge badge-{{ $order->status }} px-3 py-2" style="border-radius:0;font-size:.82rem;text-transform:uppercase;letter-spacing:.06em">
            {{ ucfirst($order->status) }}
        </span>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4" style="border-radius:0">
                <div class="card-body p-4">
                    <h6 class="mb-3" style="text-transform:uppercase;letter-spacing:.08em;font-size:.8rem;color:#c4786a">Order Items</h6>
                    @foreach($order->items as $item)
                    <div class="d-flex gap-3 mb-3 pb-3 border-bottom">
                        @if($item->product && $item->product->image)
                            <img src="{{ asset('storage/'.$item->product->image) }}" style="width:70px;height:70px;object-fit:cover" alt="">
                        @else
                            <div class="img-placeholder" style="width:70px;height:70px"><i class="fa fa-shirt"></i></div>
                        @endif
                        <div class="flex-grow-1">
                            <div class="fw-medium">{{ $item->product_name }}</div>
                            <small class="text-muted">
                                @if($item->size) Size: {{ $item->size }} @endif
                                @if($item->color) · Color: {{ $item->color }} @endif
                            </small>
                            <div style="font-size:.85rem">Qty: {{ $item->quantity }} × ${{ number_format($item->product_price,2) }}</div>
                        </div>
                        <div class="fw-medium">${{ number_format($item->subtotal,2) }}</div>
                    </div>
                    @endforeach

                    <div class="text-end mt-3">
                        <div class="text-muted" style="font-size:.88rem">Subtotal: ${{ number_format($order->subtotal,2) }}</div>
                        <div class="text-muted" style="font-size:.88rem">Shipping: {{ $order->shipping == 0 ? 'Free' : '$'.number_format($order->shipping,2) }}</div>
                        <div class="fw-bold mt-1" style="font-size:1.1rem">Total: ${{ number_format($order->total,2) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3" style="border-radius:0">
                <div class="card-body p-4">
                    <h6 class="mb-3" style="text-transform:uppercase;letter-spacing:.08em;font-size:.8rem;color:#c4786a">Shipping Address</h6>
                    <p class="mb-1 fw-medium">{{ $order->shipping_name }}</p>
                    <p class="mb-1 text-muted">{{ $order->shipping_phone }}</p>
                    <p class="mb-1 text-muted">{{ $order->shipping_address }}</p>
                    <p class="mb-0 text-muted">{{ $order->shipping_city }} {{ $order->shipping_zip }}</p>
                </div>
            </div>
            <div class="card border-0 shadow-sm" style="border-radius:0">
                <div class="card-body p-4">
                    <h6 class="mb-2" style="text-transform:uppercase;letter-spacing:.08em;font-size:.8rem;color:#c4786a">Payment</h6>
                    <p class="mb-0 text-muted">{{ ucwords(str_replace('_',' ',$order->payment_method)) }}</p>
                    <p class="mb-0 text-muted mt-1" style="font-size:.8rem">Placed {{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('orders.index') }}" class="btn btn-outline-rewear">← Back to Orders</a>
    </div>
</div>
@endsection

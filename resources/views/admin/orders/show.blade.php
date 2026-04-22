@extends('layouts.admin')
@section('title', 'Order ' . $order->order_number)

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">
        ← Back to Orders
    </a>
    <span class="badge badge-{{ $order->status }} px-3 py-2"
          style="border-radius:3px;font-size:.82rem;text-transform:uppercase;letter-spacing:.06em">
        {{ ucfirst($order->status) }}
    </span>
</div>

<div class="row g-4">

    {{-- Order Items --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4" style="border-radius:6px">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-3" style="text-transform:uppercase;letter-spacing:.08em;font-size:.78rem;color:#7a5c4e">
                    Order Items
                </h6>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Size / Color</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($item->product && $item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                                 style="width:42px;height:42px;object-fit:cover" alt="">
                                        @else
                                            <div style="width:42px;height:42px;background:#f5ede8;display:flex;align-items:center;justify-content:center">
                                                <i class="fa fa-shirt" style="color:#c4786a;font-size:.8rem"></i>
                                            </div>
                                        @endif
                                        <span class="fw-medium" style="font-size:.88rem">{{ $item->product_name }}</span>
                                    </div>
                                </td>
                                <td style="font-size:.82rem;color:#7a5c4e">
                                    {{ $item->size ?? '—' }} / {{ $item->color ?? '—' }}
                                </td>
                                <td>${{ number_format($item->product_price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="text-end fw-medium">${{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end text-muted" style="font-size:.85rem">Subtotal</td>
                                <td class="text-end">${{ number_format($order->subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end text-muted" style="font-size:.85rem">Shipping</td>
                                <td class="text-end">
                                    {{ $order->shipping == 0 ? 'Free' : '$' . number_format($order->shipping, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Total</td>
                                <td class="text-end fw-bold" style="font-size:1.1rem;color:#c4786a">
                                    ${{ number_format($order->total, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- Notes --}}
        @if($order->notes)
        <div class="card border-0 shadow-sm" style="border-radius:6px">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-2" style="font-size:.78rem;text-transform:uppercase;letter-spacing:.08em;color:#7a5c4e">
                    Customer Notes
                </h6>
                <p class="mb-0 text-muted">{{ $order->notes }}</p>
            </div>
        </div>
        @endif
    </div>

    {{-- Sidebar --}}
    <div class="col-lg-4">

        {{-- Update Status --}}
        <div class="card border-0 shadow-sm mb-3" style="border-radius:6px">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-3" style="font-size:.78rem;text-transform:uppercase;letter-spacing:.08em;color:#7a5c4e">
                    Update Status
                </h6>
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                    @csrf @method('PATCH')
                    <select name="status" class="form-select mb-3" style="border-radius:4px">
                        @foreach(\App\Models\Order::STATUSES as $status)
                            <option value="{{ $status }}" {{ $order->status === $status ? 'selected':'' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn-accent w-100">Update Status</button>
                </form>

                {{-- Status timeline --}}
                <div class="mt-3 pt-3 border-top">
                    @php
                        $flow = ['pending','confirmed','shipped','delivered'];
                        $currentIdx = array_search($order->status, $flow);
                    @endphp
                    @foreach($flow as $i => $step)
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div style="width:22px;height:22px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.65rem;
                            background:{{ $i <= $currentIdx ? '#c4786a' : '#f0e8e2' }};
                            color:{{ $i <= $currentIdx ? '#fff' : '#b8a89e' }}">
                            @if($i < $currentIdx)
                                <i class="fa fa-check"></i>
                            @else
                                {{ $i + 1 }}
                            @endif
                        </div>
                        <span style="font-size:.82rem;color:{{ $i <= $currentIdx ? '#2c1a12' : '#b8a89e' }}">
                            {{ ucfirst($step) }}
                        </span>
                    </div>
                    @endforeach
                    @if($order->status === 'cancelled')
                    <div class="d-flex align-items-center gap-2 mt-1">
                        <div style="width:22px;height:22px;border-radius:50%;background:#f8d7da;display:flex;align-items:center;justify-content:center">
                            <i class="fa fa-times" style="font-size:.6rem;color:#842029"></i>
                        </div>
                        <span style="font-size:.82rem;color:#842029">Cancelled</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Customer Info --}}
        <div class="card border-0 shadow-sm mb-3" style="border-radius:6px">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-3" style="font-size:.78rem;text-transform:uppercase;letter-spacing:.08em;color:#7a5c4e">
                    Customer
                </h6>
                <p class="mb-1 fw-medium">{{ $order->user->name }}</p>
                <p class="mb-1 text-muted" style="font-size:.85rem">{{ $order->user->email }}</p>
                <p class="mb-0 text-muted" style="font-size:.85rem">{{ $order->user->phone ?? '—' }}</p>
            </div>
        </div>

        {{-- Shipping Info --}}
        <div class="card border-0 shadow-sm mb-3" style="border-radius:6px">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-3" style="font-size:.78rem;text-transform:uppercase;letter-spacing:.08em;color:#7a5c4e">
                    Shipping Address
                </h6>
                <p class="mb-1 fw-medium">{{ $order->shipping_name }}</p>
                <p class="mb-1 text-muted" style="font-size:.85rem">{{ $order->shipping_phone }}</p>
                <p class="mb-1 text-muted" style="font-size:.85rem">{{ $order->shipping_address }}</p>
                <p class="mb-0 text-muted" style="font-size:.85rem">
                    {{ $order->shipping_city }}
                    @if($order->shipping_zip) — {{ $order->shipping_zip }} @endif
                </p>
            </div>
        </div>

        {{-- Payment --}}
        <div class="card border-0 shadow-sm" style="border-radius:6px">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-2" style="font-size:.78rem;text-transform:uppercase;letter-spacing:.08em;color:#7a5c4e">
                    Payment
                </h6>
                <p class="mb-1">{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</p>
                <p class="mb-0 text-muted" style="font-size:.8rem">
                    Placed {{ $order->created_at->format('d M Y, H:i') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

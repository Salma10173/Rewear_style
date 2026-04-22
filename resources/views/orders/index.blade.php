@extends('layouts.app')
@section('title','My Orders')

@section('content')
<div class="container py-5">
    <h1 style="font-family:'Cormorant Garamond',serif;font-size:2.5rem" class="mb-4">My Orders</h1>

    @if($orders->isEmpty())
        <div class="text-center py-5">
            <i class="fa fa-bag-shopping fa-4x mb-3" style="color:#e8c4b8"></i>
            <h4>No orders yet</h4>
            <a href="{{ route('shop.index') }}" class="btn btn-rewear mt-2">Start Shopping</a>
        </div>
    @else
        <div class="card border-0 shadow-sm" style="border-radius:0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="fw-medium">{{ $order->order_number }}</td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>{{ $order->items->count() }} item(s)</td>
                            <td>${{ number_format($order->total,2) }}</td>
                            <td>
                                <span class="badge badge-{{ $order->status }} px-3 py-2" style="border-radius:0;font-size:.78rem;text-transform:uppercase;letter-spacing:.05em">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td><a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-rewear">View</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-3">{{ $orders->links() }}</div>
    @endif
</div>
@endsection

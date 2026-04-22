@extends('layouts.admin')
@section('title','Dashboard')

@section('content')

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    @php
    $cards = [
        ['label'=>'Total Orders',   'value'=>$stats['total_orders'],           'icon'=>'fa-bag-shopping',    'color'=>'#c4786a','bg'=>'#fdf0ec'],
        ['label'=>'Revenue',        'value'=>'$'.number_format($stats['total_revenue'],2),'icon'=>'fa-coins','color'=>'#b89a72','bg'=>'#fdf8ef'],
        ['label'=>'Products',       'value'=>$stats['total_products'],          'icon'=>'fa-shirt',           'color'=>'#6a8dc4','bg'=>'#eff3fd'],
        ['label'=>'Customers',      'value'=>$stats['total_users'],             'icon'=>'fa-users',           'color'=>'#6ac48a','bg'=>'#eff9f3'],
        ['label'=>'Pending Orders', 'value'=>$stats['pending_orders'],          'icon'=>'fa-clock',           'color'=>'#c4a86a','bg'=>'#fdf8ef'],
        ['label'=>'Low Stock',      'value'=>$stats['low_stock'],               'icon'=>'fa-triangle-exclamation','color'=>'#c46a6a','bg'=>'#fdf0f0'],
    ];
    @endphp
    @foreach($cards as $card)
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card card p-3 h-100">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div style="font-size:.75rem;text-transform:uppercase;letter-spacing:.08em;color:#7a5c4e">{{ $card['label'] }}</div>
                    <div style="font-size:1.5rem;font-weight:600;color:#2c1a12;margin-top:.25rem">{{ $card['value'] }}</div>
                </div>
                <div class="stat-icon" style="background:{{ $card['bg'] }};color:{{ $card['color'] }}">
                    <i class="fa {{ $card['icon'] }}"></i>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row g-4">
    {{-- Recent Orders --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm" style="border-radius:6px">
            <div class="card-body p-0">
                <div class="d-flex align-items-center justify-content-between px-4 pt-4 pb-2">
                    <h6 class="mb-0 fw-semibold">Recent Orders</h6>
                    <a href="{{ route('admin.orders.index') }}" style="font-size:.82rem;color:#c4786a">View All →</a>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead><tr>
                            <th>Order #</th><th>Customer</th><th>Total</th><th>Status</th><th></th>
                        </tr></thead>
                        <tbody>
                            @foreach($recent_orders as $order)
                            <tr>
                                <td class="fw-medium">{{ $order->order_number }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>${{ number_format($order->total,2) }}</td>
                                <td>
                                    <span class="badge badge-{{ $order->status }} px-2 py-1" style="border-radius:2px;font-size:.72rem">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td><a href="{{ route('admin.orders.show',$order) }}" style="color:#c4786a;font-size:.82rem">View</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Top Products --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:6px">
            <div class="card-body px-4 pt-4">
                <h6 class="fw-semibold mb-3">Top Products</h6>
                @foreach($top_products as $p)
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div style="width:40px;height:40px;background:#f5ede8;flex-shrink:0;display:flex;align-items:center;justify-content:center">
                        @if($p->image)
                            <img src="{{ asset('storage/'.$p->image) }}" style="width:40px;height:40px;object-fit:cover" alt="">
                        @else
                            <i class="fa fa-shirt" style="color:#c4786a;font-size:.9rem"></i>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <div style="font-size:.85rem;font-weight:500">{{ Str::limit($p->name,22) }}</div>
                        <div style="font-size:.75rem;color:#7a5c4e">{{ $p->order_items_count }} orders</div>
                    </div>
                    <div style="font-size:.85rem;color:#c4786a;font-weight:600">${{ number_format($p->price,0) }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

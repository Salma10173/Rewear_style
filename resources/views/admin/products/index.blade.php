@extends('layouts.admin')
@section('title','Products')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div></div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-accent px-4">
        <i class="fa fa-plus me-1"></i> Add Product
    </a>
</div>

{{-- Filters --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius:6px">
    <div class="card-body p-3">
        <form method="GET" class="d-flex gap-2 flex-wrap">
            <input type="text" name="search" class="form-control" style="max-width:220px;border-radius:4px" placeholder="Search products..." value="{{ request('search') }}">
            <select name="category" class="form-select" style="max-width:180px;border-radius:4px" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected':'' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button class="btn btn-accent">Search</button>
            @if(request()->hasAny(['search','category']))
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Clear</a>
            @endif
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius:6px">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr>
                <th>Product</th><th>Category</th><th>Price</th><th>Stock</th><th>Featured</th><th>Active</th><th>Actions</th>
            </tr></thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" style="width:40px;height:40px;object-fit:cover" alt="">
                            @else
                                <div style="width:40px;height:40px;background:#f5ede8;display:flex;align-items:center;justify-content:center">
                                    <i class="fa fa-shirt" style="color:#c4786a;font-size:.8rem"></i>
                                </div>
                            @endif
                            <span class="fw-medium">{{ $product->name }}</span>
                        </div>
                    </td>
                    <td>{{ $product->category->name }}</td>
                    <td>
                        @if($product->sale_price)
                            <span style="color:#c4786a">${{ number_format($product->sale_price,2) }}</span>
                            <small class="text-muted ms-1" style="text-decoration:line-through">${{ number_format($product->price,2) }}</small>
                        @else
                            ${{ number_format($product->price,2) }}
                        @endif
                    </td>
                    <td>
                        <span class="{{ $product->stock <= 5 ? 'text-danger fw-bold' : '' }}">{{ $product->stock }}</span>
                    </td>
                    <td>
                        @if($product->is_featured)
                            <span style="color:#b89a72"><i class="fa fa-star"></i></span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}" style="border-radius:2px">
                            {{ $product->is_active ? 'Active' : 'Hidden' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-secondary me-1">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this product?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No products found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $products->links() }}</div>
</div>
@endsection

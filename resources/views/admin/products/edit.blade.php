@extends('layouts.admin')
@section('title', 'Edit Product')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card border-0 shadow-sm" style="border-radius:6px">
            <div class="card-body p-4">
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-medium">Product Name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $product->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Category *</label>
                            <select name="category_id" class="form-select" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected':'' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-medium">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Price (DH) *</label>
                            <input type="number" name="price" step="0.01" min="0" class="form-control"
                                   value="{{ old('price', $product->price) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Sale Price (DH)</label>
                            <input type="number" name="sale_price" step="0.01" min="0" class="form-control"
                                   value="{{ old('sale_price', $product->sale_price) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Stock *</label>
                            <input type="number" name="stock" min="0" class="form-control"
                                   value="{{ old('stock', $product->stock) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Sizes</label>
                            <input type="text" name="sizes" class="form-control" value="{{ old('sizes', $product->sizes) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Colors</label>
                            <input type="text" name="colors" class="form-control" value="{{ old('colors', $product->colors) }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-medium">Product Image</label>
                            @if($product->image)
                                <div class="mb-2"><img src="{{ asset('storage/'.$product->image) }}" style="height:100px;object-fit:cover" alt=""></div>
                            @endif
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked':'' }}>
                                <label class="form-check-label">Featured</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked':'' }}>
                                <label class="form-check-label">Active</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button class="btn btn-accent px-4">Update Product</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin')
@section('title', isset($product) ? 'Edit Product' : 'Add Product')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card border-0 shadow-sm" style="border-radius:6px">
            <div class="card-body p-4">
                <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($product)) @method('PUT') @endif

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-medium">Product Name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $product->name ?? '') }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Category *</label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">Select…</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected':'' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-medium">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description ?? '') }}</textarea>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-medium">Price ($) *</label>
                            <input type="number" name="price" step="0.01" min="0"
                                   class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price', $product->price ?? '') }}" required>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Sale Price ($)</label>
                            <input type="number" name="sale_price" step="0.01" min="0"
                                   class="form-control" value="{{ old('sale_price', $product->sale_price ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Stock *</label>
                            <input type="number" name="stock" min="0"
                                   class="form-control @error('stock') is-invalid @enderror"
                                   value="{{ old('stock', $product->stock ?? 0) }}" required>
                            @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-medium">Sizes <small class="text-muted">(comma-separated)</small></label>
                            <input type="text" name="sizes" class="form-control" placeholder="XS,S,M,L,XL"
                                   value="{{ old('sizes', $product->sizes ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Colors <small class="text-muted">(comma-separated)</small></label>
                            <input type="text" name="colors" class="form-control" placeholder="Black,White,Pink"
                                   value="{{ old('colors', $product->colors ?? '') }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-medium">Product Image</label>
                            @if(isset($product) && $product->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$product->image) }}" style="height:100px;object-fit:cover" alt="">
                                    <small class="text-muted d-block">Upload a new image to replace</small>
                                </div>
                            @endif
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>

                        <div class="col-md-6">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1"
                                       {{ old('is_featured', $product->is_featured ?? false) ? 'checked':'' }}>
                                <label class="form-check-label" for="is_featured">Featured Product</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                                       {{ old('is_active', $product->is_active ?? true) ? 'checked':'' }}>
                                <label class="form-check-label" for="is_active">Active (Visible in store)</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-accent px-4">
                            {{ isset($product) ? 'Update Product' : 'Create Product' }}
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin')
@section('title', isset($product) ? 'Modifier le produit' : 'Ajouter un produit')

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
                            <label class="form-label fw-medium">Nom du produit *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $product->name ?? '') }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Catégorie *</label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">Sélectionner…</option>
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
                            <label class="form-label fw-medium">Prix (DH) *</label>
                            <input type="number" name="price" step="0.01" min="0"
                                   class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price', $product->price ?? '') }}" required>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Prix de vente (DH)</label>
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
                            <label class="form-label fw-medium">Tailles <small class="text-muted">(séparées par des virgules)</small></label>
                            <input type="text" name="sizes" class="form-control" placeholder="XS,S,M,L,XL"
                                   value="{{ old('sizes', $product->sizes ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Couleurs <small class="text-muted">(séparées par des virgules)</small></label>
                            <input type="text" name="colors" class="form-control" placeholder="Noir,Blanc,Rose"
                                   value="{{ old('colors', $product->colors ?? '') }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-medium">Image du produit</label>
                            @if(isset($product) && $product->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$product->image) }}" style="height:100px;object-fit:cover" alt="">
                                    <small class="text-muted d-block">Téléchargez une nouvelle image pour remplacer</small>
                                </div>
                            @endif
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>

                        <div class="col-md-6">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1"
                                       {{ old('is_featured', $product->is_featured ?? false) ? 'checked':'' }}>
                                <label class="form-check-label" for="is_featured">Produit en vedette</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                                       {{ old('is_active', $product->is_active ?? true) ? 'checked':'' }}>
                                <label class="form-check-label" for="is_active">Actif (Visible dans la boutique)</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-accent px-4">
                            {{ isset($product) ? 'Mettre à jour le produit' : 'Créer un produit' }}
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

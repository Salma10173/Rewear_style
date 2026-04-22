<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('is_active', true);

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        // Search
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(fn($q) => $q->where('name', 'like', "%$search%")
                                      ->orWhere('description', 'like', "%$search%"));
        }

        // Sort
        match ($request->sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'newest'     => $query->latest(),
            default      => $query->where('is_featured', true)->orderBy('id', 'desc'),
        };

        $products   = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->get();
        $featured   = Product::where('is_featured', true)->where('is_active', true)->take(4)->get();

        return view('shop.index', compact('products', 'categories', 'featured'));
    }

    public function show(Product $product)
    {
        abort_if(!$product->is_active, 404);

        $related = Product::where('category_id', $product->category_id)
                          ->where('id', '!=', $product->id)
                          ->where('is_active', true)
                          ->take(4)->get();

        return view('shop.show', compact('product', 'related'));
    }
}

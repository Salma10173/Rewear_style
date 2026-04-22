<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getCart(): array
    {
        return session('cart', []);
    }

    private function saveCart(array $cart): void
    {
        session(['cart' => $cart]);
    }

    public function index()
    {
        $cart  = $this->getCart();
        $total = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
            'size'     => 'nullable|string',
            'color'    => 'nullable|string',
        ]);

        $cart = $this->getCart();
        $key  = $product->id . '_' . $request->size . '_' . $request->color;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $request->quantity;
        } else {
            $cart[$key] = [
                'product_id' => $product->id,
                'name'       => $product->name,
                'price'      => $product->effective_price,
                'image'      => $product->image,
                'quantity'   => $request->quantity,
                'size'       => $request->size,
                'color'      => $request->color,
            ];
        }

        $this->saveCart($cart);

        return redirect()->back()->with('success', '"' . $product->name . '" added to your cart.');
    }

    public function update(Request $request, string $key)
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:10']);

        $cart = $this->getCart();

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = $request->quantity;
            $this->saveCart($cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    public function remove(string $key)
    {
        $cart = $this->getCart();
        unset($cart[$key]);
        $this->saveCart($cart);

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }
}

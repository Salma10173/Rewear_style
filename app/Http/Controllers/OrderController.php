<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = auth()->user()->orders()->with('items')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        $order->load('items.product');
        return view('orders.show', compact('order'));
    }

    public function checkout()
    {
        $cart = session('cart', []);
        abort_if(empty($cart), 302, redirect()->route('cart.index')->with('error', 'Votre panier est vide.'));

        $total = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);
        return view('orders.checkout', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_name'    => 'required|string|max:255',
            'shipping_phone'   => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'shipping_city'    => 'required|string|max:100',
            'shipping_zip'     => 'nullable|string|max:20',
            'notes'            => 'nullable|string',
        ]);

        $cart = session('cart', []);
        abort_if(empty($cart), 400);

        $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);
        $shipping = $subtotal >= 100 ? 0 : 5.99;
        $total    = $subtotal + $shipping;

        $order = Order::create([
            'user_id'          => auth()->id(),
            'order_number'     => Order::generateOrderNumber(),
            'status'           => 'pending',
            'subtotal'         => $subtotal,
            'shipping'         => $shipping,
            'total'            => $total,
            'shipping_name'    => $request->shipping_name,
            'shipping_phone'   => $request->shipping_phone,
            'shipping_address' => $request->shipping_address,
            'shipping_city'    => $request->shipping_city,
            'shipping_zip'     => $request->shipping_zip,
            'notes'            => $request->notes,
            'payment_method'   => 'cash_on_delivery',
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id'      => $order->id,
                'product_id'    => $item['product_id'],
                'product_name'  => $item['name'],
                'product_price' => $item['price'],
                'quantity'      => $item['quantity'],
                'size'          => $item['size'],
                'color'         => $item['color'],
                'subtotal'      => $item['price'] * $item['quantity'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('orders.show', $order)
                         ->with('success', 'Commande #' . $order->order_number . ' passée avec succès !');
    }
}

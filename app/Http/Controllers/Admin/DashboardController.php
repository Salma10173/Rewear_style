<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders'    => Order::count(),
            'total_revenue'   => Order::where('status', '!=', 'cancelled')->sum('total'),
            'total_products'  => Product::count(),
            'total_users'     => User::where('role', 'user')->count(),
            'pending_orders'  => Order::where('status', 'pending')->count(),
            'low_stock'       => Product::where('stock', '<=', 5)->count(),
        ];

        $recent_orders = Order::with('user')->latest()->take(8)->get();

        $top_products = Product::withCount('orderItems')
                                ->orderByDesc('order_items_count')
                                ->take(5)->get();

        $monthly_revenue = Order::selectRaw('MONTH(created_at) as month, SUM(total) as revenue')
                                 ->where('status', '!=', 'cancelled')
                                 ->whereYear('created_at', now()->year)
                                 ->groupBy('month')
                                 ->orderBy('month')
                                 ->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'top_products', 'monthly_revenue'));
    }
}

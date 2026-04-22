<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController   as AdminProductController;
use App\Http\Controllers\Admin\CategoryController  as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController     as AdminOrderController;

/*
|--------------------------------------------------------------------------
| Public / Auth Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product:slug}', [ShopController::class, 'show'])->name('shop.show');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Cart (guest & auth)
|--------------------------------------------------------------------------
*/

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/',                    [CartController::class, 'index'])->name('index');
    Route::post('/add/{product:slug}', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{key}',      [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{key}',     [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear',            [CartController::class, 'clear'])->name('clear');
});

/*
|--------------------------------------------------------------------------
| Orders (authenticated users)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('orders')->name('orders.')->group(function () {
    Route::get('/',           [OrderController::class, 'index'])->name('index');
    Route::get('/checkout',   [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/',          [OrderController::class, 'store'])->name('store');
    Route::get('/{order}',    [OrderController::class, 'show'])->name('show');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::resource('products', AdminProductController::class)->except(['show']);

    // Categories
    Route::resource('categories', AdminCategoryController::class)->except(['show']);

    // Orders
    Route::get('orders',                          [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}',                  [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status',         [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

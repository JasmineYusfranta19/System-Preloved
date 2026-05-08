<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController\TesterController;
use App\Http\Controllers\AdminController\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;

// Import Seller Controllers
use App\Http\Controllers\Seller\DashboardController as SellerDashboard;
use App\Http\Controllers\Seller\ShopController as SellerShop;
use App\Http\Controllers\Seller\ProductController as SellerProduct;
use App\Http\Controllers\Seller\OrderController as SellerOrder;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/test', [TesterController::class, 'index']);
Route::get('/send-email', [TesterController::class, 'send']);
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/shops/{slug}', [ShopController::class, 'show'])->name('shops.show');

// ── Admin Routes (yang sudah ada, biarkan) ─────────────────────
Route::prefix('admin')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [AuthController::class, 'register']);
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
    });
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
});

// ── Seller Routes (DI LUAR prefix admin) ──────────────────────
Route::middleware(['auth', 'seller'])
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {
        Route::get('/dashboard', [SellerDashboard::class, 'index'])->name('dashboard');
        Route::get('/shop/create', [SellerShop::class, 'create'])->name('shop.create');
        Route::post('/shop', [SellerShop::class, 'store'])->name('shop.store');
        Route::get('/shop/edit', [SellerShop::class, 'edit'])->name('shop.edit');
        Route::put('/shop', [SellerShop::class, 'update'])->name('shop.update');
        Route::resource('products', SellerProduct::class);
        Route::get('/orders', [SellerOrder::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [SellerOrder::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/ship', [SellerOrder::class, 'ship'])->name('orders.ship');
    });
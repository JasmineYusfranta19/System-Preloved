<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController\TesterController;
use App\Http\Controllers\AdminController\AuthController;

// Import Seller Controllers
use App\Http\Controllers\Seller\DashboardController as SellerDashboard;
use App\Http\Controllers\Seller\ShopController as SellerShop;
use App\Http\Controllers\Seller\ProductController as SellerProduct;
use App\Http\Controllers\Seller\OrderController as SellerOrder;

Route::get('/', fn() => view('welcome'));
Route::get('/test', [TesterController::class, 'index']);
Route::get('/send-email', [TesterController::class, 'send']);

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
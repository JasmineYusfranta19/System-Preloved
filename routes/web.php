<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController\TesterController;
use App\Http\Controllers\AdminController\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Buyer\CartController;
use App\Http\Controllers\Buyer\CheckoutController;

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

    // ── Buyer Routes (butuh login) ────────────────────────────────────
Route::middleware('auth')->group(function () {
 
    // Keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/{cart}/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
 
    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/payment/{order}', [CheckoutController::class, 'payment'])->name('orders.payment');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('orders.success');
 
    // Riwayat Pesanan
    Route::get('/orders', [CheckoutController::class, 'orders'])->name('orders.index');
    Route::post('/orders/{order}/confirm', function(\App\Models\Order $order) {
        if ($order->buyer_id !== auth()->id()) abort(403);
        $order->update(['status' => 'completed']);
        if ($order->shipment) $order->shipment->update(['status' => 'delivered', 'delivered_at' => now()]);
        return back()->with('success', 'Pesanan dikonfirmasi selesai!');
    })->name('orders.confirm');
});
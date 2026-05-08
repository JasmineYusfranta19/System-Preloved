<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;

class DashboardController extends Controller
{
    public function index()
    {
        $shop = Auth::user()->shop;

        if (!$shop) {
            return redirect()->route('seller.shop.create')
                ->with('info', 'Buat toko kamu dulu sebelum mulai berjualan.');
        }

        $stats = [
            'total_products'  => $shop->products()->count(),
            'active_products' => $shop->products()->where('status', 'active')->count(),
            'total_orders'    => OrderItem::where('shop_id', $shop->id)
                                    ->distinct('order_id')->count('order_id'),
            'pending_orders'  => OrderItem::where('shop_id', $shop->id)
                                    ->whereHas('order', fn($q) => $q->where('status', 'paid'))
                                    ->distinct('order_id')->count('order_id'),
            'total_revenue'   => OrderItem::where('shop_id', $shop->id)
                                    ->whereHas('order', fn($q) => $q->where('status', 'completed'))
                                    ->sum('subtotal'),
            'total_reviews'   => $shop->products()->withCount('reviews')
                                    ->get()->sum('reviews_count'),
        ];

        $recentOrders = Order::whereHas('items', fn($q) => $q->where('shop_id', $shop->id))
            ->with(['buyer', 'items' => fn($q) => $q->where('shop_id', $shop->id)->with('product')])
            ->latest()
            ->take(5)
            ->get();

        $topProducts = $shop->products()
            ->withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->take(5)
            ->get();

        return view('seller.dashboard', compact('shop', 'stats', 'recentOrders', 'topProducts'));
    }
}
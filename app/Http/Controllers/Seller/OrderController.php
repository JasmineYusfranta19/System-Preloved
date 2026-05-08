<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Shipment;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $shop = Auth::user()->shop;

        $orders = Order::whereHas('items', fn($q) => $q->where('shop_id', $shop->id))
            ->with([
                'buyer',
                'items' => fn($q) => $q->where('shop_id', $shop->id)->with('product.primaryImage'),
                'payment',
                'shipment',
            ])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('seller.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $shop = Auth::user()->shop;

        if (!$order->items()->where('shop_id', $shop->id)->exists()) {
            abort(403);
        }

        $order->load([
            'buyer',
            'address',
            'items' => fn($q) => $q->where('shop_id', $shop->id)->with('product.primaryImage'),
            'payment',
            'shipment',
        ]);

        return view('seller.orders.show', compact('order'));
    }

    public function ship(Request $request, Order $order)
    {
        $request->validate([
            'courier'         => 'required|string|max:50',
            'service'         => 'nullable|string|max:50',
            'tracking_number' => 'required|string|max:100',
        ]);

        Shipment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'courier'         => $request->courier,
                'service'         => $request->service,
                'tracking_number' => $request->tracking_number,
                'status'          => 'in_transit',
                'shipped_at'      => now(),
            ]
        );

        $order->update(['status' => 'shipped']);

        return back()->with('success', 'Pesanan ditandai sudah dikirim.');
    }
}
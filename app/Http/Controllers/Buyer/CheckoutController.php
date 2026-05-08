<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Address;

class CheckoutController extends Controller
{
    // Checkout dari keranjang
    public function index()
    {
        $carts = Auth::user()->carts()
            ->with(['product.primaryImage', 'product.shop'])
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang kamu kosong.');
        }

        $addresses = Auth::user()->addresses;
        $subtotal  = $carts->sum(fn($c) => $c->product->price * $c->quantity);
        $shipping  = 15000;
        $total     = $subtotal + $shipping;

        return view('buyer.checkout', compact('carts', 'addresses', 'subtotal', 'shipping', 'total'));
    }

    // Proses checkout
    public function process(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
        ]);

        $address = Address::where('id', $request->address_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $carts = Auth::user()->carts()->with('product.shop')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        DB::transaction(function () use ($carts, $address) {
            $subtotal = $carts->sum(fn($c) => $c->product->price * $c->quantity);
            $shipping = 15000;
            $total    = $subtotal + $shipping;

            $order = Order::create([
                'buyer_id'      => Auth::id(),
                'address_id'    => $address->id,
                'subtotal'      => $subtotal,
                'shipping_cost' => $shipping,
                'total'         => $total,
                'status'        => 'pending',
                'expires_at'    => now()->addHours(24),
            ]);

            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $cart->product_id,
                    'shop_id'    => $cart->product->shop_id,
                    'quantity'   => $cart->quantity,
                    'price'      => $cart->product->price,
                    'subtotal'   => $cart->product->price * $cart->quantity,
                ]);

                // Kurangi stok
                $cart->product->decrement('stock', $cart->quantity);
            }

            // Buat record payment
            Payment::create([
                'order_id' => $order->id,
                'amount'   => $total,
                'status'   => 'pending',
            ]);

            // Kosongkan keranjang
            Auth::user()->carts()->delete();

            session(['last_order_id' => $order->id]);
        });

        return redirect()->route('orders.payment', session('last_order_id'))
            ->with('success', 'Pesanan berhasil dibuat! Selesaikan pembayaran.');
    }

    // Halaman pembayaran
    public function payment(Order $order)
    {
        if ($order->buyer_id !== Auth::id()) abort(403);

        $order->load(['items.product.primaryImage', 'payment', 'address']);

        return view('buyer.payment', compact('order'));
    }

    // Halaman sukses
    public function success(Order $order)
    {
        if ($order->buyer_id !== Auth::id()) abort(403);
        return view('buyer.order-success', compact('order'));
    }

    // Riwayat pesanan buyer
    public function orders()
    {
        $orders = Order::where('buyer_id', Auth::id())
            ->with(['items.product.primaryImage', 'payment', 'shipment'])
            ->latest()
            ->paginate(10);

        return view('buyer.orders', compact('orders'));
    }
}
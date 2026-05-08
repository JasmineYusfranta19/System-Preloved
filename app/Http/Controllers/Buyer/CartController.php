<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $carts = Auth::user()->carts()
            ->with(['product.primaryImage', 'product.shop'])
            ->get();

        $total = $carts->sum(fn($c) => $c->product->price * $c->quantity);

        return view('buyer.cart', compact('carts', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->isAvailable()) {
            return back()->with('error', 'Produk tidak tersedia.');
        }

        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            if ($cart->quantity >= $product->stock) {
                return back()->with('error', 'Stok tidak mencukupi.');
            }
            $cart->increment('quantity');
        } else {
            Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => $product->id,
                'quantity'   => 1,
            ]);
        }

        return back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) abort(403);

        $request->validate(['quantity' => 'required|integer|min:1']);

        if ($request->quantity > $cart->product->stock) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) abort(403);
        $cart->delete();
        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function clear()
    {
        Auth::user()->carts()->delete();
        return back()->with('success', 'Keranjang dikosongkan.');
    }
}
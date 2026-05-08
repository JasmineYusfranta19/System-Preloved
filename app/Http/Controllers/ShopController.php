<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class ShopController extends Controller
{
    public function show(string $slug)
    {
        $shop = Shop::where('slug', $slug)->where('status', 'active')->firstOrFail();

        $products = $shop->products()
            ->where('status', 'active')
            ->with('primaryImage')
            ->latest()
            ->paginate(12);

        return view('public.shop', compact('shop', 'products'));
    }
}
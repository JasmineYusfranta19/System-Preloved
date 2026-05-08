<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Shop;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $categories     = Category::whereNull('parent_id')->get();
        $latestProducts = Product::where('status', 'active')
            ->with(['primaryImage', 'shop'])
            ->latest()->take(8)->get();

        $stats = [
            'total_products' => Product::where('status', 'active')->count(),
            'total_shops'    => Shop::where('status', 'active')->count(),
            'total_users'    => User::count(),
        ];

        return view('public.home', compact('categories', 'latestProducts', 'stats'));
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::whereNull('parent_id')->with('children')->get();

        $products = Product::where('status', 'active')
            ->with(['primaryImage', 'shop', 'category'])
            
            // FIX 1: Menggunakan filled() dan membungkus orWhere agar tidak merusak filter lain
            ->when($request->filled('search'), fn($q) =>
                $q->where(function($query) use ($request) {
                    $query->where('name', 'like', '%'.$request->search.'%')
                          ->orWhere('brand', 'like', '%'.$request->search.'%');
                })
            )
            
            // FIX 2: Mendukung pencarian berdasarkan Slug Anak maupun Slug Induk Kategori
            ->when($request->filled('category'), fn($q) =>
                $q->whereHas('category', function($c) use ($request) {
                    $c->where('slug', $request->category)
                      ->orWhereHas('parent', fn($p) => $p->where('slug', $request->category));
                })
            )
            
            ->when($request->condition, fn($q) =>
                $q->whereIn('condition', $request->condition)
            )
            ->when($request->size, fn($q) =>
                $q->whereIn('size', $request->size)
            )
            ->when($request->gender, fn($q) =>
                $q->where('gender', $request->gender)
            )
            ->when($request->min_price, fn($q) =>
                $q->where('price', '>=', $request->min_price)
            )
            ->when($request->max_price, fn($q) =>
                $q->where('price', '<=', $request->max_price)
            )
            ->latest()
            ->paginate(12);

        return view('public.products', compact('products', 'categories'));
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['images', 'primaryImage', 'shop', 'category', 'reviews.user'])
            ->firstOrFail();

        // Increment views
        $product->increment('views');

        return view('public.product_detail', compact('product'));
    }
}
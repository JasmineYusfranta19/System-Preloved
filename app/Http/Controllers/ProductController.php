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
            ->when($request->search, fn($q) =>
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('brand', 'like', '%'.$request->search.'%')
            )
            ->when($request->category, fn($q) =>
                $q->whereHas('category', fn($c) => $c->where('slug', $request->category))
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

        return view('public.product-detail', compact('product'));
    }
}
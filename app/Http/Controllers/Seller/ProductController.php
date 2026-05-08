<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $shop = Auth::user()->shop;

        $products = $shop->products()
            ->with(['category', 'primaryImage'])
            ->when($request->search, fn($q) =>
                $q->where('name', 'like', '%' . $request->search . '%')
            )
            ->when($request->status, fn($q) =>
                $q->where('status', $request->status)
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->orderBy('name')
            ->get();

        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:1000',
            'stock'       => 'required|integer|min:1',
            'condition'   => 'required|in:new,like_new,good,fair',
            'size'        => 'nullable|string|max:10',
            'brand'       => 'nullable|string|max:100',
            'color'       => 'nullable|string|max:50',
            'gender'      => 'nullable|in:men,women,unisex,kids',
            'images'      => 'required|array|min:1|max:5',
            'images.*'    => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $shop = Auth::user()->shop;

        $product = Product::create([
            'shop_id'     => $shop->id,
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => Str::slug($request->name) . '-' . uniqid(),
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'condition'   => $request->condition,
            'size'        => $request->size,
            'brand'       => $request->brand,
            'color'       => $request->color,
            'gender'      => $request->gender,
            'status'      => 'active',
        ]);

        foreach ($request->file('images') as $i => $image) {
            $path = $image->store('products', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'image_url'  => Storage::url($path),
                'is_primary' => $i === 0,
                'sort_order' => $i + 1,
            ]);
        }

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $this->authorizeProduct($product);

        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->orderBy('name')
            ->get();

        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorizeProduct($product);

        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:1000',
            'stock'       => 'required|integer|min:0',
            'condition'   => 'required|in:new,like_new,good,fair',
            'size'        => 'nullable|string|max:10',
            'brand'       => 'nullable|string|max:100',
            'color'       => 'nullable|string|max:50',
            'gender'      => 'nullable|in:men,women,unisex,kids',
            'status'      => 'required|in:active,inactive',
            'images'      => 'nullable|array|max:5',
            'images.*'    => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $product->update($request->except(['images', '_token', '_method']));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url'  => Storage::url($path),
                    'is_primary' => false,
                    'sort_order' => $product->images()->count() + $i + 1,
                ]);
            }
        }

        return back()->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $this->authorizeProduct($product);

        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_url);
        }

        $product->delete();

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    private function authorizeProduct(Product $product): void
    {
        if ($product->shop_id !== Auth::user()->shop->id) {
            abort(403, 'Akses ditolak.');
        }
    }
}
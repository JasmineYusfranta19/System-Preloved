<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    public function create()
    {
        if (Auth::user()->shop) {
            return redirect()->route('seller.dashboard');
        }
        return view('seller.shop.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:shops,name',
            'description' => 'required|string|max:1000',
            'city'        => 'required|string|max:100',
            'province'    => 'required|string|max:100',
            'logo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $data = [
            'user_id'     => Auth::id(),
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'city'        => $request->city,
            'province'    => $request->province,
            'status'      => 'active',
        ];

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('shops/logos', 'public');
        }
        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('shops/banners', 'public');
        }

        Auth::user()->shop()->create($data);

        return redirect()->route('seller.dashboard')
            ->with('success', 'Toko berhasil dibuat!');
    }

    public function edit()
    {
        $shop = Auth::user()->shop;
        return view('seller.shop.edit', compact('shop'));
    }

    public function update(Request $request)
    {
        $shop = Auth::user()->shop;

        $request->validate([
            'name'        => 'required|string|max:255|unique:shops,name,' . $shop->id,
            'description' => 'required|string|max:1000',
            'city'        => 'required|string|max:100',
            'province'    => 'required|string|max:100',
            'logo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $data = [
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'city'        => $request->city,
            'province'    => $request->province,
        ];

        if ($request->hasFile('logo')) {
            if ($shop->logo) Storage::disk('public')->delete($shop->logo);
            $data['logo'] = $request->file('logo')->store('shops/logos', 'public');
        }
        if ($request->hasFile('banner')) {
            if ($shop->banner) Storage::disk('public')->delete($shop->banner);
            $data['banner'] = $request->file('banner')->store('shops/banners', 'public');
        }

        $shop->update($data);

        return back()->with('success', 'Profil toko berhasil diperbarui.');
    }
}
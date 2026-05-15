<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'label'          => 'required|string|max:50',
            'recipient_name' => 'required|string|max:100',
            'phone'          => 'required|string|max:20',
            'full_address'   => 'required|string',
            'city'           => 'required|string|max:100',
            'province'       => 'required|string|max:100',
            'postal_code'    => 'required|string|max:10',
        ]);

        // Kalau is_default, reset semua dulu
        if ($request->is_default) {
            Auth::user()->addresses()->update(['is_default' => false]);
        }

        // Kalau belum ada alamat sama sekali, jadikan default otomatis
        $isDefault = $request->boolean('is_default') || Auth::user()->addresses()->count() === 0;

        Auth::user()->addresses()->create([
            'label'          => $request->label,
            'recipient_name' => $request->recipient_name,
            'phone'          => $request->phone,
            'full_address'   => $request->full_address,
            'city'           => $request->city,
            'province'       => $request->province,
            'postal_code'    => $request->postal_code,
            'is_default'     => $isDefault,
        ]);

        $redirect = $request->redirect ?? url('/checkout');
        return redirect($redirect)->with('success', 'Alamat berhasil ditambahkan!');
    }

    public function update(Request $request, Address $address)
    {
        if ($address->user_id !== Auth::id()) abort(403);

        $request->validate([
            'label'          => 'required|string|max:50',
            'recipient_name' => 'required|string|max:100',
            'phone'          => 'required|string|max:20',
            'full_address'   => 'required|string',
            'city'           => 'required|string|max:100',
            'province'       => 'required|string|max:100',
            'postal_code'    => 'required|string|max:10',
        ]);

        if ($request->is_default) {
            Auth::user()->addresses()->update(['is_default' => false]);
        }

        $address->update([
            'label'          => $request->label,
            'recipient_name' => $request->recipient_name,
            'phone'          => $request->phone,
            'full_address'   => $request->full_address,
            'city'           => $request->city,
            'province'       => $request->province,
            'postal_code'    => $request->postal_code,
            'is_default'     => $request->boolean('is_default'),
        ]);

        $redirect = $request->redirect ?? url('/checkout');
        return redirect($redirect)->with('success', 'Alamat berhasil diperbarui!');
    }

    public function destroy(Address $address)
    {
        if ($address->user_id !== Auth::id()) abort(403);

        // Jangan hapus kalau ini satu-satunya alamat
        if (Auth::user()->addresses()->count() === 1) {
            return back()->with('error', 'Tidak bisa menghapus satu-satunya alamat.');
        }

        $wasDefault = $address->is_default;
        $address->delete();

        // Kalau yang dihapus adalah default, set alamat pertama jadi default
        if ($wasDefault) {
            Auth::user()->addresses()->first()?->update(['is_default' => true]);
        }

        return back()->with('success', 'Alamat berhasil dihapus.');
    }
}
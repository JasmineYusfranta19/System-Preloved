<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Shipment;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $buyers   = User::where('role', 'buyer')->get();
        $products = Product::with('shop')->get();

        foreach ($buyers as $buyer) {
            $address = $buyer->addresses()->first();
            if (!$address) continue;

            // Ambil 2 produk acak
            $selectedProducts = $products->random(2);
            $subtotal         = $selectedProducts->sum('price');
            $shippingCost     = 15000;
            $total            = $subtotal + $shippingCost;

            $order = Order::create([
                'buyer_id'      => $buyer->id,
                'address_id'    => $address->id,
                'subtotal'      => $subtotal,
                'shipping_cost' => $shippingCost,
                'total'         => $total,
                'status'        => 'completed',
            ]);

            foreach ($selectedProducts as $product) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'shop_id'    => $product->shop_id,
                    'quantity'   => 1,
                    'price'      => $product->price,
                    'subtotal'   => $product->price,
                ]);
            }

            Payment::create([
                'order_id' => $order->id,
                'amount'   => $total,
                'method'   => 'bank_transfer',
                'status'   => 'paid',
                'paid_at'  => now()->subDays(rand(1, 10)),
            ]);

            Shipment::create([
                'order_id'        => $order->id,
                'courier'         => 'JNE',
                'service'         => 'REG',
                'tracking_number' => 'JNE' . strtoupper(uniqid()),
                'status'          => 'delivered',
                'shipped_at'      => now()->subDays(rand(3, 8)),
                'delivered_at'    => now()->subDays(rand(1, 3)),
            ]);
        }
    }
}
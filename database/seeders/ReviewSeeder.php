<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $comments = [
            'Barang sesuai deskripsi, kondisi bagus banget!',
            'Pengiriman cepat, packing rapi. Recommend seller ini!',
            'Kualitas oke untuk harga segini, worth it.',
            'Sudah sesuai ekspektasi, barang mulus.',
            'Seller responsif, barang sampai dengan selamat.',
        ];

        $orders = Order::where('status', 'completed')->with('items')->get();

        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                Review::create([
                    'product_id'    => $item->product_id,
                    'user_id'       => $order->buyer_id,
                    'order_item_id' => $item->id,
                    'rating'        => rand(4, 5),
                    'comment'       => $comments[array_rand($comments)],
                    'is_visible'    => true,
                ]);
            }
        }
    }
}
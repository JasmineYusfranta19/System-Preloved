<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Shop;

class ShopSeeder extends Seeder
{
    public function run(): void
    {
        $shops = [
            [
                'email'       => 'siti@preloved.com',
                'name'        => 'Siti Thrift Store',
                'slug'        => 'siti-thrift-store',
                'description' => 'Koleksi preloved pilihan berkualitas dari brand lokal dan internasional.',
                'city'        => 'Jakarta Selatan',
                'province'    => 'DKI Jakarta',
            ],
            [
                'email'       => 'budi@preloved.com',
                'name'        => 'Budi Vintage',
                'slug'        => 'budi-vintage',
                'description' => 'Spesialis pakaian vintage dan retro tahun 80-90an.',
                'city'        => 'Bandung',
                'province'    => 'Jawa Barat',
            ],
            [
                'email'       => 'rina@preloved.com',
                'name'        => "Rina's Closet",
                'slug'        => 'rina-closet',
                'description' => 'Fashion wanita preloved kondisi like new, harga terjangkau.',
                'city'        => 'Surabaya',
                'province'    => 'Jawa Timur',
            ],
        ];

        foreach ($shops as $data) {
            $user = User::where('email', $data['email'])->first();
            unset($data['email']);

            Shop::create(array_merge($data, [
                'user_id' => $user->id,
                'status'  => 'active',
            ]));
        }
    }
}
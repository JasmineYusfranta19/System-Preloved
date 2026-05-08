<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'              => 'Admin Preloved',
            'email'             => 'admin@preloved.com',
            'password'          => Hash::make('password'),
            'role'              => 'admin',
            'phone'             => '08100000001',
            'email_verified_at' => now(),
        ]);

        // Sellers
        $sellers = [
            ['name' => 'Siti Thrifter',   'email' => 'siti@preloved.com',   'phone' => '08111111111'],
            ['name' => 'Budi Vintage',    'email' => 'budi@preloved.com',    'phone' => '08122222222'],
            ['name' => 'Rina Closet',     'email' => 'rina@preloved.com',    'phone' => '08133333333'],
        ];

        foreach ($sellers as $seller) {
            User::create([
                'name'              => $seller['name'],
                'email'             => $seller['email'],
                'password'          => Hash::make('password'),
                'role'              => 'seller',
                'phone'             => $seller['phone'],
                'email_verified_at' => now(),
            ]);
        }

        // Buyers
        $buyers = [
            ['name' => 'Ani Pembeli',  'email' => 'ani@preloved.com',  'phone' => '08144444444'],
            ['name' => 'Doni Shopper', 'email' => 'doni@preloved.com', 'phone' => '08155555555'],
            ['name' => 'Yuni Fashion', 'email' => 'yuni@preloved.com', 'phone' => '08166666666'],
        ];

        foreach ($buyers as $buyer) {
            User::create([
                'name'              => $buyer['name'],
                'email'             => $buyer['email'],
                'password'          => Hash::make('password'),
                'role'              => 'buyer',
                'phone'             => $buyer['phone'],
                'email_verified_at' => now(),
            ]);
        }
    }
}
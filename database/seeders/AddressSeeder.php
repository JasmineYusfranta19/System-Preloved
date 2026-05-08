<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Address;

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        $buyers = User::where('role', 'buyer')->get();

        $addresses = [
            [
                'label'          => 'Rumah',
                'recipient_name' => 'Ani Pembeli',
                'phone'          => '08144444444',
                'full_address'   => 'Jl. Sudirman No. 10, RT 01 RW 02',
                'city'           => 'Jakarta Pusat',
                'province'       => 'DKI Jakarta',
                'postal_code'    => '10220',
            ],
            [
                'label'          => 'Rumah',
                'recipient_name' => 'Doni Shopper',
                'phone'          => '08155555555',
                'full_address'   => 'Jl. Gatot Subroto No. 5, RT 03 RW 05',
                'city'           => 'Bandung',
                'province'       => 'Jawa Barat',
                'postal_code'    => '40135',
            ],
            [
                'label'          => 'Rumah',
                'recipient_name' => 'Yuni Fashion',
                'phone'          => '08166666666',
                'full_address'   => 'Jl. Darmo No. 22, RT 02 RW 04',
                'city'           => 'Surabaya',
                'province'       => 'Jawa Timur',
                'postal_code'    => '60241',
            ],
        ];

        foreach ($buyers as $i => $buyer) {
            Address::create(array_merge($addresses[$i], [
                'user_id'    => $buyer->id,
                'is_default' => true,
            ]));
        }
    }
}
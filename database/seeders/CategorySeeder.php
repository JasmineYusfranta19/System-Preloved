<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Atasan', 'icon' => '👕', 'children' => [
                'Kaos', 'Kemeja', 'Blouse', 'Sweater', 'Hoodie', 'Jaket',
            ]],
            ['name' => 'Bawahan', 'icon' => '👖', 'children' => [
                'Celana Jeans', 'Celana Chino', 'Rok', 'Celana Pendek', 'Legging',
            ]],
            ['name' => 'Dress & Jumpsuit', 'icon' => '👗', 'children' => [
                'Dress Casual', 'Dress Formal', 'Jumpsuit', 'Romper',
            ]],
            ['name' => 'Outerwear', 'icon' => '🧥', 'children' => [
                'Blazer', 'Coat', 'Cardigan', 'Vest',
            ]],
            ['name' => 'Sepatu', 'icon' => '👟', 'children' => [
                'Sneakers', 'Sepatu Formal', 'Sandal', 'Boots', 'Heels',
            ]],
            ['name' => 'Tas', 'icon' => '👜', 'children' => [
                'Tas Ransel', 'Tas Selempang', 'Tote Bag', 'Dompet', 'Clutch',
            ]],
            ['name' => 'Aksesoris', 'icon' => '💍', 'children' => [
                'Topi', 'Ikat Pinggang', 'Jam Tangan', 'Kalung', 'Gelang',
            ]],
        ];

        foreach ($categories as $cat) {
            $parent = DB::table('categories')->insertGetId([
                'name'       => $cat['name'],
                'slug'       => Str::slug($cat['name']),
                'icon'       => $cat['icon'],
                'parent_id'  => null,
                'sort_order' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($cat['children'] as $i => $child) {
                DB::table('categories')->insert([
                    'name'       => $child,
                    'slug'       => Str::slug($child),
                    'icon'       => null,
                    'parent_id'  => $parent,
                    'sort_order' => $i + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
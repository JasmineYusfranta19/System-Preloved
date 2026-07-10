<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Shop;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $shops      = Shop::all();
        $conditions = ['like_new', 'good', 'fair'];
        $sizes      = ['S', 'M', 'L', 'XL', 'XXL'];
        $genders    = ['men', 'women', 'unisex'];
        $brands     = ['Uniqlo', 'Zara', 'H&M', 'Mango', 'Pull&Bear', 'Stradivarius', 'Lokal Brand'];

        $products = [
            // Atasan
            ['name' => 'Kaos Polos Oversize', 'category' => 'Kaos', 'price' => 45000],
            ['name' => 'Kemeja Flannel Kotak', 'category' => 'Kemeja', 'price' => 85000],
            ['name' => 'Blouse Sifon Bunga', 'category' => 'Blouse', 'price' => 65000],
            ['name' => 'Hoodie Polos Premium', 'category' => 'Hoodie', 'price' => 120000],
            ['name' => 'Sweater Rajut Tebal', 'category' => 'Sweater', 'price' => 95000],
            ['name' => 'Jaket Denim Classic', 'category' => 'Jaket', 'price' => 175000],
            // Bawahan
            ['name' => 'Celana Jeans Skinny', 'category' => 'Celana Jeans', 'price' => 110000],
            ['name' => 'Rok Midi Floral', 'category' => 'Rok', 'price' => 75000],
            ['name' => 'Celana Chino Slim', 'category' => 'Celana Chino', 'price' => 90000],
            ['name' => 'Celana Pendek Cargo', 'category' => 'Celana Pendek', 'price' => 60000],
            // Dress
            ['name' => 'Dress Casual Stripe', 'category' => 'Dress Casual', 'price' => 130000],
            ['name' => 'Jumpsuit Denim', 'category' => 'Jumpsuit', 'price' => 155000],
            // Outerwear
            ['name' => 'Blazer Formal Hitam', 'category' => 'Blazer', 'price' => 200000],
            ['name' => 'Cardigan Panjang', 'category' => 'Cardigan', 'price' => 85000],
            // Sepatu
            ['name' => 'Sneakers Putih Bersih', 'category' => 'Sneakers', 'price' => 250000],
            ['name' => 'Sandal Kulit Coklat', 'category' => 'Sandal', 'price' => 80000],
            // Tas
            ['name' => 'Tote Bag Canvas', 'category' => 'Tote Bag', 'price' => 70000],
            ['name' => 'Tas Selempang Mini', 'category' => 'Tas Selempang', 'price' => 115000],
            // Aksesoris
            ['name' => 'Topi Bucket Vintage', 'category' => 'Topi', 'price' => 45000],
            ['name' => 'Ikat Pinggang Kulit', 'category' => 'Ikat Pinggang', 'price' => 55000],
        ];

        foreach ($products as $i => $data) {
            $shop     = $shops[$i % $shops->count()];
            $category = Category::where('name', $data['category'])->first();

            if (!$category) continue;

            $product = Product::create([
                'shop_id'     => $shop->id,
                'category_id' => $category->id,
                'name'        => $data['name'],
                'slug'        => Str::slug($data['name']) . '-' . uniqid(),
                'description' => "Kondisi masih bagus, terawat, bebas bau dan noda. {$data['name']} cocok untuk sehari-hari.",
                'price'       => $data['price'],
                'stock'       => rand(1, 3),
                'condition'   => $conditions[array_rand($conditions)],
                'size'        => $sizes[array_rand($sizes)],
                'brand'       => $brands[array_rand($brands)],
                'color'       => ['Hitam', 'Putih', 'Navy', 'Abu-abu', 'Coklat'][array_rand(['Hitam', 'Putih', 'Navy', 'Abu-abu', 'Coklat'])],
                'gender'      => $genders[array_rand($genders)],
                'status'      => 'active',
                'views'       => rand(10, 500),
            ]);

            // Dummy product images (pakai Unsplash asli yang stylish)
            $categoryImages = [
                'Kaos' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?q=80&w=600&auto=format&fit=crop',
                'Kemeja' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?q=80&w=600&auto=format&fit=crop',
                'Blouse' => 'https://images.unsplash.com/photo-1548624149-f9b1859aa702?q=80&w=600&auto=format&fit=crop',
                'Hoodie' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?q=80&w=600&auto=format&fit=crop',
                'Sweater' => 'https://images.unsplash.com/photo-1614975058789-41316d0e2e9c?q=80&w=600&auto=format&fit=crop',
                'Jaket' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?q=80&w=600&auto=format&fit=crop',
                'Celana Jeans' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?q=80&w=600&auto=format&fit=crop',
                'Rok' => 'https://images.unsplash.com/photo-1583496661160-fb5886a0aaaa?q=80&w=600&auto=format&fit=crop',
                'Celana Chino' => 'https://images.unsplash.com/photo-1473968512647-3e447244af8f?q=80&w=600&auto=format&fit=crop',
                'Celana Pendek' => 'https://images.unsplash.com/photo-1591195853828-11db59a44f6b?q=80&w=600&auto=format&fit=crop',
                'Dress Casual' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=600&auto=format&fit=crop',
                'Jumpsuit' => 'https://images.unsplash.com/photo-1585487000160-6ebcfceb0d03?q=80&w=600&auto=format&fit=crop',
                'Blazer' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=600&auto=format&fit=crop',
                'Cardigan' => 'https://images.unsplash.com/photo-1508427953056-b00b8d78ebf5?q=80&w=600&auto=format&fit=crop',
                'Sneakers' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=600&auto=format&fit=crop',
                'Sandal' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=600&auto=format&fit=crop',
                'Tote Bag' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?q=80&w=600&auto=format&fit=crop',
                'Tas Selempang' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?q=80&w=600&auto=format&fit=crop',
                'Topi' => 'https://images.unsplash.com/photo-1576871337632-b9aef4c17ab9?q=80&w=600&auto=format&fit=crop',
                'Ikat Pinggang' => 'https://images.unsplash.com/photo-1624222247344-550fb8ec5519?q=80&w=600&auto=format&fit=crop',
            ];

            $imgUrl = $categoryImages[$data['category']] ?? 'https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=600&auto=format&fit=crop';

            ProductImage::create([
                'product_id' => $product->id,
                'image_url'  => $imgUrl,
                'is_primary' => true,
                'sort_order' => 1,
            ]);
        }
    }
}
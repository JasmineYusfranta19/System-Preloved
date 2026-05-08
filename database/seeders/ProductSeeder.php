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

            // Dummy product images (pakai placeholder)
            ProductImage::create([
                'product_id' => $product->id,
                'image_url'  => "https://placehold.co/600x800?text=" . urlencode($data['name']),
                'is_primary' => true,
                'sort_order' => 1,
            ]);
        }
    }
}
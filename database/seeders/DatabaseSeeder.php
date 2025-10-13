<?php

namespace Database\Seeders;

use App\Models\Category;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::insert([
            ['name' => 'Nike', 'slug' => 'nike'],
            ['name' => 'Adidas', 'slug' => 'adidas'],
            ['name' => 'Puma', 'slug' => 'puma'],
            ['name' => 'Reebok', 'slug' => 'reebok'],
            ['name' => 'New Balance', 'slug' => 'new-balance'],
        ]);
        Product::insert([
            [
                'name' => 'Nike Air Max 270',
                'slug' => 'nike-air-max-270',
                'image' => 'https://static.nike.com/a/images/c_limit,w_592,f_auto/t_product_v1/2f3f1f3e-1c4e-4a0e-8f6b-5c1e3b8e6f3a/air-max-270-shoe-KkLcGR.png',
                'brand' => 'Nike',
                'description' => 'The Nike Air Max 270 is inspired by two icons of big Air: the Air Max 180 and Air Max 93. It features Nike\'s biggest heel Air unit yet for a super-soft ride that feels as impossible as it looks.',
                'price' => 15000,
            ],
            [
                'name' => 'Adidas Ultraboost 21',
                'slug' => 'adidas-ultraboost-21',
                'image' => 'https://assets.adidas.com/images/w_600,f_auto,q_auto/4b3d6c5f0c1b4b2fa8a0ac3700f2d2d9_9366/Ultraboost_21_Shoes_Black_FY0377_01_standard.jpg',
                'brand' => 'Adidas',
                'description' => 'The Adidas Ultraboost 21 is designed to give you more energy return and a smoother ride. It features a Primeknit+ upper for a sock-like fit and Boost midsole for ultimate comfort.',
                'price' => 18000,
            ],
            [
                'name' => 'Puma RS-X3',
                'slug' => 'puma-rs-x3',
                'image' => 'https://images.puma.com/image/upload/f_auto,q_auto,b_rgb:fafafa,w_450,h_450/global/371570/01/sv01/fnd/PNA/fmt/png/Rs-X3-Sneakers',
                'brand' => 'Puma',
                'description' => 'The Puma RS-X3 is a bold and futuristic sneaker that combines retro style with modern technology. It features a mix of materials on the upper and a chunky sole for added comfort.',
                'price' => 12000,
            ],
                    ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Category;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // tạo/hoặc lấy categories và lưu map slug -> id
        $categories = [
            ['name' => 'Nike', 'slug' => 'nike'],
            ['name' => 'Adidas', 'slug' => 'adidas'],
            ['name' => 'Puma', 'slug' => 'puma'],
            ['name' => 'Reebok', 'slug' => 'reebok'],
            ['name' => 'New Balance', 'slug' => 'new-balance'],
        ];

        $map = [];
        foreach ($categories as $c) {
            $cat = Category::firstOrCreate(['slug' => $c['slug']], $c);
            $map[$c['slug']] = $cat->id;
        }

        // chèn products với category_id trỏ tới categories.id
        Product::insert([
            [
                'name' => 'Nike Air Max 270',
                'image' => 'https://static.nike.com/a/images/c_limit,w_592,f_auto/t_product_v1/2f3f1f3e-1c4e-4a0e-8f6b-5c1e3b8e6f3a/air-max-270-shoe-KkLcGR.png',
                'brand' => 'Nike',
                'description' => 'The Nike Air Max 270 is inspired by two icons of big Air: the Air Max 180 and Air Max 93. It features Nike\'s biggest heel Air unit yet for a super-soft ride that feels as impossible as it looks.',
                'price' => 15000,
                'product_id' => $map['nike'],
                'color' => 'Black/White',
                'size' => '10',
                'status' => 'Available',
                'design' => 'Sporty',
            ],
            [
                'name' => 'Adidas Ultraboost 21',
                'image' => 'https://assets.adidas.com/images/w_600,f_auto,q_auto/4b3d6c5f0c1b4b2fa8a0ac3700f2d2d9_9366/Ultraboost_21_Shoes_Black_FY0377_01_standard.jpg',
                'brand' => 'Adidas',
                'description' => 'The Adidas Ultraboost 21 is designed to give you more energy return and a smoother ride. It features a Primeknit+ upper for a sock-like fit and Boost midsole for ultimate comfort.',
                'price' => 18000,
                'product_id' => $map['adidas'],
                'color' => 'Black',
                'size' => '9',
                'status' => 'Available',
                'design' => 'Running',
            ],
            [
                'name' => 'Puma RS-X3',
                'image' => 'https://images.puma.com/image/upload/f_auto,q_auto,b_rgb:fafafa,w_450,h_450/global/371570/01/sv01/fnd/PNA/fmt/png/Rs-X3-Sneakers',
                'brand' => 'Puma',
                'description' => 'The Puma RS-X3 is a bold and futuristic sneaker that combines retro style with modern technology. It features a mix of materials on the upper and a chunky sole for added comfort.',
                'price' => 12000,
                'product_id' => $map['puma'],
                'color' => 'White/Red',
                'size' => '11',
                'status' => 'Available',
                'design' => 'Casual',
            ],
        ]);

        // Insert data into trangthaihoadon table without model
        DB::table('trangthaihoadon')->insert([
            ['name' => 'Đang xử lý'],
            ['name' => 'Chưa thanh toán'],
            ['name' => 'Đã thanh toán'],
            ['name' => 'Đang giao hàng'],
            ['name' => 'Hoàn thành'],
            ['name' => 'Đã hủy'],
            ['name' => 'Đã hoàn trả'],
        ]);

        DB::table('phuongthucthanhtoan')->insert([
            ['name' => 'Tiền mặt'],
            ['name' => 'VNPay'],
        ]);

        DB::table('hoadons')->insert([
            ['user_id' => 0, 'trangthaihoadon_id' => 3, 'phuongthucthanhtoan_id' => 1, 'diachi_id' => 1, 'sanpham_id' => 1, 'soluong' => 1, 'tongtien' => 1],
            ['user_id' => 0, 'trangthaihoadon_id' => 2, 'phuongthucthanhtoan_id' => 2, 'diachi_id' => 5, 'sanpham_id' => 2, 'soluong' => 5, 'tongtien' => 2],
        ]);

        // seed users: one admin and 10 sample users
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
        ]);

        User::factory(10)->create();
    }
}

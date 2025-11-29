<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
use App\Models\Color;
use App\Models\ProductVariant;
use App\Models\Voucher;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\BlogPost;
use App\Models\BlogPostTag;
use App\Models\Brand;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PosOrder;
use App\Models\PosOrderItem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $jsonFile = database_path('seeders/data.json');
        $dataArray = json_decode(file_get_contents($jsonFile), true);

        foreach ($dataArray['roles'] as $data) {
            Role::create($data);
        }
        foreach ($dataArray['users'] as $data) {
            User::create($data);
        }
        foreach ($dataArray['categories'] as $data) {
            Category::create($data);
        }
        foreach ($dataArray['brands'] as $data) {
            Brand::create($data);
        }

        foreach ($dataArray['products'] as $data) {
            Product::create($data);
        }

        foreach ($dataArray['sizes'] as $data) {
            Size::create($data);
        }

        foreach ($dataArray['colors'] as $data) {
            Color::create($data);
        }

        foreach ($dataArray['product_variants'] as $data) {
            ProductVariant::create($data);
        }

        foreach ($dataArray['vouchers'] as $data) {
            Voucher::create($data);
        }

        foreach ($dataArray['blog_categories'] as $data) {
            BlogCategory::create($data);
        }

        foreach ($dataArray['blog_tags'] as $data) {
            BlogTag::create($data);
        }

        foreach ($dataArray['blog_posts'] as $data) {
            BlogPost::create($data);
        }

        foreach ($dataArray['blog_post_tags'] as $data) {
            DB::table('blog_post_tags')->insert($data);
        }
        foreach ($dataArray['pos_orders'] as $data) {
            DB::table('pos_orders')->insert($data);
        }
        foreach ($dataArray['pos_order_items'] as $data) {
            DB::table('pos_order_items')->insert($data);
        }
        foreach ($dataArray['orders'] as $data) {
            Order::create($data);
        }
        foreach ($dataArray['order_items'] as $data) {
            OrderItem::create($data);
    }
        foreach ($dataArray['reviews'] as $data) {
            DB::table('reviews')->insert($data);
        }
}
}
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
class ExportProductsJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-products-json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = [
        'roles' => DB::table('roles')->get(),
        'users' => DB::table('users')->get(),
        'categories' => DB::table('categories')->get(),
        'brands'=>DB::table('brands')->get(),
        'products' => DB::table('products')->get(),
        'sizes' => DB::table('sizes')->get(),
        'colors' => DB::table('colors')->get(),
        'product_variants' => DB::table('product_variants')->get(),
        'vouchers' => DB::table('vouchers')->get(),
        'blog_categories' => DB::table('blog_categories')->get(),
        'blog_tags' => DB::table('blog_tags')->get(),
        'blog_posts' => DB::table('blog_posts')->get(),
        'blog_post_tags' => DB::table('blog_post_tags')->get()
        , 'pos_orders' => DB::table('pos_orders')->get(),
        'pos_order_items' => DB::table('pos_order_items')->get(),
        'orders' => DB::table('orders')->get(),
        'order_items' => DB::table('order_items')->get(),
        'reviews' => DB::table('reviews')->get(),
    ];

    $path = database_path('seeders/data.json');

    File::put($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    $this->info('✅ Xuất dữ liệu thành công! File nằm tại: ' . $path);
}
    }


<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['completed', 'processing', 'cancelled'];
        $payments = ['COD', 'VNPAY', 'MOMO', 'PayPal'];

        $product_variant_ids = DB::table('product_variants')->pluck('id')->toArray();

        for ($i = 1; $i <= 10; $i++) {

            // Random tên, email, phone mẫu cho vui
            $name = 'Khách hàng ' . $i;
            $email = 'user' . $i . '@gmail.com';
            $phone = '09' . rand(10000000, 99999999);

            $order_id = DB::table('orders')->insertGetId([
                'user_id'           => rand(1, 2),
                'name'              => $name,
                'email'             => $email,
                'phone'             => $phone,
                'total_amount'      => rand(100000, 500000),
                'voucher_id'        => rand(0, 1) ? 1 : null,
                'discount_applied'  => rand(1000, 30000),
                'status'            => $statuses[array_rand($statuses)],
                'payment_method'    => $payments[array_rand($payments)],
                'shipping_address'  => Str::random(10),
                'created_at'        => now()->subDays(rand(0, 30)),
                'updated_at'        => now(),
            ]);

            $num_items = rand(1, 3);
            for ($j = 1; $j <= $num_items; $j++) {
                $variant_id = $product_variant_ids[array_rand($product_variant_ids)];
                $quantity = rand(1, 5);
                $price = rand(100000, 500000);

                DB::table('order_items')->insert([
                    'order_id'           => $order_id,
                    'product_variant_id' => $variant_id,
                    'quantity'           => $quantity,
                    'price'              => $price,
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ]);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    /**
     * Seed only vouchers table.
     */
    public function run(): void
    {
        $vouchers = [
            [
                'code' => 'HP10',
                'description' => 'Giảm 10% cho đơn hàng đầu tiên',
                'discount_type' => 'percent',
                'discount_value' => 10.00,
                'max_discount' => 50000.00,
                'min_order_value' => 300000.00,
                'usage_limit' => 100,
                'used_count' => 0,
                'valid_from' => '2025-01-01 00:00:00',
                'valid_to' => '2026-12-31 23:59:59',
            ],
            [
                'code' => 'FREESHIP',
                'description' => 'Miễn phí vận chuyển cho đơn từ 500k',
                'discount_type' => 'fixed',
                'discount_value' => 30000.00,
                'max_discount' => null,
                'min_order_value' => 500000.00,
                'usage_limit' => 200,
                'used_count' => 0,
                'valid_from' => '2025-01-01 00:00:00',
                'valid_to' => '2026-12-31 23:59:59',
            ],
            [
                'code' => 'SALE20',
                'description' => 'Giảm 20% tối đa 100k',
                'discount_type' => 'percent',
                'discount_value' => 20.00,
                'max_discount' => 100000.00,
                'min_order_value' => 200000.00,
                'usage_limit' => 50,
                'used_count' => 0,
                'valid_from' => '2025-01-01 00:00:00',
                'valid_to' => '2026-12-31 23:59:59',
            ],
            [
                'code' => 'VIP50K',
                'description' => 'Giảm 50k cho đơn từ 1 triệu',
                'discount_type' => 'fixed',
                'discount_value' => 50000.00,
                'max_discount' => null,
                'min_order_value' => 1000000.00,
                'usage_limit' => 30,
                'used_count' => 0,
                'valid_from' => '2025-01-01 00:00:00',
                'valid_to' => '2026-12-31 23:59:59',
            ],
            [
                'code' => 'WELCOME15',
                'description' => 'Mã chào mừng - Giảm 15%',
                'discount_type' => 'percent',
                'discount_value' => 15.00,
                'max_discount' => 75000.00,
                'min_order_value' => 0.00,
                'usage_limit' => 500,
                'used_count' => 0,
                'valid_from' => '2025-01-01 00:00:00',
                'valid_to' => '2026-12-31 23:59:59',
            ],
        ];

        foreach ($vouchers as $voucher) {
            Voucher::updateOrCreate(
                ['code' => $voucher['code']],
                $voucher
            );
        }
    }
}

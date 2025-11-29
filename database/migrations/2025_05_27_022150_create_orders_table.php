<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->foreignId('voucher_id')->nullable()->constrained('vouchers');
            $table->decimal('discount_applied', 10, 2)->default(0);
            $table->string('status');
            $table->string('payment_method');
            $table->text('shipping_address');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

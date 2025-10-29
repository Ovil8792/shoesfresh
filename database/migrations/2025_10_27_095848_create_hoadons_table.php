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
        Schema::create('hoadons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('trangthaihoadon_id')->constrained('trangthaihoadon');
            $table->foreignId('phuongthucthanhtoan_id')->constrained('phuongthucthanhtoan');
            $table->foreignId('diachi_id')->constrained('diachis');
            $table->foreignId('sanpham_id')->constrained('sanphams');
            $table->foreignId('soluong')->constrained('soluongs');
            $table->foreignId('tongtien')->constrained('tongtiens');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoadons');
    }
};

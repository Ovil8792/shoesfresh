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
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('product_id')->after('image')->constrained("categories")->onDelete('cascade');
            $table->string('color')->after("product_id")->nullable();
            $table->string('size')->after("color")->nullable();
            $table->string('status')->after("size")->nullable();
            $table->string('design')->after("status")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};

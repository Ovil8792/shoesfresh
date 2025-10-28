<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductController as AdminProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix("/")->group(function(){
    Route::get('/',[ProductController::class,'home'])->name('home');
Route::get("/san-pham",[ProductController::class,'products'])->name('products');
Route::get("/dang-nhap",[AuthController::class,'show'])->name('login');
Route::get("/gio-hang",[ProductController::class,"cart"])->name("cart");
Route::get("/san-pham/{id}",[ProductController::class,'productDetail'])->name('product.detail');
}
);
Route::prefix("/admin")->group(function(){
    //admin
    Route::get("/",[AdminController::class,"index"])->name('admin.dashboard');
    Route::get("/danh-muc",[CategoryController::class,"index"])->name('admin.category');
    Route::get("/sua-danh-muc/{id}",[CategoryController::class,"edit"])->name('admin.editcat');
    Route::get("/xoa-danh-muc/{id}",[CategoryController::class,"destroy"])->name('admin.delcat');
    Route::get("/san-pham",[AdminProductController::class,"index"])->name('admin.product');
});


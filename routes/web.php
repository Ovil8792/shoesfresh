<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix("/")->group(function(){
    Route::get('/',[ProductController::class,'home'])->name('home');
Route::get("/san-pham",[ProductController::class,'products'])->name('products');
Route::get("/dang-nhap",[AuthController::class,'show'])->name('login');
Route::get("/gio-hang",[ProductController::class,"cart"])->name("cart");
}
);
Route::prefix("/admin")->group(function(){
    //admin
    Route::get("/",[AdminController::class,"index"])->name('admin.dashboard');
});


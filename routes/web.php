<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductController as AdminProductController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\ColorController;
use App\Http\Controllers\admin\SizeController;
use App\Http\Controllers\admin\StatisticsController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\CommentController;
use App\Http\Controllers\admin\HoadonController;
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
    Route::get("/danh-muc",[CategoryController::class,"index"])->name('admin.category');//category
    Route::get("/sua-danh-muc/{id}",[CategoryController::class,"edit"])->name('admin.editcat');
    Route::get("/xoa-danh-muc/{id}",[CategoryController::class,"destroy"])->name('admin.delcat');
    Route::get("/san-pham",[AdminProductController::class,"index"])->name('admin.product');//product
    // brand
    Route::get("/thuong-hieu",[BrandController::class,"index"])->name('admin.brand');
    Route::get("/them-thuong-hieu",[BrandController::class,"create"])->name('admin.brand.create');
    Route::post("/thuong-hieu",[BrandController::class,"store"])->name('admin.brand.store');
    Route::get("/chi-tiet-thuong-hieu/{id}",[BrandController::class,"show"])->name('admin.brand.show');
    Route::get("/sua-thuong-hieu/{id}",[BrandController::class,"edit"])->name('admin.brand.edit');
    Route::put("/thuong-hieu/{id}",[BrandController::class,"update"])->name('admin.brand.update');
    Route::get("/xoa-thuong-hieu/{id}",[BrandController::class,"destroy"])->name('admin.brand.delete');

    // color
    Route::get("/mau-sac",[ColorController::class,"index"])->name('admin.color');
    Route::get("/them-mau-sac",[ColorController::class,"create"])->name('admin.color.create');
    Route::post("/mau-sac",[ColorController::class,"store"])->name('admin.color.store');
    Route::get("/chi-tiet-mau-sac/{id}",[ColorController::class,"show"])->name('admin.color.show');
    Route::get("/sua-mau-sac/{id}",[ColorController::class,"edit"])->name('admin.color.edit');
    Route::put("/mau-sac/{id}",[ColorController::class,"update"])->name('admin.color.update');
    Route::get("/xoa-mau-sac/{id}",[ColorController::class,"destroy"])->name('admin.color.delete');

    // size
    Route::get("/kich-co",[SizeController::class,"index"])->name('admin.size');
    Route::get("/them-kich-co",[SizeController::class,"create"])->name('admin.size.create');
    Route::post("/kich-co",[SizeController::class,"store"])->name('admin.size.store');
    Route::get("/chi-tiet-kich-co/{id}",[SizeController::class,"show"])->name('admin.size.show');
    Route::get("/sua-kich-co/{id}",[SizeController::class,"edit"])->name('admin.size.edit');
    Route::put("/kich-co/{id}",[SizeController::class,"update"])->name('admin.size.update');
    Route::get("/xoa-kich-co/{id}",[SizeController::class,"destroy"])->name('admin.size.delete');

    //thong ke
    Route::get("/thong-ke",[StatisticsController::class,"index"])->name('admin.statistics');

    //don hang
    Route::get("/don-hang",[OrderController::class,"index"])->name('admin.order');
    Route::get("/them-don-hang",[OrderController::class,"create"])->name('admin.order.create');
    Route::post("/don-hang",[OrderController::class,"store"])->name('admin.order.store');
    Route::get("/chi-tiet-don-hang/{id}",[OrderController::class,"show"])->name('admin.order.show');
    Route::get("/sua-don-hang/{id}",[OrderController::class,"edit"])->name('admin.order.edit');
    Route::put("/don-hang/{id}",[OrderController::class,"update"])->name('admin.order.update');
    Route::get("/xoa-don-hang/{id}",[OrderController::class,"destroy"])->name('admin.order.delete');

    //nguoi dung
    Route::get("/nguoi-dung",[UserController::class,"index"])->name('admin.user');
    Route::get("/them-nguoi-dung",[UserController::class,"create"])->name('admin.user.create');
    Route::post("/nguoi-dung",[UserController::class,"store"])->name('admin.user.store');
    Route::get("/chi-tiet-nguoi-dung/{id}",[UserController::class,"show"])->name('admin.user.show');
    Route::get("/sua-nguoi-dung/{id}",[UserController::class,"edit"])->name('admin.user.edit');
    Route::put("/nguoi-dung/{id}",[UserController::class,"update"])->name('admin.user.update');
    Route::get("/xoa-nguoi-dung/{id}",[UserController::class,"destroy"])->name('admin.user.delete');

    //binh luan
    Route::get("/binh-luan",[CommentController::class,"index"])->name('admin.comment');
    Route::get("/them-binh-luan",[CommentController::class,"create"])->name('admin.comment.create');
    Route::post("/binh-luan",[CommentController::class,"store"])->name('admin.comment.store');
    Route::get("/chi-tiet-binh-luan/{id}",[CommentController::class,"show"])->name('admin.comment.show');
    Route::get("/sua-binh-luan/{id}",[CommentController::class,"edit"])->name('admin.comment.edit');
    Route::put("/binh-luan/{id}",[CommentController::class,"update"])->name('admin.comment.update');
    Route::get("/xoa-binh-luan/{id}",[CommentController::class,"destroy"])->name('admin.comment.delete'); 
    
    Route::get("/hoa-don",[HoadonController::class,"index"])->name('admin.hoadon');
    Route::get("/hoa-don/chi-tiet/{id}",[HoadonController::class,"detail"])->name('admin.hoadon.detail');
    Route::post("/hoa-don/cap-nhat/{id}",[HoadonController::class,"update"])->name('admin.hoadon.update');
    Route::get("/hoa-don/xoa/{id}",[HoadonController::class,"destroy"])->name('admin.hoadon.delete');
});


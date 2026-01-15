<?php

use App\Http\Controllers\client\CheckoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ContactController;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductImageController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\VoucherController;
use App\Http\Controllers\admin\BlogCategoryController;
use App\Http\Controllers\client\UserAuthController;
use App\Http\Controllers\client\HomeController;
use App\Http\Controllers\client\ShopController;
use App\Http\Controllers\client\ShopCartController;
use App\Http\Controllers\admin\ColorController;
use App\Http\Controllers\admin\CommentController;
use App\Http\Controllers\admin\SizeController;
use App\Http\Controllers\client\ContactClientController;
use App\Http\Controllers\admin\BlogPostController;
use App\Http\Controllers\admin\FeedbackController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\Client\ProductCommentController;
use App\Http\Controllers\client\SearchProductController;
use App\Http\Controllers\client\ForgotPasswordController;
use App\Http\Controllers\client\CartController;
use App\Http\Controllers\client\FeedbackClientController;
use App\Http\Controllers\Client\ProductReviewController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\client\OrderHistoryController;
use App\Http\Controllers\Admin\StasticController;
use App\Http\Controllers\admin\DeliveryController;
use App\Http\Controllers\admin\PosOrderController;
use App\Http\Controllers\admin\PosController;
use App\Http\Controllers\admin\ProductDiscountController;
use App\Http\Controllers\client\BlogController;



// Route cho Admin
Route::prefix('admin')->group(function () {
    // Form login và xử lý login KHÔNG cần middleware
    Route::get('', [LoginController::class, 'LoginForm'])->name('admin.form');
    Route::post('login', [LoginController::class, 'login'])->name('admin.login');

    // Các route CẦN middleware
    Route::middleware(['admin.login'])->group(function () {
        Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');

        // Danh mục
        Route::prefix('category')->group(function () {
            Route::get('', [CategoryController::class, 'index'])->name('category.index');
            Route::get('create', [CategoryController::class, 'create'])->name('category.create');
            Route::post('store', [CategoryController::class, 'store'])->name('category.store');
            Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
            Route::post('update/{id}', [CategoryController::class, 'update'])->name('category.update');
            Route::get('delete/{id}', [CategoryController::class, 'destroy'])->name('category.delete');
        });

        // Sản phẩm
        Route::prefix('product')->group(function () {
            Route::get('', [ProductController::class, 'index'])->name('product.index');
            Route::get('create', [ProductController::class, 'create'])->name('product.create');
            Route::post('store', [ProductController::class, 'store'])->name('product.store');
            Route::get('show/{id}', [ProductController::class, 'show'])->name('product.show');
            Route::get('edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
            Route::post('update/{id}', [ProductController::class, 'update'])->name('product.update');
            Route::get('delete/{id}', [ProductController::class, 'destroy'])->name('product.delete');
            Route::get('trash', [ProductController::class, 'trash'])->name('product.trash');
            Route::get('restore/{id}', [ProductController::class, 'restore'])->name('product.restore');
            Route::get('force-delete/{id}', [ProductController::class, 'forceDelete'])->name('product.forceDelete');

            // Kho ảnh
            Route::prefix('image')->group(function () {
                Route::get('{id}', [ProductImageController::class, 'index'])->name('product.image.index');
                Route::post('store/{id}', [ProductImageController::class, 'store'])->name('product.image.store');
                Route::get('delete/{id}', [ProductImageController::class, 'destroy'])->name('product.image.delete');
            });
            // Màu sắc
            Route::prefix('color')->group(function () {
                Route::get('', [ColorController::class, 'index'])->name('product.color.index');
                Route::post('store', [ColorController::class, 'store'])->name('product.color.store');
                Route::get('delete/{id}', [ColorController::class, 'destroy'])->name('product.color.delete');
            });
            // Kích cỡ
            Route::prefix('size')->group(function () {
                Route::get('', [SizeController::class, 'index'])->name('product.size.index');
                Route::post('store', [SizeController::class, 'store'])->name('product.size.store');
                Route::get('delete/{id}', [SizeController::class, 'destroy'])->name('product.size.delete');
            });
        });
        // Quản lý thương hiệu
        Route::prefix('brand')->group(function () {
            Route::get('', [BrandController::class, 'index'])->name('brand.index');
            Route::post('store', [BrandController::class, 'store'])->name('brand.store');
            Route::get('delete/{id}', [BrandController::class, 'destroy'])->name('brand.delete');
        });



        // Quản lý người dùng
        Route::prefix('user')->group(function () {
            Route::get('', [UserController::class, 'index'])->name('user.index');
            Route::get('create', [UserController::class, 'create'])->name('user.create');
            Route::post('store', [UserController::class, 'store'])->name('user.store');
            Route::get('edit/{id}', [UserController::class, 'edit'])->name('user.edit');
            Route::post('update/{id}', [UserController::class, 'update'])->name('user.update');
            Route::get('delete/{id}', [UserController::class, 'destroy'])->name('user.delete');
            Route::get('show/{id}', [UserController::class, 'show'])->name('user.show');
        });
        // Quản lý voucher
        Route::prefix('voucher')->group(function () {
            Route::get('', [VoucherController::class, 'index'])->name('voucher.index');
            Route::get('create', [VoucherController::class, 'create'])->name('voucher.create');
            Route::post('store', [VoucherController::class, 'store'])->name('voucher.store');
            Route::get('edit/{id}', [VoucherController::class, 'edit'])->name('voucher.edit');
            Route::post('update/{id}', [VoucherController::class, 'update'])->name('voucher.update');
            Route::get('delete/{id}', [VoucherController::class, 'destroy'])->name('voucher.delete');
            Route::get('show/{id}', [VoucherController::class, 'show'])->name('voucher.show');
        });
        // Quản lý đơn giao hàng
        Route::prefix('delivery')->group(function () {
            Route::get('', [DeliveryController::class, 'index'])->name('delivery.index');
            Route::get('show/{id}', [DeliveryController::class, 'show'])->name('delivery.show');
            Route::post('accept/{id}', [DeliveryController::class, 'accept'])->name('delivery.accept');
            Route::get('cancel/{id}', [DeliveryController::class, 'cancel'])->name('delivery.cancel');
            Route::post('confirm/{id}', [DeliveryController::class, 'confirmDelivery'])->name('delivery.confirm');
        });
        // Quản lý contact
        Route::prefix('contact')->group(function () {
            Route::get('', [ContactController::class, 'index'])->name('contact.index');
            Route::get('delete/{id}', [ContactController::class, 'delete'])->name('contact.delete');
            Route::get('show/{id}', [ContactController::class, 'show'])->name('contact.show');
            Route::get('edit/{id}', [ContactController::class, 'edit'])->name('contact.edit');
            Route::get('update/{id}', [ContactController::class, 'update'])->name('contact.update');
        });
        // Quản lý Danh mục bài viết
        Route::prefix('blog-category')->group(function () {
            Route::get('', [BlogCategoryController::class, 'index'])->name('blog_category.index');
            Route::get('create', [BlogCategoryController::class, 'create'])->name('blog_category.create');
            Route::post('store', [BlogCategoryController::class, 'store'])->name('blog_category.store');
            Route::get('edit/{id}', [BlogCategoryController::class, 'edit'])->name('blog_category.edit');
            Route::post('update/{id}', [BlogCategoryController::class, 'update'])->name('blog_category.update');
            Route::get('delete/{id}', [BlogCategoryController::class, 'destroy'])->name('blog_category.delete');
        });

        // Quản lý bình luận
        Route::prefix('comment')->group(function () {
            Route::get('', [CommentController::class, 'index'])->name('comment.index');
            Route::get('delete/{id}', [CommentController::class, 'delete'])->name('comment.delete');
            Route::get('show/{id}', [CommentController::class, 'show'])->name('comment.show');
            Route::get('edit/{id}', [CommentController::class, 'edit'])->name('comment.edit');
            Route::get('update/{id}', [CommentController::class, 'update'])->name('comment.update');
        });

        // Quản lý Blog
        Route::prefix('blog-post')->group(function () {
            Route::get('', [BlogPostController::class, 'index'])->name('blog_post.index');
            Route::get('create', [BlogPostController::class, 'create'])->name('blog_post.create');
            Route::post('store', [BlogPostController::class, 'store'])->name('blog_post.store');
            Route::get('show/{id}', [BlogPostController::class, 'show'])->name('blog_post.show');
            Route::get('edit/{id}', [BlogPostController::class, 'edit'])->name('blog_post.edit');
            Route::post('update/{id}', [BlogPostController::class, 'update'])->name('blog_post.update');
            Route::get('delete/{id}', [BlogPostController::class, 'destroy'])->name('blog_post.delete');
        });
        // Quản lý Order
        Route::prefix('order')->group(function () {
            Route::get('', [OrderController::class, 'index'])->name('order.index');
            Route::get('show/{id}', [OrderController::class, 'show'])->name('order.show');
            Route::get('delete/{id}', [OrderController::class, 'delete'])->name('order.delete');
            Route::put('{id}/status', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
            Route::post('{id}/refund', [OrderController::class, 'markRefunded'])->name('order.markRefunded');
        });
        // Quản lý feedback
        Route::prefix('feedback')->group(function () {
            Route::get('', [FeedbackController::class, 'index'])->name('feedback.index');
            Route::get('delete/{id}', [FeedbackController::class, 'delete'])->name('feedback.delete');
            Route::get('show/{id}', [FeedbackController::class, 'show'])->name('feedback.show');
            Route::get('edit/{id}', [FeedbackController::class, 'edit'])->name('feedback.edit');
            Route::get('update/{id}', [FeedbackController::class, 'update'])->name('feedback.update');
        });

        // Quản lý giảm giá sản phẩm
        Route::prefix('discounts')->group(function () {
            Route::get('', [ProductDiscountController::class, 'index'])->name('admin.discounts.index');
            Route::get('create', [ProductDiscountController::class, 'create'])->name('admin.discounts.create');
            Route::post('', [ProductDiscountController::class, 'store'])->name('admin.discounts.store');
            Route::get('{discount}', [ProductDiscountController::class, 'show'])->name('admin.discounts.show');
            Route::get('{discount}/edit', [ProductDiscountController::class, 'edit'])->name('admin.discounts.edit');
            Route::put('{discount}', [ProductDiscountController::class, 'update'])->name('admin.discounts.update');
            Route::delete('{discount}', [ProductDiscountController::class, 'destroy'])->name('admin.discounts.destroy');
            Route::patch('{discount}/toggle-status', [ProductDiscountController::class, 'toggleStatus'])->name('admin.discounts.toggle-status');
        });
    });
});

// Route cho Trang chủ
Route::prefix('/')->group(function () {
    Route::get('', [HomeController::class, 'index'])->name('home.index');
    Route::get('search', [HomeController::class, 'search'])->name('home.search');
    // Route cho Shop
    Route::prefix('shop')->group(function () {
        Route::get('', [ShopController::class, 'index'])->name('shop.index');
        Route::get('{name}/{id}', [ShopController::class, 'show'])->name('shop.product.show');
        Route::post('add-to-cart/{id}', [ShopController::class, 'addToCart'])->name('shop.product.addToCart');
        Route::post('{id}/comment', [ShopController::class, 'submitComment'])->name('product.comment');
        Route::post('/product/{id}/review', [ShopController::class, 'submitReview'])->name('product.review.store');
        Route::post('/review/{id}', [ProductReviewController::class, 'store'])->name('shop.submitReview');



        // Route cho giỏ hàng
        Route::prefix('cart')->group(function () {
            Route::get('', [ShopCartController::class, 'index'])->name('shop.cart.index');
            Route::get('remove/{id}', [ShopCartController::class, 'removeCart'])->name('cart.remove');
            Route::post('/cart/update-quantity', [ShopCartController::class, 'updateQuantity'])->name('cart.updateQuantity');
        });
        //route contact ở phía client
        Route::prefix('contact')->group(function () {
            Route::get('', [ContactClientController::class, 'index'])->name('shop.contact.index');
            Route::post('', [ContactClientController::class, 'submit'])->name('shop.contact.submit');
        });
        Route::prefix('feedback')->group(function () {
            Route::get('', [FeedbackClientController::class, 'index'])->name('shop.feedback.index');
            Route::post('', [FeedbackClientController::class, 'submit'])->name('shop.feedback.submit');
        });
        // Route cho nhập voucher
        Route::post('/cart/apply-voucher', [ShopCartController::class, 'applyVoucher'])->name('cart.applyVoucher');
        Route::post('/cart/remove-voucher', [ShopCartController::class, 'removeVoucher'])->name('cart.removeVoucher');
        //route tìm kiếm ở phía client
        Route::get('/search', [SearchProductController::class, 'search'])->name('product.search');
        // route cho bình luận ở client
        Route::post('/shop/comment/{id}', [ProductCommentController::class, 'store'])->name('product.comment.store');
    });
    // Check out cline
    Route::prefix('checkout')->group(function () {
        Route::get('', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('', [CheckoutController::class, 'submit'])->name('checkout.submit');
        Route::post('vnpay', [CheckoutController::class, 'vnpay'])->name('checkout.vnpay');
        Route::get('success/{orderId}', [CheckoutController::class, 'success'])->name('checkout.success');
        Route::get('vnpay-return', [CheckoutController::class, 'vnpayReturn'])->name('checkout.vnpay_return');
        Route::post('vnpay-ipn', [CheckoutController::class, 'vnpayIpn'])->name('vnpay.ipn');
    });

    // Route cho blog
    Route::prefix('blog')->group(function () {
        Route::get('', [BlogController::class, 'index'])->name('blog.index');
    });
});
// Route cho Login của người dùng
Route::get('login', [UserAuthController::class, 'showLoginForm'])->name('user.login');
Route::post('login', [UserAuthController::class, 'login'])->name('user.login.submit');
Route::get('logout', [UserAuthController::class, 'logout'])->name('user.logout');
Route::get('profile', [UserAuthController::class, 'showProfile'])->name('user.profile.show');
Route::get('edit', [UserAuthController::class, 'editProfile'])->name('user.profile.edit');
Route::post('update', [UserAuthController::class, 'updateProfile'])->name('user.profile.update');
// Route cho đăng ký tài khoản
Route::get('register', [UserAuthController::class, 'showRegisterForm'])->name('user.register');
Route::post('register', [UserAuthController::class, 'register'])->name('user.register.submit');


// Route cho quên mật khẩu
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('client.account.forgot-password.form');
Route::post('/forgot-password', [ForgotPasswordController::class, 'handleForm'])->name('client.account.forgot-password.send');
// Route cho xác minh OTP và đặt lại mật khẩu
Route::get('/verify-otp', [ForgotPasswordController::class, 'showOtpForm'])->name('client.account.verify-otp-form');
Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('client.account.verify-otp');
Route::get('/reset-password', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('client.account.reset-password-form');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('client.account.reset-password');

// Route cho lịch sử mua hàng
Route::get('/profile/orders', [OrderHistoryController::class, 'history'])->name('profile.orders');
Route::get('/profile/orders/{id}', [OrderHistoryController::class, 'show'])->name('profile.orders.show');
Route::post('/profile/orders/{id}/cancel', [OrderHistoryController::class, 'cancel'])->name('profile.orders.cancel');
// Route cho thống kê
Route::get('/admin/stastic', [StasticController::class, 'index']);
Route::get('/admin/statistics/revenue', [StasticController::class, 'getDateRangeRevenue'])->name('admin.statistics.revenue');
Route::get('/admin/statistics/date-range', [StasticController::class, 'getDateRangeStatistics'])->name('admin.statistics.date-range');

// Bán hàng tại quầy
Route::prefix('pos')->group(function () {
    Route::get('', [PosOrderController::class, 'index'])->name('pos.index');
    Route::post('/store', [PosOrderController::class, 'store'])->name('pos.store');
    Route::get('/edit/{id}', [PosOrderController::class, 'edit'])->name('pos.edit');
    Route::post('/add/{id}', [PosOrderController::class, 'addItem'])->name('pos.add');
    Route::put('/update/{id}', [PosOrderController::class, 'update'])->name('pos.update');
    Route::get('/delete/{id}', [PosOrderController::class, 'deleteItem'])->name('pos.deleteItem');
    Route::get('/pos/bill/{id}', [PosOrderController::class, 'bill'])->name('pos.bill');
    Route::get('/history', [PosOrderController::class, 'history'])->name('pos.history');
    Route::post('/check-voucher', [PosOrderController::class, 'checkVoucher'])->name('pos.checkVoucher');

    // Thanh toán VNPAY
    Route::get('/vnpay-return', [PosOrderController::class, 'vnpayReturn'])->name('vnpay.return');
});

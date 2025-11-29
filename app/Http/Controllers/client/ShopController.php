<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Comment;
use App\Models\Review;
use App\Models\Size;
use App\Models\Color;
use App\Models\Brand;



class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $sizes = Size::all();
        $colors = Color::all();
        $brands = Brand::all();

        $query = Product::query()->where('status', 1);

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }
        if ($request->filled('color')) {
            $query->whereHas('variants', function($q) use ($request) {
                $q->where('color_id', $request->color);
            });
        }
        if ($request->filled('sizes')) {
            $sizes = $request->sizes;
            $query->whereHas('variants', function($q) use ($sizes) {
                $q->whereIn('size_id', $sizes);
            });
        }
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case '1': $query->orderBy('price', 'asc'); break;
                case '2': $query->orderBy('price', 'desc'); break;
                case '3': $query->orderBy('created_at', 'desc'); break;
                default: $query->orderBy('id', 'asc');
            }
        }

        $products = $query->paginate(12)->withQueryString();

        return view('client.shop.index', compact('products', 'categories', 'sizes', 'colors', 'brands'));
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        if (empty($query)) {
            return redirect()->route('shop.index');
        }

        $products = Product::where('name', 'like', "%$query%")->get();
        return view('client.shop.search', compact('products'));
    }

    // ShopController.php
    public function show($name, $id)
    {
        $product = Product::findOrFail($id);
        $variants = $product->variants->map(function ($v) {
            return [
                'id' => $v->id,
                'color_id' => $v->color->id,
                'color_name' => $v->color->name,
                'size_id' => $v->size->id,
                'size_value' => $v->size->value,
                'stock' => $v->stock,
                'price' => $v->price,
            ];
        })->values()->all();
        // Lấy các sản phẩm cùng danh mục, loại trừ sản phẩm hiện tại
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(8)
            ->get();

        // Lấy gallery nếu có
        $gallery = ProductImage::where('product_id', $product->id)->get();
        $product->gallery = $gallery;
        $commentsRaw = Comment::where('product_id', $product->id)
            ->where('status', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $reviews = Review::where('product_id', $product->id)->get();

        // Gắn rating vào từng comment nếu user_id khớp
        $comments = $commentsRaw->map(function ($comment) use ($reviews) {
        $comment->rating = optional($reviews->firstWhere('user_id', $comment->user_id))->rating;
        return $comment;
        });
        $commentCount = $comments->count();
        $reviews = Review::where('product_id', $product->id)->get();
        $averageRating = $reviews->avg('rating') ?? 0;
        $existingRating = null;
        if (session('user')) {
        $userId = session('user')['id'];
        $existingRating = Review::where('product_id', $product->id)
        ->where('user_id', $userId)
        ->value('rating');
        }

        return view('client.shop.product-detail', compact('product', 'relatedProducts', 'variants', 'comments', 'commentCount', 'averageRating', 'reviews', 'existingRating'));
    }

    public function addToCart(Request $request, $id)
    {
        if (!session()->has('user')) {
            return redirect()->route('user.login')->with('error', 'Bạn cần đăng nhập để mua hàng.');
        }

        $product = Product::findOrFail($id);
        $quantity = $request->input('quantity', 1);
        $variantId = $request->input('product_variant_id', null);

        // 1. Lấy hoặc tạo cart cho user
        $cart = Cart::firstOrCreate([
            'user_id' => session('user.id'),
        ]);

        // 2. Kiểm tra sản phẩm (và biến thể) đã có trong cart chưa
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_variant_id', $variantId)
            ->first();

        if ($cartItem) {
            // Nếu đã có thì tăng số lượng
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Nếu chưa có thì tạo mới
            CartItem::create([
                'user_id' => session('user.id'),
                'cart_id' => $cart->id,
                'product_variant_id' => $variantId ?? null,
                'quantity' => $quantity,
            ]);
        }
        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }
}

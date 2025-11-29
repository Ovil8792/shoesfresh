<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::now();
        
        // Lấy danh sách sản phẩm đang giảm giá
        $products = Product::whereHas('discounts', function($query) use ($now) {
            $query->where('is_active', true)
                  ->where('start_date', '<=', $now)
                  ->where('end_date', '>=', $now);
        })->with(['discounts' => function($query) use ($now) {
            $query->where('is_active', true)
                  ->where('start_date', '<=', $now)
                  ->where('end_date', '>=', $now);
        }])->paginate(12);

        return view('client.blog.index', compact('products'));
    }
}

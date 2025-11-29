<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ProductReviewController extends Controller
{
    public function store(Request $request, $id)
{
    $user = session('user');
// cái này
    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Vui lòng đăng nhập để đánh giá.'
        ], 401);
    }

    $validated = $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:1000',
    ]);

    Review::updateOrCreate(
        ['product_id' => $id, 'user_id' => $user['id']],
        [
            'rating' => $validated['rating'],
            'cmt' => $validated['comment'] ?? null,
        ]
    );

    // Tính lại rating trung bình và lượt đánh giá
    $average = Review::where('product_id', $id)->avg('rating');
    $count = Review::where('product_id', $id)->count();

    return response()->json([
        'success' => true,
        'message' => 'Đánh giá của bạn đã được lưu.',
        'average_rating' => round($average, 1),
        'review_count' => $count
    ]);
}
}

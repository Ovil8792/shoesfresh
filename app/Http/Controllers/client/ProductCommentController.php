<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;

class ProductCommentController extends Controller
{
    public function store(Request $request, $id)
{
    $user = session('user');

    if (!$user) {
        if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
            return response()->json([
                'status' => false,
                'message' => 'Vui lòng đăng nhập để bình luận.'
            ], 401);
        }
        return redirect()->route('user.login')->with('error', 'Vui lòng đăng nhập để bình luận.');
    }

    // Kiểm tra xem user đã mua sản phẩm trong đơn hàng đã hoàn thành chưa
    $userModel = User::find($user['id']);
    if (!$userModel || !$userModel->hasPurchasedProductInCompletedOrder($id)) {
        if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn chỉ có thể bình luận sản phẩm sau khi đã mua và nhận hàng thành công.'
            ], 403);
        }
        return back()->with('error', 'Bạn chỉ có thể bình luận sản phẩm sau khi đã mua và nhận hàng thành công.');
    }

    $request->validate([
        'cmt' => 'required|string|max:1000',
    ]);

    $forbiddenWords = ['dm', 'đm', 'vcl', 'cc'];
    $commentText = strtolower($request->cmt);
    $isViolated = false;

    foreach ($forbiddenWords as $word) {
        if (str_contains($commentText, $word)) {
            $isViolated = true;
            break;
        }
    }
    // cái này

    $comment = Comment::create([
        'product_id' => $id,
        'name'       => $user['name'],
        'email'      => $user['email'],
        'cmt'        => $request->cmt,
        'status'     => $isViolated ? false : true,
        'user_id'    => $user['id'],
    ]);

    // Nếu là request AJAX hoặc JSON, trả JSON để JS xử lý
    if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
        return response()->json([
            'status' => !$isViolated,
            'message' => $isViolated
                ? 'Bình luận chứa từ ngữ không phù hợp và đang chờ kiểm duyệt.'
                : 'Bình luận đã được gửi.',
            'comment' => !$isViolated ? [
                'name' => $comment->name,
                'created_at' => $comment->created_at->format('d/m/Y H:i'),
                'cmt' => $comment->cmt
            ] : null
        ]);
    }

    // Nếu không phải AJAX thì xử lý bình thường
    return back()->with('success', $isViolated
        ? 'Bình luận chứa từ ngữ không phù hợp và đang chờ kiểm duyệt.'
        : 'Bình luận đã được gửi.');
}

}

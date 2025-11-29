<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class ProductCommentController extends Controller
{
    public function store(Request $request, $id)
{
    $user = session('user');

    if (!$user) {
        if ($request->ajax()) {
            return response()->json([
                'status' => false,
                'message' => 'Vui lòng đăng nhập để bình luận.'
            ], 401);
        }
        return redirect()->route('user.login')->with('error', 'Vui lòng đăng nhập để bình luận.');
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

    // Nếu là request AJAX, trả JSON để JS xử lý
    if ($request->ajax()) {
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

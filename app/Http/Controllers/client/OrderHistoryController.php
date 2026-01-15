<?php

namespace App\Http\Controllers\client;
use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Models\Comment;
use App\Models\Review;
use Illuminate\Http\Request;


class OrderHistoryController extends Controller
{
    public function history()
    {
        $orders = Order::where('user_id', session('user.id'))
            ->orderByDesc('created_at')
            ->get();
        return view('client.orders.order-history', compact('orders'));
    }
    public function show($id)
{
    $order = Order::with(['orderItems.variant.product', 'orderItems.variant.color', 'orderItems.variant.size'])
        ->where('user_id', session('user.id'))
        ->findOrFail($id);
    
    // Lấy comments và reviews cho các sản phẩm trong đơn hàng
    $productIds = $order->orderItems->pluck('variant.product_id')->unique()->filter();
    $comments = Comment::whereIn('product_id', $productIds)
        ->where('status', true)
        ->where('user_id', session('user.id'))
        ->get()
        ->groupBy('product_id');
    
    $reviews = Review::whereIn('product_id', $productIds)
        ->where('user_id', session('user.id'))
        ->get()
        ->keyBy('product_id');
    
    // Kiểm tra xem đơn hàng đã hoàn thành chưa
    $canComment = $order->status === 'completed';
    
    return view('client.orders.order-detail', compact('order', 'comments', 'reviews', 'canComment'));
}
        public function cancel(Request $request, $id)
    {
        $order = Order::where('user_id', session('user.id'))->findOrFail($id);
        if ($order->status != 'processing') {
            return redirect()->back()->with('error', 'Đơn hàng không thể hủy.');
        }
        
        // Hoàn lại usage_limit của voucher nếu đơn hàng có voucher
        if ($order->voucher_id) {
            $voucher = \App\Models\Voucher::find($order->voucher_id);
            if ($voucher) {
                $voucher->usage_limit += 1;
                $voucher->used_count = max(0, $voucher->used_count - 1);
                $voucher->save();
            }
        }
        
        $order->status = 'cancelled';
        $order->cancel_reason = $request->input('cancel_reason');
        $order->save();
        return redirect()->route('profile.orders')->with('success', 'Đã hủy đơn hàng!');
    }

}


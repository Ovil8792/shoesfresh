<?php

namespace App\Http\Controllers\client;
use App\Http\Controllers\Controller;

use App\Models\Order;
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
    $order = Order::with(['orderItems.product', 'orderItems.variant'])
        ->where('user_id', session('user.id'))
        ->findOrFail($id);
    return view('client.orders.order-detail', compact('order'));
}
        public function cancel(Request $request, $id)
    {
        $order = Order::where('user_id', session('user.id'))->findOrFail($id);
        if ($order->status != 'processing') {
            return redirect()->back()->with('error', 'Đơn hàng không thể hủy.');
        }
        $order->status = 'cancelled';
        $order->cancel_reason = $request->input('cancel_reason');
        $order->save();
        return redirect()->route('profile.orders')->with('success', 'Đã hủy đơn hàng!');
    }

}


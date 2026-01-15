<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\Models\Delivery;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function index()
    {
        // Lấy tất cả đơn hàng có trạng thái 'delivering' và đã được giao cho shipper
        $deliveries = Delivery::with(['order', 'user'])
            ->whereHas('order', function($query) {
                $query->where('status', 'delivering');
            })
            ->get();
            
        // Lấy danh sách đơn hàng có trạng thái 'delivering' nhưng chưa có shipper nhận
        $availableDeliveries = Order::where('status', 'delivering')
            ->whereDoesntHave('delivery')
            ->get();
            
        return view('admin.delivery.index', compact('deliveries', 'availableDeliveries'));
    }

    public function show($id)
    {
        // Chuyển hướng đến trang chi tiết đơn hàng
        return redirect()->route('order.show', $id);
    }
    public function accept($id)
    {
        $adminId = session('admin')['id'];

        // Nhận đơn hàng - tạo delivery record nếu chưa có
        $order = Order::findOrFail($id);
        
        $delivery = Delivery::firstOrCreate(
            ['order_id' => $id],
            [
                'user_id' => $adminId,
                'status' => 'accepted',
            ]
        );
        
        if (!$delivery->user_id) {
            $delivery->user_id = $adminId;
        $delivery->status = 'accepted';
        $delivery->save();
        }
        
        return redirect()->route('delivery.index')->with('success', 'Đơn hàng đã được nhận thành công.');
    }
    
    public function confirmDelivery($id)
    {
        $order = Order::findOrFail($id);
        
        // Chỉ cho phép xác nhận đơn hàng đang giao
        if ($order->status !== Order::STATUS_DELIVERING) {
            return redirect()->route('delivery.index')->with('error', 'Chỉ có thể xác nhận đơn hàng đang giao.');
        }
        
        // Chuyển trạng thái sang completed
        $order->status = Order::STATUS_COMPLETED;
        $order->save();
        
        return redirect()->route('delivery.index')->with('success', 'Xác nhận giao hàng thành công!');
    }
    public function cancel($id)
    {
        // Hủy đơn hàng
        $delivery = Delivery::findOrFail($id);
        $delivery->status = '';
        $delivery->user_id = null;
        $delivery->save();
        return redirect()->route('delivery.index')->with('success', 'Đơn hàng đã được hủy thành công.');
    }
}

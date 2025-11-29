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
        //
        $deliveries = Delivery::all();
        return view('admin.delivery.index', compact('deliveries'));
    }

    public function show($id)
    {
        //
        $order = Order::with('orderItems')->findOrFail($id);
        return view('admin.delivery.detail', compact('order'));
    }
    public function accept($id)
    {
        $adminId = session('admin')['id'];

        // Nhận đơn hàng
        $delivery = Delivery::findOrFail($id);
        $delivery->status = 'accepted';
        $delivery->user_id = $adminId;
        $delivery->created_at = now();
        $delivery->save();
        return redirect()->route('delivery.index')->with('success', 'Đơn hàng đã được nhận thành công.');
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

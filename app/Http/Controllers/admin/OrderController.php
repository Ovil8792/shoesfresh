<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();

        // Tìm kiếm theo keyword
        if ($request->filled('keyword')) {
            $kw = trim($request->keyword);
            $kwLike   = '%'.$kw.'%';
            $kwDigits = preg_replace('/\D+/', '', $kw);

            $query->where(function ($q) use ($kwLike, $kwDigits) {
                $q->where('name', 'like', $kwLike)
                    ->orWhere('email', 'like', $kwLike)
                    ->orWhere('phone', 'like', $kwLike)
                    ->orWhere('shipping_address', 'like', $kwLike);

                if ($kwDigits !== '') {
                    $q->orWhereRaw(
                        "REPLACE(REPLACE(REPLACE(phone,' ',''),'.',''),'-','') LIKE ?",
                        ['%'.$kwDigits.'%']
                    );
                }
            });
        }

        // ===== Lọc trạng thái =====
        // Hợp lệ (đồng bộ với Model Order)
        $allowed = [
            Order::STATUS_PROCESSING,
            Order::STATUS_PENDING,
            Order::STATUS_PAID,
            Order::STATUS_DELIVERING, // dùng delivering cho thống nhất
            Order::STATUS_COMPLETED,
            Order::STATUS_CANCELLED,
        ];

        // Không có tham số => mặc định processing
        if (!$request->has('status')) {
            $status = Order::STATUS_PROCESSING;
            $query->where('status', $status);
        } else {
            // Có tham số: '' = tất cả (bỏ lọc); giá trị khác => lọc theo
            $status = (string) $request->query('status', '');
            if ($status !== '' && in_array($status, $allowed, true)) {
                $query->where('status', $status);
            }
        }

        $orders = $query->latest()->paginate(15)->appends($request->query());

        // Options cho dropdown ("" = tất cả)
        $statusOptions = [
            ''                          => 'Tất cả trạng thái',
            Order::STATUS_PROCESSING     => 'Đang xử lý',
            Order::STATUS_PENDING        => 'Pending',
            Order::STATUS_PAID           => 'Đã thanh toán',
            Order::STATUS_DELIVERING     => 'Đang giao',
            Order::STATUS_COMPLETED      => 'Hoàn tất',
            Order::STATUS_CANCELLED      => 'Đã hủy',
        ];

        return view('admin.order.index', compact('orders', 'status', 'statusOptions'));
    }

    public function show($id)
    {
        $order = Order::with([
            'orderItems.variant.product.category',
            'user:id,name',
            'voucher:id,code',
            'delivery',
        ])->findOrFail($id);

        return view('admin.order.show', compact('order'));
    }

    public function edit(Order $order)
    {
        //
    }

    public function updateStatus(Request $request, $id)
    {
        $validStatuses = implode(',', [
            Order::STATUS_PROCESSING,
            Order::STATUS_PENDING,
            Order::STATUS_PAID,
            Order::STATUS_DELIVERING,
            Order::STATUS_COMPLETED,
            Order::STATUS_CANCELLED,
        ]);

        $request->validate([
            'status' => 'required|in:'.$validStatuses,
            'cancel_reason' => 'required_if:status,'.Order::STATUS_CANCELLED.'|nullable|string|max:255',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        $order->cancel_reason = $request->input('cancel_reason');
        $order->save();

        return back()->with('success', 'Cập nhật trạng thái thành công!');
    }

    public function delete($id)
    {
        $order = Order::findOrFail($id);
        $order->orderItems()->delete();
        $order->delete();

        return redirect()->route('order.index')->with('success', 'Đã xoá đơn hàng thành công.');
    }
}

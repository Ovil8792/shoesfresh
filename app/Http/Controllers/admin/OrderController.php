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
            Order::STATUS_CONFIRMED,
            Order::STATUS_DELIVERING, // dùng delivering cho thống nhất
            Order::STATUS_COMPLETED,
            Order::STATUS_CANCELLED,
        ];

        // Mặc định hiển thị tất cả đơn hàng (trừ delivering - đơn đang giao sẽ hiển thị ở delivery)
        $status = (string) $request->query('status', '');
        
        // Loại bỏ đơn hàng có trạng thái delivering khỏi danh sách order
        $query->where('status', '!=', Order::STATUS_DELIVERING);
        
        // Nếu có chọn lọc trạng thái thì mới thêm điều kiện where
        if ($status !== '' && in_array($status, $allowed, true)) {
            $query->where('status', $status);
        }

        $orders = $query->latest()->paginate(15)->appends($request->query());

        // Options cho dropdown ("" = tất cả, loại bỏ delivering vì đã ẩn)
        $statusOptions = [
            ''                          => 'Tất cả trạng thái',
            Order::STATUS_PROCESSING     => 'Đang xử lý',
            Order::STATUS_CONFIRMED      => 'Đã xác nhận',
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
            Order::STATUS_CONFIRMED,
            Order::STATUS_DELIVERING,
            Order::STATUS_COMPLETED,
            Order::STATUS_CANCELLED,
        ]);

        $request->validate([
            'status' => 'required|in:'.$validStatuses,
            'cancel_reason' => 'required_if:status,'.Order::STATUS_CANCELLED.'|nullable|string|max:255',
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status; // Lưu trạng thái cũ
// <<<<<<< HEAD
//         $newStatus = $request->input('status');

//         // Kiểm tra: trạng thái "đã xác nhận" không thể chuyển về "đang xử lý"
//         if ($oldStatus == Order::STATUS_CONFIRMED && $newStatus == Order::STATUS_PROCESSING) {
//             return redirect()->back()->with('error', 'Đơn hàng đã xác nhận không thể chuyển về trạng thái "Đang xử lý".');
//         }

//         // Kiểm tra: nếu đơn hàng đang ở trạng thái "đang giao", chỉ cho phép chuyển sang "hoàn tất" hoặc "đã hủy"
//         if ($oldStatus == Order::STATUS_DELIVERING) {
//             if (!in_array($newStatus, [Order::STATUS_COMPLETED, Order::STATUS_CANCELLED], true)) {
//                 return redirect()->back()->with('error', 'Đơn hàng đang giao chỉ có thể chuyển sang "Hoàn tất" hoặc "Đã hủy".');
//             }
//         }

//         // Kiểm tra: chỉ có trạng thái "đang giao" mới có thể chuyển sang "hoàn tất"
//         if ($newStatus == Order::STATUS_COMPLETED && $oldStatus != Order::STATUS_DELIVERING) {
//             return redirect()->back()->with('error', 'Chỉ có đơn hàng đang giao mới có thể chuyển sang trạng thái "Hoàn tất".');
//         }

//         $order->status = $newStatus;
// =======
        
        // Nếu chuyển sang trạng thái cancelled và đơn hàng có voucher, hoàn lại usage_limit
        if ($request->input('status') === Order::STATUS_CANCELLED && $oldStatus !== Order::STATUS_CANCELLED && $order->voucher_id) {
            $voucher = \App\Models\Voucher::find($order->voucher_id);
            if ($voucher) {
                $voucher->usage_limit += 1;
                $voucher->used_count = max(0, $voucher->used_count - 1);
                $voucher->save();
            }
        }
        
        $order->status = $request->input('status');
        $order->cancel_reason = $request->input('cancel_reason');
        $order->save();

        // Nếu chuyển sang trạng thái delivering, redirect về delivery.index
        if ($order->status === Order::STATUS_DELIVERING) {
            return redirect()->route('delivery.index')->with('success', 'Đơn hàng đã chuyển sang trạng thái đang giao!');
        }

        // Chuyển hướng về trang danh sách đơn hàng với trạng thái mới
        $redirectUrl = route('order.index') . '?status=' . $order->status;

        return redirect($redirectUrl)->with('success', 'Cập nhật trạng thái thành công!');
    }

    public function delete($id)
    {
        $order = Order::findOrFail($id);
        $order->orderItems()->delete();
        $order->delete();

        return redirect()->route('order.index')->with('success', 'Đã xoá đơn hàng thành công.');
    }

    public function markRefunded($id)
    {
        $order = Order::findOrFail($id);
        
        // Chỉ cho phép đánh dấu hoàn tiền cho đơn hàng đã hủy và thanh toán bằng VNPay
        if ($order->status !== Order::STATUS_CANCELLED) {
            return redirect()->back()->with('error', 'Chỉ có thể đánh dấu hoàn tiền cho đơn hàng đã hủy.');
        }
        
        $pm = strtoupper((string) $order->payment_method);
        if ($pm !== 'VNPAY') {
            return redirect()->back()->with('error', 'Chỉ có thể hoàn tiền cho đơn hàng thanh toán bằng VNPay.');
        }
        
        $order->refunded = true;
        $order->save();
        
        return redirect()->back()->with('success', 'Đã đánh dấu hoàn tiền thành công!');
    }
}

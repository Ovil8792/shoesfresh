<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PosOrder;
use App\Models\PosOrderItem;
use App\Models\ProductVariant;
use App\Models\Voucher;
use Illuminate\Http\Request;

class PosOrderController extends Controller
{
    public function index()
    {
        $posOrder = PosOrder::where('status', 'Đang chờ')->get();
        return view('admin.pos.list', compact('posOrder'));
    }

    public function edit(Request $request)
    {
        $vouchers = Voucher::all();
        $productVariant = ProductVariant::all();
        $posOrderItem = PosOrderItem::where('pos_order_id', $request->id)->get();
        $posOrder = PosOrder::findOrFail($request->id);
        return view('admin.pos.update', compact('productVariant', 'posOrderItem', 'posOrder', 'vouchers'));
    }

    public function store(Request $request)
    {
        $order = new PosOrder();
        $order->staff_id = 3;
        $order->customer_id = 1;
        $order->total_amount = 0;
        $order->note = 'Hoá đơn tạm';
        $order->payment_method = 'null';
        $order->created_at = now();
        $order->status = 'Đang chờ';
        $order->updated_at = now();
        $order->save();
        return redirect()->route('pos.index');
    }

    public function addItem(Request $request, $id)
    {
        $posOrderId = $request->input('pos_order_id');
        $productVariantId = $request->input('product_variant_id');

        $existingItem = PosOrderItem::where('pos_order_id', $posOrderId)
            ->where('product_variant_id', $productVariantId)
            ->first();

        if ($existingItem) {
            $existingItem->quantity += 1;
            $existingItem->save();
        } else {
            PosOrderItem::create([
                'pos_order_id' => $posOrderId,
                'product_variant_id' => $productVariantId,
                'quantity' => 1,
                'price' => ProductVariant::find($productVariantId)->price,
            ]);
        }
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $order = PosOrder::findOrFail($id);

        // Gán giá trị mặc định nếu không có giảm giá
        $discount = is_numeric($request->discount_applied) ? $request->discount_applied : 0;
        $totalDue = $request->total_amount - $discount;

        // Validate nếu là tiền mặt
        if ($request->payment_method === 'Tiền mặt') {
            $request->validate([
                'cash_given' => [
                    'required',
                    'numeric',
                    'min:0',
                    function ($attribute, $value, $fail) use ($totalDue) {
                        if ($value < $totalDue) {
                            $fail('Số tiền khách đưa không đủ để thanh toán. Vui lòng nhập lại!');
                        }
                    }
                ],
            ], [
                'cash_given.required' => 'Vui lòng nhập số tiền khách đưa!',
            ]);
        }

        // Cập nhật đơn hàng
        $order->total_amount     = $request->total_amount;
        $order->discount_applied = $discount;
        $order->payment_method   = $request->payment_method;
        $order->updated_at       = now();

        // Xử lý theo phương thức thanh toán
        if ($order->payment_method === 'Tiền mặt') {
            $order->status = 'Đã thanh toán';
            $order->save();

            // Trừ kho
            $items = PosOrderItem::where('pos_order_id', $order->id)->get();
            foreach ($items as $item) {
                $variant = ProductVariant::find($item->product_variant_id);
                if ($variant) {
                    $variant->stock = max(0, $variant->stock - $item->quantity);
                    $variant->save();
                }
            }

            return redirect()->route('pos.bill', $order->id);
        }

        if (in_array($order->payment_method, ['Chuyển khoản', 'VNPAY'])) {
            $order->status = 'Chờ thanh toán';
            $order->save();

            // Tạo URL thanh toán VNPAY
            $vnp_TmnCode    = "2LKOA8F9";
            $vnp_HashSecret = "E1S54MZI38X50YDEDIK6LDCSEFHHX49L";
            $vnp_Url        = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl  = route('vnpay.return');

            $vnp_TxnRef     = $order->id;
            $vnp_OrderInfo  = 'Thanh toán đơn hàng #' . $order->id;
            $vnp_OrderType  = 'billpayment';
            $vnp_Amount     = $order->total_amount * 100;
            $vnp_Locale     = 'vn';
            $vnp_IpAddr     = request()->ip();

            $inputData = [
                "vnp_Version"    => "2.1.0",
                "vnp_TmnCode"    => $vnp_TmnCode,
                "vnp_Amount"     => $vnp_Amount,
                "vnp_Command"    => "pay",
                "vnp_CreateDate" => now()->format('YmdHis'),
                "vnp_CurrCode"   => "VND",
                "vnp_IpAddr"     => $vnp_IpAddr,
                "vnp_Locale"     => $vnp_Locale,
                "vnp_OrderInfo"  => $vnp_OrderInfo,
                "vnp_OrderType"  => $vnp_OrderType,
                "vnp_ReturnUrl"  => $vnp_Returnurl,
                "vnp_TxnRef"     => $vnp_TxnRef,
            ];

            ksort($inputData);
            $query    = http_build_query($inputData);
            $hashdata = urldecode($query);
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= "?" . $query . '&vnp_SecureHash=' . $vnpSecureHash;

            return redirect()->away($vnp_Url);
        }

        return redirect()->route('pos.bill', $order->id)->with('error', 'Vui lòng chọn phương thức thanh toán hợp lệ!');
    }

    public function vnpayReturn(Request $request)
    {
        $vnp_ResponseCode = $request->get('vnp_ResponseCode');
        $vnp_TxnRef = $request->get('vnp_TxnRef');

        $order = PosOrder::find($vnp_TxnRef);

        if ($vnp_ResponseCode == '00') {
            $order->status = 'Đã thanh toán';
            $order->save();

            // Trừ số lượng sản phẩm trong kho (dùng stock)
            $items = PosOrderItem::where('pos_order_id', $order->id)->get();
            foreach ($items as $item) {
                $variant = ProductVariant::find($item->product_variant_id);
                if ($variant) {
                    $variant->stock = max(0, $variant->stock - $item->quantity);
                    $variant->save();
                }
            }

            return redirect()->route('pos.bill', $order->id)->with('message', 'Thanh toán thành công!');
        } else {
            // KHÔNG đổi trạng thái, giữ là "Chờ thanh toán"
            $order->status = 'Đã huỷ';
            $order->save();
            return redirect()->route('pos.bill', $order->id)->with('error', 'Thanh toán thất bại hoặc bị huỷ!');
        }
    }

    public function bill(Request $request, $id)
    {
        $order = PosOrder::with('items.productVariant.product')->findOrFail($id);
        $items = PosOrderItem::where('pos_order_id', $id)->get();
        return view('admin.pos.bill', compact('order', 'items'));
    }

    public function deleteItem($id)
    {
        $item = PosOrderItem::findOrFail($id);
        $item->delete();
        return redirect()->back();
    }

    public function history(Request $request)
    {
        $posOrder = PosOrder::whereIn('status', ['Đã thanh toán','Đã huỷ'])->get();

        $order = null;
        $items = collect();

        if ($request->filled('id')) {
            $order = PosOrder::with('items.productVariant.product')->find($request->id);

            if (!$order) {
                return back()->with('error', 'Không tìm thấy đơn hàng.');
            }

            $items = PosOrderItem::where('pos_order_id', $order->id)->get();
        }

        return view('admin.pos.history', compact('posOrder', 'order', 'items'));
    }
    public function checkVoucher(Request $request)
    {
        $code = $request->input('code');
        $total = $request->input('total');

        $voucher = \App\Models\Voucher::where('code', $code)->first();

        if (!$voucher) {
            return response()->json(['success' => false, 'message' => 'Mã không tồn tại hoặc đã bị khoá!']);
        }

        $now = now();
        if ($voucher->valid_from && $now->lt($voucher->valid_from)) {
            return response()->json(['success' => false, 'message' => 'Mã chưa bắt đầu áp dụng!']);
        }
        if ($voucher->valid_to && $now->gt($voucher->valid_to)) {
            return response()->json(['success' => false, 'message' => 'Mã đã hết hạn!']);
        }
        if ($voucher->usage_limit !== null && $voucher->usage_limit <= 0) {
            return response()->json(['success' => false, 'message' => 'Mã đã hết lượt sử dụng!']);
        }
        if ($voucher->min_order_value && $total < $voucher->min_order_value) {
            return response()->json(['success' => false, 'message' => 'Đơn hàng chưa đủ giá trị tối thiểu để áp dụng mã!']);
        }

        // Kiểm tra mã hiện tại trong session
        $currentVoucher = session('voucher');
        if ($currentVoucher && $currentVoucher->code === $voucher->code && session()->has('voucher_applied')) {
            // Không trừ tiếp nếu đang dùng chính mã này
        } else {
            // Hoàn trả mã cũ nếu có
            if ($currentVoucher && session()->has('voucher_applied')) {
                $currentVoucher->usage_limit += 1;
                $currentVoucher->used_count -= 1;
                $currentVoucher->save();
                session()->forget('voucher_applied');
            }

            // Áp dụng mã mới
            $voucher->usage_limit -= 1;
            $voucher->used_count += 1;
            $voucher->save();
            session(['voucher_applied' => true]);
        }

        session(['voucher' => $voucher]);

        // Tính giảm giá
        $discount = 0;
        if ($voucher->discount_type == 'percent' || $voucher->discount_type == 'percentage') {
            $discount = $total * $voucher->discount_value / 100;
            if ($voucher->max_discount && $discount > $voucher->max_discount) {
                $discount = $voucher->max_discount;
            }
        } else {
            $discount = $voucher->discount_value;
        }

        if ($discount > $total) $discount = $total;
        $finalTotal = $total - $discount;

        return response()->json([
            'success' => true,
            'discount' => $discount,
            'voucher_id' => $voucher->id,
            'message' => 'Áp dụng mã thành công! Giảm ' . number_format($discount, 0, ',', '.') . ' VNĐ',
            'final_total' => $finalTotal
        ]);
    }
}

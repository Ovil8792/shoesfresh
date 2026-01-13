<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Delivery;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }

    // Trang checkout
    public function index()
    {
        $userId = session('user.id');
        if (!$userId) {
            return redirect()->route('user.login')->with('error', 'Vui lòng đăng nhập trước khi đặt hàng!');
        }
        $cart = Cart::where('user_id', $userId)->first();
        $cartItems = $cart
            ? CartItem::with(['variant.product', 'variant.size', 'variant.color'])
            ->where('cart_id', $cart->id)->get()
            : collect();
        $cartTotal = $cartItems->sum(fn($item) => ($item->variant->price ?? 0) * $item->quantity);

        // Lấy thông tin voucher từ session (nếu có)
        $voucher = (object) session('voucher');
        $voucherId = $voucher->id ?? null;
        $voucherCode = $voucher->code ?? null;
        $voucherDiscount = 0;
        if ($voucherId) {
            if ($voucher->discount_type == 'percent') {
                $voucherDiscount = round($cartTotal * $voucher->discount_value / 100);
                if ($voucher->max_discount && $voucherDiscount > $voucher->max_discount) {
                    $voucherDiscount = $voucher->max_discount;
                }
            } else {
                $voucherDiscount = $voucher->discount_value;
            }
            if ($voucherDiscount > $cartTotal) $voucherDiscount = $cartTotal;
        }
        $cartFinalTotal = $cartTotal - $voucherDiscount;

        return view('client.checkout.index', compact(
            'cartItems',
            'cartTotal',
            'voucherCode',
            'voucherDiscount',
            'cartFinalTotal'
        ));
    }

    // Đặt hàng COD hoặc MOMO
    public function submit(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'note'    => 'nullable|string|max:1000',
            'payment' => 'required|string',
        ]);
        $userId = session('user.id');
        if (!$userId) return redirect()->route('user.login')->with('error', 'Vui lòng đăng nhập trước khi đặt hàng!');

        $cart = Cart::where('user_id', $userId)->first();
        if (!$cart) return back()->with('error', 'Giỏ hàng không tồn tại!');
        $cartItems = CartItem::with(['variant'])->where('cart_id', $cart->id)->get();
        if ($cartItems->isEmpty()) return back()->with('error', 'Giỏ hàng rỗng!');

        // Kiểm tra tồn kho
        foreach ($cartItems as $item) {
            if (!$item->variant) {
                return back()->with('error', 'Sản phẩm không tồn tại hoặc đã bị xóa.');
            }
            if ($item->variant->stock < $item->quantity) {
                return back()->with('error', "Sản phẩm {$item->variant->name} không đủ số lượng tồn kho.");
            }
        }
        // Lấy lại voucher từ session để tính chính xác
        $voucher = (object) session('voucher');
        $voucherId = $voucher->id ?? null;
        $voucherDiscount = 0;
        $cartTotal = $cartItems->sum(fn($i) => ($i->variant->price ?? 0) * $i->quantity);
        if ($voucherId) {
            if ($voucher->discount_type == 'percent') {
                $voucherDiscount = round($cartTotal * $voucher->discount_value / 100);
                if ($voucher->max_discount && $voucherDiscount > $voucher->max_discount) {
                    $voucherDiscount = $voucher->max_discount;
                }
            } else {
                $voucherDiscount = $voucher->discount_value;
            }
            if ($voucherDiscount > $cartTotal) $voucherDiscount = $cartTotal;
        }
        $cartFinalTotal = $cartTotal - $voucherDiscount;

        DB::beginTransaction();
        try {
            // Trừ usage_limit của voucher khi đặt hàng thành công
            if ($voucherId) {
                $voucherModel = \App\Models\Voucher::find($voucherId);
                if ($voucherModel && $voucherModel->usage_limit > 0) {
                    $voucherModel->usage_limit -= 1;
                    $voucherModel->used_count += 1;
                    $voucherModel->save();
                }
            }

            $order = Order::create([
                'user_id'          => $userId,
                'name'             => $data['name'],
                'email'            => $data['email'],
                'phone'            => $data['phone'],
                'total_amount'     => $cartFinalTotal,
                'voucher_id'       => $voucherId,
                'discount_applied' => $voucherDiscount,
                'status'           => 'processing',
                'payment_method'   => $data['payment'],
                'shipping_address' => $data['address'],
            ]);
            // Tạo bản ghi giao hàng
            Delivery::create([
                'order_id' => $order->id,
            ]);
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'           => $order->id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity'           => $item->quantity,
                    'price'              => $item->variant->price ?? 0,
                ]);
                // Cập nhật tồn kho
                $item->variant->decrement('stock', $item->quantity);
            }
            $cartItems->each->delete();
            $cart->delete();

            DB::commit();
            // Xóa voucher khỏi session sau khi đặt hàng thành công
            session()->forget('voucher');
            return redirect()->route('checkout.success', ['orderId' => $order->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi khi đặt hàng: ' . $e->getMessage());
        }
    }

    // Thanh toán VNPAY (tạo đơn hàng + build URL redirect)
    public function vnpay(Request $request)
    {
        $userId = session('user.id');
        if (!$userId) return response()->json(['redirect' => route('user.login')]);
        $data = $request->all();

        $cart = Cart::where('user_id', $userId)->first();
        $cartItems = $cart ? CartItem::with(['variant'])->where('cart_id', $cart->id)->get() : collect();
        $cartTotal = $cartItems->sum(fn($i) => ($i->variant->price ?? 0) * $i->quantity);
        if ($cartItems->isEmpty()) return response()->json(['redirect' => route('shop.cart.index')]);

        // Lấy lại voucher từ session
        $voucher = (object) session('voucher');
        $voucherId = $voucher->id ?? null;
        $voucherDiscount = 0;
        if ($voucherId) {
            if ($voucher->discount_type == 'percent') {
                $voucherDiscount = round($cartTotal * $voucher->discount_value / 100);
                if ($voucher->max_discount && $voucherDiscount > $voucher->max_discount) {
                    $voucherDiscount = $voucher->max_discount;
                }
            } else {
                $voucherDiscount = $voucher->discount_value;
            }
            if ($voucherDiscount > $cartTotal) $voucherDiscount = $cartTotal;
        }
        $cartFinalTotal = $cartTotal - $voucherDiscount;

        // Tạo đơn hàng trạng thái pending
        DB::beginTransaction();
        try {
            // Trừ usage_limit của voucher khi tạo đơn hàng VNPAY
            if ($voucherId) {
                $voucherModel = \App\Models\Voucher::find($voucherId);
                if ($voucherModel && $voucherModel->usage_limit > 0) {
                    $voucherModel->usage_limit -= 1;
                    $voucherModel->used_count += 1;
                    $voucherModel->save();
                }
            }

            $order = Order::create([
                'user_id'          => $userId,
                'name'             => $data['name'] ?? '',
                'email'            => $data['email'] ?? '',
                'phone'            => $data['phone'] ?? '',
                'total_amount'     => $cartFinalTotal,
                'voucher_id'       => $voucherId,
                'discount_applied' => $voucherDiscount,
                'status'           => 'pending',
                'payment_method'   => 'VNPAY',
                'shipping_address' => $data['address'] ?? '',
            ]);
            // Tạo bản ghi giao hàng
            Delivery::create([
                'order_id' => $order->id,
            ]);
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'           => $order->id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity'           => $item->quantity,
                    'price'              => $item->variant->price ?? 0,
                ]);
            }
            DB::commit();
            // Xóa voucher khỏi session sau khi đặt hàng thành công
            session()->forget('voucher');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Lỗi tạo đơn hàng: ' . $e->getMessage()]);
        }

        // Build VNPAY data (KHÔNG truyền vnp_IpnUrl vào inputData)
        $vnp_TmnCode = "QM5USC8V"; //Mã định danh merchant kết nối (Terminal Id)
        $vnp_HashSecret = "0AP6TPG3N13J17TD361LDDE8FU348DP4"; //Secret key
        $vnp_Url        = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_ReturnUrl  = env('APP_URL') . "/checkout/vnpay-return";
        $orderId        = $order->id;
        $orderDesc      = "Thanh toan don hang {$orderId}";
        // $vnp_BankCode = "NCB"; //Mã phương thức thanh toán
        $orderType      = "billpayment";
        $amount         = (int)$cartFinalTotal * 100;
        $locale         = "vn";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán
        $expire         = date('YmdHis', strtotime('+15 minutes'));
        $inputData = [
            "vnp_Version"    => "2.1.0",
            "vnp_TmnCode"    => $vnp_TmnCode,
            "vnp_Amount"     => $amount,
            "vnp_Command"    => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode"   => "VND",
            "vnp_IpAddr"     => $vnp_IpAddr,
            "vnp_Locale"     => $locale,
            "vnp_OrderInfo"  => $orderDesc,
            "vnp_OrderType"  => $orderType,
            "vnp_ReturnUrl"  => $vnp_ReturnUrl,
            // "vnp_IpnUrl"     => route('vnpay.ipn'),
            "vnp_TxnRef"     => $orderId,
            "vnp_ExpireDate" => $expire,
        ];
        // if (isset($vnp_BankCode) && $vnp_BankCode != "") {
        //     $inputData['vnp_BankCode'] = $vnp_BankCode;
        // }
        // Sắp xếp và urlencode value cho hashData
        ksort($inputData);
        $hashdataArr = [];
        foreach ($inputData as $key => $value) {
            $hashdataArr[] = $key . "=" . urlencode($value);
        }
        $hashdata = implode('&', $hashdataArr);
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        // $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán


        // Build query đúng chuẩn RFC3986 (encode chuẩn cho VNPAY)
        $query   = http_build_query($inputData, '', '&', PHP_QUERY_RFC3986);
        $vnp_Url = $vnp_Url . "?" . $query . "&vnp_SecureHash=" . $vnpSecureHash;

        return response()->json(['redirect' => $vnp_Url]);
    }

    // Trang hóa đơn sau khi thanh toán thành công hoặc thất bại
    // public function vnpayIpn(Request $request)
    // {
    //     $input = $request->all();

    //     $vnp_HashSecret = env('VNPAY_HASH_SECRET', '0AP6TPG3N13J17TD361LDDE8FU348DP4');
    //     $vnp_SecureHash = $input['vnp_SecureHash'] ?? '';

    //     // Xóa hash để tự build lại
    //     unset($input['vnp_SecureHash'], $input['vnp_SecureHashType']);
    //     ksort($input);

    //     $hashData = [];
    //     foreach ($input as $key => $value) {
    //         $hashData[] = $key . "=" . rawurlencode($value);
    //     }


    //     $secureHash = hash_hmac(
    //         'sha512',
    //         implode('&', $hashData),
    //         $vnp_HashSecret
    //     );

    //     // ❌ Sai chữ ký
    //     if ($secureHash !== $vnp_SecureHash) {
    //         return response()->json([
    //             'RspCode' => '97',
    //             'Message' => 'Invalid signature'
    //         ]);
    //     }

    //     $orderId = $input['vnp_TxnRef'] ?? null;
    //     $order   = Order::with('orderItems.variant')->find($orderId);

    //     // ❌ Không tìm thấy đơn
    //     if (!$order) {
    //         return response()->json([
    //             'RspCode' => '01',
    //             'Message' => 'Order not found'
    //         ]);
    //     }

    //     // ✅ CHỐNG CALLBACK TRÙNG
    //     if ($order->status === 'processing') {
    //         return response()->json([
    //             'RspCode' => '02',
    //             'Message' => 'Order already confirmed'
    //         ]);
    //     }

    //     // ❌ Thanh toán thất bại
    //     if (
    //         ($input['vnp_ResponseCode'] ?? '') !== '00' ||
    //         ($input['vnp_TransactionStatus'] ?? '') !== '00'
    //     ) {
    //         $order->status = 'cancelled';
    //         $order->save();

    //         return response()->json([
    //             'RspCode' => '00',
    //             'Message' => 'Payment failed - order cancelled'
    //         ]);
    //     }

    //     // ✅ THANH TOÁN THÀNH CÔNG
    //     DB::beginTransaction();
    //     try {
    //         // Cập nhật trạng thái đơn
    //         $order->status = 'processing';
    //         $order->save();

    //         // Trừ tồn kho
    //         foreach ($order->orderItems as $item) {
    //             if ($item->variant) {
    //                 $item->variant->decrement('stock', $item->quantity);
    //             }
    //         }

    //         // Xóa cart của user
    //         $cart = Cart::where('user_id', $order->user_id)->first();
    //         if ($cart) {
    //             CartItem::where('cart_id', $cart->id)->delete();
    //             $cart->delete();
    //         }

    //         // Xóa voucher khỏi session (nếu còn)
    //         session()->forget('voucher');

    //         DB::commit();

    //         return response()->json([
    //             'RspCode' => '00',
    //             'Message' => 'Confirm Success'
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         Log::error('VNPAY IPN ERROR', [
    //             'order_id' => $orderId,
    //             'error'    => $e->getMessage()
    //         ]);

    //         return response()->json([
    //             'RspCode' => '99',
    //             'Message' => 'Internal error'
    //         ]);
    //     }
    // }
    public function success($orderId)
    {
        $order = Order::with(['orderItems.variant.product', 'voucher'])->findOrFail($orderId);
        return view('client.checkout.success', compact('order'));
    }

    // Xử lý callback ReturnUrl từ VNPAY
    public function vnpayReturn(Request $request)
    {
        $orderId = $request->input('vnp_TxnRef');
        $responseCode = $request->input('vnp_ResponseCode');

        // Nếu VNPAY báo thành công ở ReturnUrl thì cập nhật trạng thái đơn
        if ($responseCode === '00' || $responseCode === 0 || $responseCode === '0') {
            $order = Order::find($orderId);
            if ($order && $order->status !== 'processing') {
                $order->status = 'processing';
                $order->save();
            }
            // Xóa giỏ hàng của user sau khi thanh toán thành công
            if ($order) {
                $cart = Cart::where('user_id', $order->user_id)->first();
                if ($cart) {
                    CartItem::where('cart_id', $cart->id)->delete();
                    $cart->delete();
                }
            }
        }

        return redirect()->route('checkout.success', [
            'orderId' => $orderId
        ]);
    }
}

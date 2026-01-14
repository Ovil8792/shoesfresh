@extends('client.layout.master')
@section('main')
<div class="container mt-4">
    <h3>Lịch sử mua hàng</h3>
    @if($orders->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Thanh toán</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>ShoesFresh{{ $order->id }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $order->total_amount }} đ</td>
                    <td>
                        @switch($order->status)
                        @case('pending')
                                Chờ xác nhận
                                @break
                            @case('processing')
                                Đang xử lý
                                @break
                            @case('delivering')
                                Đang giao hàng
                                @break
                            @case('completed')
                                Hoàn thành
                                @break
                            @case('cancelled')
                                Đã hủy
                                @break
                            @case('paid')
                                Đã thanh toán
                                @break
                            @default
                                {{ $order->status }}
                        @endswitch
                    </td>
                    <td>
                        @php
                            $paymentStatus = 'Chưa thanh toán';
                            // Nếu đơn hàng đã hoàn thành thì phải đã thanh toán
                            if ($order->status === 'completed') {
                                $paymentStatus = 'Đã thanh toán';
                            } elseif ($order->payment_method === 'VNPAY' && $order->status !== 'pending') {
                                $paymentStatus = 'Đã thanh toán';
                            } elseif ($order->payment_method === 'COD') {
                                $paymentStatus = 'Chưa thanh toán';
                            }
                        @endphp
                        <span class="fw-bold text-{{ $paymentStatus === 'Đã thanh toán' ? 'success' : 'danger' }}">{{ $paymentStatus }}</span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('profile.orders.show', $order->id) }}"
                            class="btn btn-sm btn-info rounded-pill px-3 py-1 d-inline-flex align-items-center me-1">
                            <i class="bi bi-eye me-1"></i> Chi tiết
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Bạn chưa có đơn hàng nào.</p>
    @endif
</div>
@endsection

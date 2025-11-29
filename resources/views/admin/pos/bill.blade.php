@extends('admin.layout.index')
@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">🧾 HÓA ĐƠN BÁN HÀNG</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Mã hóa đơn:</strong> #{{ $order->id }}<br>
                            <strong>Ngày:</strong> {{ $order->created_at->format('d/m/Y H:i') }}<br>
                            <strong>Nhân viên:</strong> {{ $order->staff_id }}

                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tên SP</th>
                                    <th>Số lượng</th>
                                    <th>Đơn giá</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $item->productVariant->product->name ?? '' }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                                        <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }} VNĐ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3 text-end">
                            <div><strong>Tổng tiền:</strong> {{ number_format($order->total_amount, 0, ',', '.') }} VNĐ
                            </div>
                            <div><strong>Giảm giá:</strong> {{ number_format($order->discount_applied, 0, ',', '.') }} VNĐ
                            </div>
                            <div><strong>Thanh toán:</strong>
                                {{ number_format($order->total_amount - $order->discount_applied, 0, ',', '.') }} VNĐ</div>
                            <div><strong>Phương thức:</strong> {{ $order->payment_method }}</div>
                            <div><strong>Trạng thái:</strong> {{ $order->status }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('admin.layout.main')

@section('page-title', 'Chi tiết đơn hàng')
@section('main')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Chi tiết đơn hàng</h2>
                    <p class="text-muted mb-0">Xem thông tin chi tiết đơn hàng</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.order') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Danh sách
                    </a>
                    @isset($order)
                    <a href="{{ route('admin.order.edit', ['id' => $order->id]) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Sửa
                    </a>
                    <a href="{{ route('admin.order.delete', ['id' => $order->id]) }}" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa không?')">
                        <i class="bi bi-trash"></i> Xóa
                    </a>
                    @endisset
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 text-muted">ID</div>
                <div class="col-md-9">{{ $order->id ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Mã đơn hàng</div>
                <div class="col-md-9">{{ $order->order_code ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Tên khách hàng</div>
                <div class="col-md-9">{{ $order->customer_name ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Số điện thoại</div>
                <div class="col-md-9">{{ $order->customer_phone ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Email</div>
                <div class="col-md-9">{{ $order->customer_email ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Địa chỉ</div>
                <div class="col-md-9">{{ $order->address ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Tổng tiền</div>
                <div class="col-md-9 text-success fw-bold">{{ number_format($order->total_amount ?? 0, 0, ',', '.') }} VNĐ</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Trạng thái</div>
                <div class="col-md-9">
                    @if(isset($order) && $order->status)
                        @php
                            $statusBadges = [
                                'pending' => 'warning',
                                'processing' => 'info',
                                'shipped' => 'primary',
                                'completed' => 'success',
                                'cancelled' => 'danger'
                            ];
                            $badge = $statusBadges[$order->status] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $badge }}">{{ ucfirst($order->status) }}</span>
                    @else
                        -
                    @endif
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Ngày đặt</div>
                <div class="col-md-9">{{ $order->created_at ?? '-' }}</div>
            </div>
        </div>
    </div>
</div>
@endsection


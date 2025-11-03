@extends('admin.layout.main')

@section('page-title', 'Xóa đơn hàng')
@section('main')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0 text-danger">Xóa đơn hàng</h2>
            <p class="text-muted mb-0">Hành động này không thể hoàn tác.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <p>Bạn có chắc chắn muốn xóa đơn hàng <strong>{{ $order->order_code ?? 'ID: ' . ($id ?? '') }}</strong>?</p>
            <div class="d-flex gap-2">
                @isset($order)
                <a href="{{ route('admin.order.delete', ['id' => $order->id]) }}" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Xóa ngay
                </a>
                @else
                <a href="{{ route('admin.order.delete', ['id' => $id]) }}" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Xóa ngay
                </a>
                @endisset
                <a href="{{ route('admin.order') }}" class="btn btn-outline-secondary">Hủy</a>
            </div>
        </div>
    </div>
</div>
@endsection


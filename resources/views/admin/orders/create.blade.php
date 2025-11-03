@extends('admin.layout.main')

@section('page-title', 'Thêm đơn hàng')
@section('main')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Thêm đơn hàng</h2>
                    <p class="text-muted mb-0">Tạo mới một đơn hàng</p>
                </div>
                <div>
                    <a href="{{ route('admin.order') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0">Thông tin đơn hàng</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                @csrf
                @include('admin.orders._form', ['order' => null])
            </form>
        </div>
    </div>
</div>
@endsection


@extends('admin.layout.main')

@section('page-title', 'Đơn hàng')
@section('main')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Danh sách đơn hàng</h2>
                    <p class="text-muted mb-0">Quản lý tất cả đơn hàng trong hệ thống</p>
                </div>
                <div>
                    <a href="{{ route('admin.order.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Thêm đơn hàng
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Danh sách đơn hàng</h5>
                <div class="d-flex gap-2">
                    <form method="GET" class="d-flex gap-2">
                        <div class="input-group" style="width: 160px;">
                            <span class="input-group-text">ID</span>
                            <input type="number" name="search_id" value="{{ $searchId ?? '' }}" class="form-control" placeholder="ID">
                        </div>
                        <div class="input-group" style="width: 260px;">
                            <span class="input-group-text">Mã đơn</span>
                            <input type="text" name="search_code" value="{{ $searchCode ?? '' }}" class="form-control" placeholder="Mã đơn hàng">
                        </div>
                        <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
                        <a href="{{ route('admin.order') }}" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i></a>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="border-0">#</th>
                            <th class="border-0">Mã đơn hàng</th>
                            <th class="border-0">Khách hàng</th>
                            <th class="border-0">Tổng tiền</th>
                            <th class="border-0">Trạng thái</th>
                            <th class="border-0">Ngày đặt</th>
                            <th class="border-0 text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample data - replace with actual data -->
                        <tr>
                            <td class="align-middle">
                                <span class="badge bg-light text-dark">1</span>
                            </td>
                            <td class="align-middle">
                                <h6 class="mb-0 fw-semibold">DH001</h6>
                            </td>
                            <td class="align-middle">Khách hàng mẫu</td>
                            <td class="align-middle text-success fw-bold">500,000 VNĐ</td>
                            <td class="align-middle">
                                <span class="badge bg-warning">Đang xử lý</span>
                            </td>
                            <td class="align-middle text-muted">2024-01-01</td>
                            <td class="align-middle text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('admin.order.show', ['id' => 1]) }}" class="btn btn-sm btn-outline-info" title="Chi tiết">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.order.edit', ['id' => 1]) }}" class="btn btn-sm btn-outline-warning" title="Sửa">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ route('admin.order.delete', ['id' => 1]) }}" class="btn btn-sm btn-outline-danger" title="Xóa">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


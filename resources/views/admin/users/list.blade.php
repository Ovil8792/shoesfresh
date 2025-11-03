@extends('admin.layout.main')

@section('page-title', 'Người dùng')
@section('main')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Danh sách người dùng</h2>
                    <p class="text-muted mb-0">Quản lý tất cả người dùng trong hệ thống</p>
                </div>
                <div>
                    <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Thêm người dùng
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Danh sách người dùng</h5>
                <div class="d-flex gap-2">
                    <form method="GET" class="d-flex gap-2">
                        <div class="input-group" style="width: 160px;">
                            <span class="input-group-text">ID</span>
                            <input type="number" name="search_id" value="{{ $searchId ?? '' }}" class="form-control" placeholder="ID">
                        </div>
                        <div class="input-group" style="width: 260px;">
                            <span class="input-group-text">Tên/Email</span>
                            <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control" placeholder="Tìm kiếm">
                        </div>
                        <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
                        <a href="{{ route('admin.user') }}" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i></a>
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
                            <th class="border-0">Tên người dùng</th>
                            <th class="border-0">Email</th>
                            <th class="border-0">Số điện thoại</th>
                            <th class="border-0">Vai trò</th>
                            <th class="border-0">Ngày tạo</th>
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
                                <h6 class="mb-0 fw-semibold">Người dùng mẫu</h6>
                            </td>
                            <td class="align-middle">user@example.com</td>
                            <td class="align-middle">0123456789</td>
                            <td class="align-middle">
                                <span class="badge bg-info">Khách hàng</span>
                            </td>
                            <td class="align-middle text-muted">2024-01-01</td>
                            <td class="align-middle text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('admin.user.show', ['id' => 1]) }}" class="btn btn-sm btn-outline-info" title="Chi tiết">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.user.edit', ['id' => 1]) }}" class="btn btn-sm btn-outline-warning" title="Sửa">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ route('admin.user.delete', ['id' => 1]) }}" class="btn btn-sm btn-outline-danger" title="Xóa">
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


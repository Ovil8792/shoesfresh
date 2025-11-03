@extends('admin.layout.main')

@section('page-title', 'Thương hiệu')
@section('main')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">Danh sách thương hiệu</h2>
                <p class="text-muted mb-0">Quản lý tất cả thương hiệu</p>
            </div>
            <a href="{{ route('admin.brand.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Thêm thương hiệu</a>
        </div>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0">Danh sách</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên thương hiệu</th>
                            <th>Ngày tạo</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="badge bg-light text-dark">1</span></td>
                            <td>Thương hiệu mẫu</td>
                            <td class="text-muted">2024-01-01</td>
                            <td class="text-center">
                                <a href="{{ route('admin.brand.show', ['id'=>1]) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.brand.edit', ['id'=>1]) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                <a href="{{ route('admin.brand.delete', ['id'=>1]) }}" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection



@extends('admin.layout.main')

@section('page-title', 'Chi tiết thương hiệu')
@section('main')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">Chi tiết thương hiệu</h2>
                <p class="text-muted mb-0">Xem thông tin thương hiệu</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.brand') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Danh sách</a>
                @isset($brand)
                <a href="{{ route('admin.brand.edit', ['id' => $brand->id]) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Sửa</a>
                <a href="{{ route('admin.brand.delete', ['id' => $brand->id]) }}" class="btn btn-danger"><i class="bi bi-trash"></i> Xóa</a>
                @endisset
            </div>
        </div>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row mb-3"><div class="col-md-3 text-muted">ID</div><div class="col-md-9">{{ $brand->id ?? $id ?? '-' }}</div></div>
            <div class="row mb-3"><div class="col-md-3 text-muted">Tên thương hiệu</div><div class="col-md-9">{{ $brand->name ?? '-' }}</div></div>
            <div class="row mb-3"><div class="col-md-3 text-muted">Ngày tạo</div><div class="col-md-9">{{ $brand->created_at ?? '-' }}</div></div>
        </div>
    </div>
</div>
@endsection



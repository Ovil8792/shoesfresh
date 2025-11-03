@extends('admin.layout.main')

@section('page-title', 'Chi tiết kích cỡ')
@section('main')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">Chi tiết kích cỡ</h2>
                <p class="text-muted mb-0">Xem thông tin kích cỡ</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.size') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Danh sách</a>
                @isset($size)
                <a href="{{ route('admin.size.edit', ['id' => $size->id]) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Sửa</a>
                <a href="{{ route('admin.size.delete', ['id' => $size->id]) }}" class="btn btn-danger"><i class="bi bi-trash"></i> Xóa</a>
                @endisset
            </div>
        </div>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row mb-3"><div class="col-md-3 text-muted">ID</div><div class="col-md-9">{{ $size->id ?? $id ?? '-' }}</div></div>
            <div class="row mb-3"><div class="col-md-3 text-muted">Kích cỡ</div><div class="col-md-9">{{ $size->value ?? '-' }}</div></div>
            <div class="row mb-3"><div class="col-md-3 text-muted">Mô tả</div><div class="col-md-9">{{ $size->description ?? '-' }}</div></div>
        </div>
    </div>
</div>
@endsection



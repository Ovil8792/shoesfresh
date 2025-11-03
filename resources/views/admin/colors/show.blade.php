@extends('admin.layout.main')

@section('page-title', 'Chi tiết màu sắc')
@section('main')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">Chi tiết màu sắc</h2>
                <p class="text-muted mb-0">Xem thông tin màu sắc</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.color') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Danh sách</a>
                @isset($color)
                <a href="{{ route('admin.color.edit', ['id' => $color->id]) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Sửa</a>
                <a href="{{ route('admin.color.delete', ['id' => $color->id]) }}" class="btn btn-danger"><i class="bi bi-trash"></i> Xóa</a>
                @endisset
            </div>
        </div>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row mb-3"><div class="col-md-3 text-muted">ID</div><div class="col-md-9">{{ $color->id ?? $id ?? '-' }}</div></div>
            <div class="row mb-3"><div class="col-md-3 text-muted">Tên màu</div><div class="col-md-9">{{ $color->name ?? '-' }}</div></div>
            <div class="row mb-3"><div class="col-md-3 text-muted">Mã màu</div><div class="col-md-9">{{ $color->hex ?? '-' }}</div></div>
        </div>
    </div>
</div>
@endsection



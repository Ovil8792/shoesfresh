@extends('admin.layout.main')

@section('main')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Chi tiết danh mục</h2>
                    <p class="text-muted mb-0">Xem thông tin danh mục</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.category') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Danh sách
                    </a>
                    @isset($category)
                    <a href="{{ route('admin.editcat', ['id' => $category->id]) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Sửa
                    </a>
                    <a href="{{ route('admin.delcat', ['id' => $category->id]) }}" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa không?')">
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
                <div class="col-md-9">{{ $category->id ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Tên danh mục</div>
                <div class="col-md-9">{{ $category->name ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Tạo ngày</div>
                <div class="col-md-9">{{ $category->created_at ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Sửa ngày</div>
                <div class="col-md-9">{{ $category->updated_at ?? '-' }}</div>
            </div>
        </div>
    </div>
</div>
@endsection

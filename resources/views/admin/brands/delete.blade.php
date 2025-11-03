@extends('admin.layout.main')

@section('page-title', 'Xóa thương hiệu')
@section('main')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0 text-danger">Xóa thương hiệu</h2>
            <p class="text-muted mb-0">Hành động này không thể hoàn tác.</p>
        </div>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <p>Bạn có chắc chắn muốn xóa thương hiệu <strong>{{ $brand->name ?? 'ID: ' . ($id ?? '') }}</strong>?</p>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.brand.delete', ['id' => $brand->id ?? $id]) }}" class="btn btn-danger"><i class="bi bi-trash"></i> Xóa ngay</a>
                <a href="{{ route('admin.brand') }}" class="btn btn-outline-secondary">Hủy</a>
            </div>
        </div>
    </div>
</div>
@endsection



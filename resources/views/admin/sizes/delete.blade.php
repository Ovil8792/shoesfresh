@extends('admin.layout.main')

@section('page-title', 'Xóa kích cỡ')
@section('main')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0 text-danger">Xóa kích cỡ</h2>
            <p class="text-muted mb-0">Hành động này không thể hoàn tác.</p>
        </div>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <p>Bạn có chắc chắn muốn xóa kích cỡ <strong>{{ $size->value ?? 'ID: ' . ($id ?? '') }}</strong>?</p>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.size.delete', ['id' => $size->id ?? $id]) }}" class="btn btn-danger"><i class="bi bi-trash"></i> Xóa ngay</a>
                <a href="{{ route('admin.size') }}" class="btn btn-outline-secondary">Hủy</a>
            </div>
        </div>
    </div>
</div>
@endsection



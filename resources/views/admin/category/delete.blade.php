@extends('admin.layout.main')

@section('main')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0 text-danger">Xóa danh mục</h2>
            <p class="text-muted mb-0">Hành động này không thể hoàn tác.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <p>Bạn có chắc chắn muốn xóa danh mục <strong>{{ $category->name ?? '' }}</strong> (ID: {{ $category->id ?? '' }})?</p>
            <div class="d-flex gap-2">
                @isset($category)
                <a href="{{ route('admin.delcat', ['id' => $category->id]) }}" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Xóa ngay
                </a>
                @endisset
                <a href="{{ route('admin.category') }}" class="btn btn-outline-secondary">Hủy</a>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('admin.layout.main')

@section('page-title', 'Sửa kích cỡ')
@section('main')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">Sửa kích cỡ</h2>
                <p class="text-muted mb-0">Cập nhật thông tin kích cỡ</p>
            </div>
            <a href="{{ route('admin.size') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Danh sách</a>
        </div>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white"><h5 class="card-title mb-0">Thông tin kích cỡ</h5></div>
        <div class="card-body">
            <form method="POST" action="">
                @csrf
                @include('admin.sizes._form', ['size' => $size ?? null])
            </form>
        </div>
    </div>
</div>
@endsection



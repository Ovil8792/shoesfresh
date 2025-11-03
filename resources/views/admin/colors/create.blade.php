@extends('admin.layout.main')

@section('page-title', 'Thêm màu sắc')
@section('main')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">Thêm màu sắc</h2>
                <p class="text-muted mb-0">Tạo mới một màu sắc</p>
            </div>
            <a href="{{ route('admin.color') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Danh sách</a>
        </div>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white"><h5 class="card-title mb-0">Thông tin màu sắc</h5></div>
        <div class="card-body">
            <form method="POST" action="">
                @csrf
                @include('admin.colors._form', ['color' => null])
            </form>
        </div>
    </div>
</div>
@endsection



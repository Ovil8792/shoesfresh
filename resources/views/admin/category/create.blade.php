@extends('admin.layout.main')

@section('main')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Thêm danh mục</h2>
                    <p class="text-muted mb-0">Tạo mới một danh mục</p>
                </div>
                <div>
                    <a href="{{ route('admin.category') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0">Thông tin danh mục</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                @csrf
                @include('admin.category._form', ['category' => null])
            </form>
        </div>
    </div>
</div>
@endsection

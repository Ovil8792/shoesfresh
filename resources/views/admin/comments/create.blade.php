@extends('admin.layout.main')

@section('page-title', 'Thêm bình luận')
@section('main')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Thêm bình luận</h2>
                    <p class="text-muted mb-0">Tạo mới một bình luận</p>
                </div>
                <div>
                    <a href="{{ route('admin.comment') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0">Thông tin bình luận</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                @csrf
                @include('admin.comments._form', ['comment' => null])
            </form>
        </div>
    </div>
</div>
@endsection


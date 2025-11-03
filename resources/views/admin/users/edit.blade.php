@extends('admin.layout.main')

@section('page-title', 'Sửa người dùng')
@section('main')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Sửa người dùng</h2>
                    <p class="text-muted mb-0">Cập nhật thông tin người dùng</p>
                </div>
                <div>
                    <a href="{{ route('admin.user') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0">Thông tin người dùng</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                @csrf
                @include('admin.users._form', ['user' => $user ?? null])
            </form>
        </div>
    </div>
</div>
@endsection


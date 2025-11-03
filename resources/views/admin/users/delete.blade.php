@extends('admin.layout.main')

@section('page-title', 'Xóa người dùng')
@section('main')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0 text-danger">Xóa người dùng</h2>
            <p class="text-muted mb-0">Hành động này không thể hoàn tác.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <p>Bạn có chắc chắn muốn xóa người dùng <strong>{{ $user->name ?? 'ID: ' . ($id ?? '') }}</strong> ({{ $user->email ?? '' }})?</p>
            <div class="d-flex gap-2">
                @isset($user)
                <a href="{{ route('admin.user.delete', ['id' => $user->id]) }}" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Xóa ngay
                </a>
                @else
                <a href="{{ route('admin.user.delete', ['id' => $id]) }}" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Xóa ngay
                </a>
                @endisset
                <a href="{{ route('admin.user') }}" class="btn btn-outline-secondary">Hủy</a>
            </div>
        </div>
    </div>
</div>
@endsection


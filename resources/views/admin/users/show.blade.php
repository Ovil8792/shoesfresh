@extends('admin.layout.main')

@section('page-title', 'Chi tiết người dùng')
@section('main')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Chi tiết người dùng</h2>
                    <p class="text-muted mb-0">Xem thông tin chi tiết người dùng</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.user') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Danh sách
                    </a>
                    @isset($user)
                    <a href="{{ route('admin.user.edit', ['id' => $user->id]) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Sửa
                    </a>
                    <a href="{{ route('admin.user.delete', ['id' => $user->id]) }}" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa không?')">
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
                <div class="col-md-9">{{ $user->id ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Tên người dùng</div>
                <div class="col-md-9">{{ $user->name ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Email</div>
                <div class="col-md-9">{{ $user->email ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Số điện thoại</div>
                <div class="col-md-9">{{ $user->phone ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Địa chỉ</div>
                <div class="col-md-9">{{ $user->address ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Vai trò</div>
                <div class="col-md-9">
                    @if(isset($user) && $user->role)
                        @php
                            $roleBadges = [
                                'customer' => 'info',
                                'admin' => 'danger'
                            ];
                            $badge = $roleBadges[$user->role] ?? 'secondary';
                            $roleText = $user->role == 'customer' ? 'Khách hàng' : 'Quản trị viên';
                        @endphp
                        <span class="badge bg-{{ $badge }}">{{ $roleText }}</span>
                    @else
                        -
                    @endif
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Ngày tạo</div>
                <div class="col-md-9">{{ $user->created_at ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Cập nhật lần cuối</div>
                <div class="col-md-9">{{ $user->updated_at ?? '-' }}</div>
            </div>
        </div>
    </div>
</div>
@endsection


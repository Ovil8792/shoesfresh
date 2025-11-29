@extends('admin.layout.master')

@section('main')
<div class="container mt-4">
    <div class="card shadow-lg border-0">
        <div class="card-header text-center bg-primary text-white">
            <h4 class="mb-0">Chi tiết tài khoản</h4>
        </div>
        <div class="card-body">
            <div class="d-flex flex-column gap-2">
                <div class="border-bottom pb-2"><strong>Tài khoản:</strong> {{ $user->name }}</div>
                <div class="border-bottom pb-2"><strong>Email:</strong> {{ $user->email }}</div>
                <div class="border-bottom pb-2"><strong>Số điện thoại:</strong> {{ $user->phone }}</div>
                <div class="border-bottom pb-2"><strong>Giới tính:</strong>
                    @if($user->gender == 'male') Nam
                    @elseif($user->gender == 'female') Nữ
                    @else Khác
                    @endif
                </div>
                <div class="border-bottom pb-2"><strong>Ngày sinh:</strong> {{ $user->birth_date }}</div>
                <div class="border-bottom pb-2"><strong>Địa chỉ:</strong> {{ $user->address }}</div>
                <div class="border-bottom pb-2"><strong>Cấp độ thành viên:</strong> {{ ucfirst($user->tier) }}</div>
                <div class="border-bottom pb-2"><strong>Điểm thưởng:</strong> {{ $user->points }}</div>
                <div class="border-bottom pb-2"><strong>Vai trò:</strong> {{ $user->role_id ? $user->role->name : 'Không có' }}</div>
                <div class="border-bottom pb-2"><strong>Ngày tạo:</strong> {{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '' }}</div>
                <div class="border-bottom pb-2"><strong>Ngày cập nhật:</strong> {{ $user->updated_at ? $user->updated_at->format('d/m/Y H:i') : '' }}</div>
            </div>

            <div class="d-flex justify-content-center mt-4">
                <a href="{{ route('user.index') }}" class="btn btn-outline-secondary me-2">Quay lại</a>
                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary">Chỉnh sửa</a>
            </div>
        </div>
    </div>
</div>
@endsection

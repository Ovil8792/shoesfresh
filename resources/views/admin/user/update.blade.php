@extends('admin.layout.master')

@section('main')
<div class="row justify-content-center mt-4">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header text-center bg-primary">
                <h4 class="mb-0 text-white">Sửa thông tin người dùng</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form action="{{ route('user.update', $user->id) }}" method="POST">
                    @csrf
                    @method('POST')

                    <div class="mb-3">
                        <label class="form-label">Tài Khoản</label>
                        <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mật khẩu mới</label>
                        <input type="password" class="form-control" name="password">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Xác nhận mật khẩu</label>
                        <input type="password" class="form-control" name="password_confirmation">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Giới tính</label>
                        <select class="form-select" name="gender">
                            <option value="male" @if($user->gender == 'male') selected @endif>Nam</option>
                            <option value="female" @if($user->gender == 'female') selected @endif>Nữ</option>
                            <option value="other" @if($user->gender == 'other') selected @endif>Khác</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control" name="birth_date" value="{{ $user->birth_date }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" name="address" value="{{ $user->address }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Cấp độ</label>
                        <select class="form-select" name="tier">
                            <option value="basic" @if($user->tier == 'basic') selected @endif>Basic</option>
                            <option value="premium" @if($user->tier == 'premium') selected @endif>Premium</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Vai trò</label>
                        <select class="form-select" name="role_id">
                            <option value="1" @if($user->role_id == 1) selected @endif>Quản trị viên</option>
                            <option value="3" @if($user->role_id == 3) selected @endif>Nhân viên</option>
                            <option value="2" @if($user->role_id == 2) selected @endif>Người dùng</option>
                            <option value="4" @if($user->role_id == 4) selected @endif>Nhân viên giao hàng</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('user.index') }}" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

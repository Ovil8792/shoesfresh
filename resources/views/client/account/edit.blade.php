@extends('client.layout.master')

@section('main')
<style>
    .account-hero {
        background: linear-gradient(150deg,#fef7f2,#eef3ff);
        padding: 50px 0;
    }
    .profile-card {
        border-radius: 30px;
        background:#fff;
        position:relative;
    }
    .profile-card .blur-circle {
        position:absolute;
        width:220px;
        height:220px;
        border-radius:50%;
        background:radial-gradient(circle,rgba(255,196,141,0.35),transparent 70%);
        top:-60px;
        right:-30px;
        z-index:0;
    }
    .profile-card .form-label {
        font-weight:600;
        color:#6b7280;
    }
    .profile-card .form-control,
    .profile-card .form-select {
        border-radius:16px;
        border:1px solid #ececec;
        padding:12px 16px;
    }
    .profile-card .btn-warning {
        background:linear-gradient(120deg,#ffc48d,#ff9f57);
        border:none;
    }
</style>
<section class="account-hero">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="bg-white rounded-4 shadow-lg p-4 position-relative overflow-hidden">
                    <div class="blur-circle"></div>
                    <div class="text-center mb-4">
                        <span class="badge bg-warning text-dark px-3 py-2 mb-2">Cập nhật tài khoản</span>
                        <h3 class="fw-bold mb-0">Chỉnh sửa thông tin cá nhân</h3>
                        <p class="text-muted">Điền các thông tin bên dưới để hoàn tất hồ sơ của bạn.</p>
                    </div>
                    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            <div class="col-12 text-center">
                                <div class="d-inline-flex flex-column align-items-center gap-3">
                                    @if(isset($user['avatar']) && $user['avatar'])
                                        <img id="avatar-preview" src="{{ asset('storage/' . $user['avatar']) }}" class="rounded-circle border border-3 border-warning-subtle" style="width:110px;height:110px;object-fit:cover;" alt="Avatar">
                                    @else
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width:110px;height:110px;">
                                            <i id="avatar-icon" class="fa fa-user text-secondary" style="font-size:48px;"></i>
                                        </div>
                                        <img id="avatar-preview" src="" class="rounded-circle" style="width:110px;height:110px;display:none;object-fit:cover;" alt="Avatar preview">
                                    @endif
                                    <div class="d-flex flex-wrap gap-2">
                                        <label for="avatar" class="btn btn-outline-primary btn-sm">
                                            <i class="fa fa-camera me-1"></i> Đổi ảnh
                                        </label>
                                        <input type="file" id="avatar" name="avatar" accept="image/*" class="d-none" onchange="previewAvatar(event)">
                                        @if(isset($user['avatar']) && $user['avatar'])
                                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeAvatar()">
                                                <i class="fa fa-trash me-1"></i> Xóa ảnh
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">Họ tên</label>
                                <input type="text" name="name" class="form-control form-control-lg" value="{{ old('name', $user['name'] ?? '') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">Email</label>
                                <input type="email" name="email" class="form-control form-control-lg" value="{{ old('email', $user['email'] ?? '') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control form-control-lg" value="{{ old('phone', $user['phone'] ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">Giới tính</label>
                                <select name="gender" class="form-select form-select-lg">
                                    <option value="" disabled {{ !($user['gender'] ?? null) ? 'selected' : '' }}>Chọn giới tính</option>
                                    <option value="male" {{ old('gender', $user['gender'] ?? '') == 'male' ? 'selected' : '' }}>Nam</option>
                                    <option value="female" {{ old('gender', $user['gender'] ?? '') == 'female' ? 'selected' : '' }}>Nữ</option>
                                    <option value="other" {{ old('gender', $user['gender'] ?? '') == 'other' ? 'selected' : '' }}>Khác</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">Ngày sinh</label>
                                <input type="date" name="birth_date" class="form-control form-control-lg" value="{{ old('birth_date', $user['birth_date'] ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted">Địa chỉ</label>
                                <input type="text" name="address" class="form-control form-control-lg" value="{{ old('address', $user['address'] ?? '') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold text-muted">Mật khẩu mới <span class="text-muted">(bỏ trống nếu không đổi)</span></label>
                                <input type="password" name="password" class="form-control form-control-lg" placeholder="Nhập mật khẩu mới">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('user.profile.show') }}" class="btn btn-outline-secondary px-4">Hủy</a>
                            <button type="submit" class="btn btn-warning text-white px-4">
                                <i class="fa fa-save me-1"></i> Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@section('scripts')
<script>
    function previewAvatar(event) {
        const input = event.target;
        const preview = document.getElementById('avatar-preview');
        const icon = document.getElementById('avatar-icon');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'inline-block';
                if (icon) icon.style.display = 'none';
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    function removeAvatar() {
        if (confirm('Bạn có chắc chắn muốn xóa ảnh đại diện?')) {
            // Add a hidden input to indicate avatar removal
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'remove_avatar';
            input.value = '1';
            document.querySelector('form').appendChild(input);
            
            // Update the UI
            const preview = document.getElementById('avatar-preview');
            const icon = document.getElementById('avatar-icon');
            
            if (preview) {
                preview.src = '';
                preview.style.display = 'none';
            }
            
            if (icon) {
                icon.style.display = 'block';
            }
        }
        return false;
    }
</script>
@endsection
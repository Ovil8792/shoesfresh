<div class="mb-3">
    <label for="name" class="form-label">Tên người dùng</label>
    <input type="text" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" class="form-control" placeholder="Nhập tên người dùng" required>
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="form-control" placeholder="Nhập email" required>
</div>

<div class="mb-3">
    <label for="phone" class="form-label">Số điện thoại</label>
    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}" class="form-control" placeholder="Nhập số điện thoại">
</div>

<div class="mb-3">
    <label for="address" class="form-label">Địa chỉ</label>
    <textarea id="address" name="address" class="form-control" rows="3" placeholder="Nhập địa chỉ">{{ old('address', $user->address ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="password" class="form-label">Mật khẩu{{ isset($user) ? ' (để trống nếu không đổi)' : '' }}</label>
    <input type="password" id="password" name="password" class="form-control" placeholder="Nhập mật khẩu" {{ !isset($user) ? 'required' : '' }}>
</div>

@if(!isset($user))
<div class="mb-3">
    <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu" required>
</div>
@endif

<div class="mb-3">
    <label for="role" class="form-label">Vai trò</label>
    <select id="role" name="role" class="form-select" required>
        <option value="">Chọn vai trò</option>
        <option value="customer" {{ old('role', $user->role ?? '') == 'customer' ? 'selected' : '' }}>Khách hàng</option>
        <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Quản trị viên</option>
    </select>
</div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Lưu
    </button>
    <a href="{{ route('admin.user') }}" class="btn btn-outline-secondary">Hủy</a>
</div>


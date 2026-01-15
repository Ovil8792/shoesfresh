<!-- Modal Thêm Danh Mục -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="{{ route('user.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Tạo Tài Khoản</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="name" class="form-label">Tài khoản <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        @error('password')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Giới tính</label>
                        <select class="form-select" id="gender" name="gender">
                            <option value="">-- Chọn giới tính --</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Nam</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Nữ</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Khác</option>
                        </select>
                        @error('gender')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="birth_date" class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                        @error('birth_date')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
                        @error('address')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="points" class="form-label">Điểm thưởng</label>
                        <input type="number" class="form-control" id="points" name="points" value="{{ old('points', 0) }}" min="0">
                        @error('points')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tier" class="form-label">Cấp độ thành viên</label>
                        <select class="form-select" id="tier" name="tier">
                            <option value="basic" {{ old('tier', 'basic') == 'basic' ? 'selected' : '' }}>Basic</option>
                            <option value="premium" {{ old('tier') == 'premium' ? 'selected' : '' }}>Premium</option>
                        </select>
                        @error('tier')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vai trò <span class="text-danger">*</span></label>
                        <select class="form-select" name="role_id" required>
                            <option value="">-- Chọn vai trò --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name ?? 'Vai trò ' . $role->id }}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Kết thúc Modal -->


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - ShoesFresh</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>

    :root {
        --color-primary-start: #da7d43ff; /* Xanh Tím */
        --color-primary-end: #da7d43ff; /* Hồng Tím */
        --color-primary-focus: #da7d43ff; /* Màu khi focus/link */
        --color-background-body: #f7f7f7;
        --color-background-input: #f8f8f8;
        --color-text-dark: #212529;
        --color-text-light: #da7d43ff;
        --shadow-color: rgba(31, 38, 135, 0.15); /* Shadow đậm hơn một chút */
    }

    body {
        min-height: 100vh;
        background: var(--color-background-body);
        font-family: 'Nunito', sans-serif;
    }
    
    /* 💳 Card chính */
    .login-card {
        background: #fff;
        border-radius: 1.5rem;
        box-shadow: 0 10px 40px 0 var(--shadow-color); /* Shadow sắc nét hơn */
        padding: 2.5rem 2.5rem 2.5rem 2.5rem; /* Tăng padding nhẹ */
        margin-top: 40px;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .login-card:hover {
        /* Hiệu ứng nổi nhẹ khi rê chuột (tùy chọn) */
        /* box-shadow: 0 12px 50px 0 rgba(31, 38, 135, 0.20); */
    }

    /* 🖋️ Typography */
    .auth-title {
        font-weight: 700;
        font-size: 2.25rem; /* Tăng kích thước tiêu đề */
        color: var(--color-primary-start); /* Dùng màu Xanh Tím cho tiêu đề */
    }
    .auth-subtitle {
        color: var(--color-text-light);
        font-size: 1.1rem; /* Tăng kích thước chữ phụ */
        margin-bottom: 2rem !important;
    }
    .text-link {
        color: var(--color-primary-focus); /* Màu Hồng Tím */
        font-weight: 700;
        text-decoration: none;
        transition: color 0.2s;
    }
    .text-link:hover {
        text-decoration: underline;
        color: var(--color-primary-start); /* Xanh Tím khi hover */
    }

    /* 📝 Form Controls */
    .form-group {
        position: relative;
    }
    .form-control {
        padding-left: 3rem; /* Tăng padding để icon và chữ không bị chạm */
        background: var(--color-background-input);
        border-radius: 0.75rem;
        border: 1px solid #e0e0e0; /* Viền mờ cho input */
        height: 55px; /* Chiều cao input lớn hơn */
    }
    .form-control:focus {
        box-shadow: 0 0 0 0.15rem var(--color-primary-focus), 0 0 5px rgba(200, 80, 192, 0.5); /* Shadow nhẹ nhàng hơn */
        border-color: var(--color-primary-focus);
        background: #fff;
    }

    /* 🏷️ Icons trong Input */
    .form-control-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--color-primary-focus); /* Đồng bộ màu icon với màu focus */
        font-size: 1.3rem; /* Tăng kích thước icon */
        pointer-events: none; /* Đảm bảo không bị click nhầm */
    }

    /* 🔘 Gradient Button */
    .btn-gradient {
        background: linear-gradient(90deg, var(--color-primary-start) 0%, var(--color-primary-end) 100%);
        color: #fff;
        border: none;
        font-weight: 700;
        transition: all 0.3s ease;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem; /* Bo góc đồng bộ với input */
        box-shadow: 0 4px 15px 0 rgba(193, 83, 192, 0.4); /* Shadow nổi bật */
    }
    .btn-gradient:hover {
        /* Đảo gradient và tăng độ sáng nhẹ */
        background: linear-gradient(90deg, var(--color-primary-end) 0%, var(--color-primary-start) 100%);
        color: #fff;
        box-shadow: 0 6px 20px 0 rgba(193, 83, 192, 0.6);
        transform: translateY(-1px);
    }
    
    /* 👤 Avatar Upload */
    #avatar-preview {
        border: 4px solid var(--color-primary-focus) !important; /* Viền nổi bật hơn */
        object-fit: cover;
        box-shadow: 0 0 0 3px #fff; /* Border trắng ảo */
        transition: all 0.3s;
    }
    #avatar-preview:hover {
        transform: scale(1.03);
    }

    /* 🚨 CHỈNH SỬA ĐẶC BIỆT CHO MÀU CAM CỦA AVATAR US */
    .auth-logo img[src^="https://ui-avatars.com"] {
        /* Áp dụng filter để đổi màu avatar mặc định */
        filter: hue-rotate(200deg) saturate(1.5) brightness(1.1); /* Điều chỉnh giá trị để đạt được màu xanh tương tự */
        border: 4px solid var(--color-primary-focus) !important; /* Đồng bộ viền */
        box-shadow: 0 0 0 3px #fff;
    }

    .position-absolute.bg-primary {
        /* Điều chỉnh nút camera */
        background-color: var(--color-primary-start) !important; /* Thay màu cam của nút camera thành xanh tím */
        box-shadow: 0 0 0 2px #fff; 
        padding: 0.5rem !important; 
        font-size: 1rem;
    }
    .position-absolute.bg-primary:hover {
        background-color: var(--color-primary-end) !important; /* Màu hover của nút camera */
    }

    /* 💬 Thông báo */
    .alert {
        border-radius: 0.75rem;
        font-weight: 600;
    }
    .alert-danger {
        background-color: #fce3e7;
        color: #d94254;
        border-color: #f7b7be;
    }
    .alert-success {
        background-color: #e3fcf3;
        color: #2e8b57;
        border-color: #b7f7e3;
    }

    /* 📱 Responsive */
    @media (max-width: 576px) {
        .login-card {
            padding: 2rem 1.5rem;
        }
        .auth-title {
            font-size: 1.75rem;
        }
    }
</style>
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="col-12 col-sm-10 col-md-8 col-lg-5">
            <div class="login-card">
                <div class="text-center auth-logo">
                </div>
                <h1 class="auth-title text-center mb-2">Đăng ký</h1>
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form method="POST" action="{{ route('user.register.submit') }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Avatar Upload -->
                    <div class="form-group mb-4 text-center">
                        <div class="position-relative d-inline-block">
                            <img id="avatar-preview" src="https://ui-avatars.com/api/?name=User&background=random" class="rounded-circle border" width="120" height="120" alt="Avatar">
                            <label for="avatar" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2" style="cursor: pointer;">
                                <i class="bi bi-camera"></i>
                            </label>
                            <input type="file" id="avatar" name="avatar" class="d-none" accept="image/*" onchange="previewImage(this)">
                        </div>
                        @error('avatar')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <span class="form-control-icon"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control form-control-lg" name="name" value="{{ old('name') }}" placeholder="Họ tên" required>
                        @error('name')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <span class="form-control-icon"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control form-control-lg" name="email" value="{{ old('email') }}" placeholder="Email" required>
                        @error('email')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <span class="form-control-icon"><i class="bi bi-telephone"></i></span>
                        <input type="tel" class="form-control form-control-lg" name="phone" value="{{ old('phone') }}" placeholder="Số điện thoại" required>
                        @error('phone')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <span class="form-control-icon"><i class="bi bi-geo-alt"></i></span>
                        <input type="text" class="form-control form-control-lg" name="address" value="{{ old('address') }}" placeholder="Địa chỉ" required>
                        @error('address')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <span class="form-control-icon"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control form-control-lg" name="password" placeholder="Mật khẩu" required>
                        @error('password')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <span class="form-control-icon"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" class="form-control form-control-lg" name="password_confirmation" placeholder="Xác nhận mật khẩu" required>
                    </div>
                    <button class="btn btn-gradient w-100 btn-lg mb-3" type="submit">Đăng ký</button>
                </form>
                <div class="text-center mt-3">
                    <span>Đã có tài khoản? <a href="{{ route('user.login') }}" class="text-link">Đăng nhập</a></span>
                </div>
            </div>
        </div>
    </div>
    <script>
        function previewImage(input) {
            const preview = document.getElementById('avatar-preview');
            const file = input.files[0];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            
            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
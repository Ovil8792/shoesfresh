
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShoesFresh • Admin Portal</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Nunito:wght@400;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin-auth.css') }}">
</head>

<body class="admin-auth">
    <div class="auth-grid">
        <div class="auth-showcase">
            <div class="auth-orb one"></div>
            <div class="auth-orb two"></div>
            <img src="{{ asset('img/logo3.png') }}" alt="ShoesFresh" style="width:120px;">
            <h2>Không gian quản trị mới</h2>
            <p>Giao diện Aurora control cho phép bạn theo dõi đơn hàng, sản phẩm và đội ngũ chỉ với vài thao tác.</p>
                        </div>
        <div class="auth-panel">
            <h1>Đăng nhập</h1>
            <small>Nhập thông tin tài khoản của bạn để tiếp tục.</small>

            <form class="auth-form" action="{{ route('admin.login') }}" method="POST">
                            @csrf
                <div>
                    <label for="email">Tài khoản</label>
                    <input type="text" id="email" name="email" class="auth-input" value="{{ old('email') }}"
                        required autofocus>
                                @error('email')
                        <p class="auth-error">{{ $message }}</p>
                                @enderror
                            </div>
                <div>
                    <label for="password">Mật khẩu</label>
                    <input type="password" id="password" name="password" class="auth-input"
                        required>
                                @error('password')
                        <p class="auth-error">{{ $message }}</p>
                                @enderror
                </div>
                <label class="auth-remember">
                    <input type="checkbox" name="remember" value="1">
                    <span>Ghi nhớ lần đăng nhập này</span>
                </label>
                <button class="auth-button" type="submit">
                    <i class="bi bi-unlock me-2"></i> Truy cập bảng điều khiển
                </button>
            </form>
        </div>
    </div>
</body>

</html>

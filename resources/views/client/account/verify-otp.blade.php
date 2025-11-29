
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác minh OTP - ShoesFresh</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: #f7f7f7;
            font-family: 'Nunito', sans-serif;
        }
        .login-card {
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.10);
            padding: 2.5rem 2rem 2rem 2rem;
            margin-top: 40px;
        }
        .auth-logo img {
            width: 80px;
            margin-bottom: 1rem;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.2rem #c850c055;
            border-color: #c850c0;
        }
        .btn-gradient {
            background: linear-gradient(90deg, #4158d0 0%, #c850c0 100%);
            color: #fff;
            border: none;
            font-weight: 700;
            transition: background 0.3s;
        }
        .btn-gradient:hover {
            background: linear-gradient(90deg, #c850c0 0%, #4158d0 100%);
            color: #fff;
        }
        .form-control-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #c850c0;
            font-size: 1.2rem;
        }
        .form-group {
            position: relative;
        }
        .form-control {
            padding-left: 2.5rem;
            background: #f8f8f8;
            border-radius: 0.75rem;
        }
        .auth-title {
            font-weight: 700;
            font-size: 2rem;
            color: #4158d0;
        }
        .auth-subtitle {
            color: #888;
            font-size: 1rem;
        }
        .text-link {
            color: #c850c0;
            font-weight: 700;
            text-decoration: none;
        }
        .text-link:hover {
            text-decoration: underline;
        }
        @media (max-width: 576px) {
            .login-card {
                padding: 1.5rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="col-12 col-sm-10 col-md-8 col-lg-5">
            <div class="login-card">
                <div class="text-center auth-logo">
                    <img src="/assets/images/logo/logo.png" alt="ShoesFresh Logo">
                </div>
                <h1 class="auth-title text-center mb-2">Xác minh OTP</h1>
                <p class="auth-subtitle text-center mb-4">Nhập email và mã OTP đã gửi đến email của bạn.</p>
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form method="POST" action="{{ route('client.account.verify-otp') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <span class="form-control-icon"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control form-control-lg" name="email" placeholder="Nhập email của bạn" value="{{ old('email') }}" required>
                        @error('email')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <span class="form-control-icon"><i class="bi bi-shield-lock"></i></span>
                        <input type="text" class="form-control form-control-lg" name="otp" placeholder="Nhập mã OTP" maxlength="6" required>
                        @error('otp')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button class="btn btn-gradient w-100 btn-lg mb-3" type="submit">Xác minh OTP</button>
                </form>
                <div class="text-center mt-3">
                    <a href="{{ route('user.login') }}" class="text-link">Quay lại đăng nhập</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
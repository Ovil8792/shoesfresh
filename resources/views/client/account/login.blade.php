
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - ShoesFresh</title>
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
            box-shadow: 0 0 0 0.2rem #da7d43ff;
            border-color: #da7d43ff;
        }
        .btn-gradient {
            background: linear-gradient(90deg, #da7d43ff 0%, #da7d43ff 100%);
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
            color: #da7d43ff;
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
            color: #da7d43ff;
        }
        .auth-subtitle {
            color: #888;
            font-size: 1rem;
        }
        .text-link {
            color: #da7d43ff;
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
                <h1 class="auth-title text-center mb-2">Đăng nhập</h1>
                <form action="{{ route('user.login.submit') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <span class="form-control-icon"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control form-control-lg" name="email" value="{{ old('email') }}" placeholder="Email" required>
                    </div>
                    <div class="form-group mb-3">
                        <span class="form-control-icon"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control form-control-lg" name="password" placeholder="Mật khẩu" required>
                        @error('email')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Ghi nhớ đăng nhập
                            </label>
                        </div>
                    </div>
                    <button class="btn btn-gradient w-100 btn-lg mb-3" type="submit">Đăng nhập</button>
                </form>
                <div class="text-center mt-3">
                    <span>Chưa có tài khoản? <a href="{{ route('user.register') }}" class="text-link">Đăng ký</a></span>
                </div>
        </div>
    </div>
</body>
</html>
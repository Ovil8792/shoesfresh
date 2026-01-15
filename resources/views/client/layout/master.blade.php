<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="ShoesFresh">
    <meta name="keywords" content="Sneaker, Shop, Shoes">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ShoesFresh</title>

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Montserrat:wght@400;600;700&display=swap"
        rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">

    <style>
        body {
            font-family: 'Roboto', 'Montserrat', Arial, sans-serif;
            font-size: 16px;
            color: #111827;
            background: #fff3e6; /* Light orange background */
            padding-top: 158px; /* Adjusted for hotline bar + header */
        }

        /* Nút (Buttons) */
        button,
        .btn,
        .site-btn,
        .hero__categories__all {
            background-color: #ffddb3; /* Light orange to match header */
            color: #111827; /* Dark text for better contrast */
            border: none;
            transition: background 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        button:hover,
        .btn:hover,
        .site-btn:hover {
            background-color: #f97316;
            /* cam cháy khi hover */
            color: #fff !important;
            box-shadow: 0 4px 16px rgba(249, 115, 22, 0.3);
        }

        /* Tiêu đề */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .section-title h2 {
            font-family: 'Montserrat', Arial, sans-serif;
            font-weight: 700;
            color: #111827;
        }

        /* Footer */
        .footer {
            background-color: #ffffff;
            color: #d1d5db;
        }

        .footer__widget h6,
        .footer__about__logo a,
        .footer__widget__social a {
            color: #fff;
        }

        .footer__widget__social a:hover {
            color: #facc15;
            /* vàng mù tạt */
        }

        /* Product Images */
        .featured__item__pic img,
        .latest-product__item__pic img {
            border-radius: 4px;
        }

        /* Hotline Bar */
        .hotline-bar {
            background-color: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 9px 0;
            font-size: 13px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1001;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .hotline-bar__left,
        .hotline-bar__right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .hotline-bar__left {
            justify-content: flex-start;
        }

        .hotline-bar__right {
            justify-content: flex-end;
        }

        .hotline-text {
            color: #111827;
            font-weight: 400;
        }

        .hotline-text strong {
            color: #f97316;
            font-weight: 600;
        }

        .hotline-text i {
            color: #f97316;
            margin-right: 5px;
        }

        .hotline-link {
            color: #111827;
            text-decoration: none;
            transition: color 0.2s;
            font-weight: 400;
        }

        .hotline-link:hover {
            color: #f97316;
            text-decoration: none;
        }

        .hotline-separator {
            color: #d1d5db;
            margin: 0 5px;
        }

        .language-selector {
            display: inline-block;
        }

        /* Responsive for Hotline Bar */
        @media (max-width: 768px) {
            .hotline-bar {
                font-size: 11px;
                padding: 6px 0;
            }

            .hotline-bar__left,
            .hotline-bar__right {
                flex-wrap: wrap;
                gap: 5px;
            }

            .hotline-separator {
                display: none;
            }

            .hotline-bar__right {
                justify-content: flex-start;
                margin-top: 5px;
            }

            body {
                padding-top: 140px; /* Adjusted for mobile */
            }

            .header {
                top: 0;
            }

            .hotline-bar {
                position: relative;
                z-index: 1001;
            }
        }

        /* Header */
        .header {
            border-bottom: 0.1px solid #ffffff;
            position: fixed;
            top: 38px;
            left: 0;
            width: 100%;
            z-index: 1000;
            background: #ffddb3; /* Light orange background */
            box-shadow: 0 2px 8px rgb(255, 255, 255);
            transition: all 0.3s;
        }

        .header__top {
            will-change: transform;
        }

        .header.shrink {
            min-height: 38px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .header.shrink .site-branding img {
            max-height: 28px;
            transition: max-height 0.3s;
        }

        .header__menu ul li a {
            position: relative;
            font-size: 15px;
            text-transform: uppercase;
            color: #111111;
            font-weight: 500;
            display: block;
            padding: 5px 0;
            position: relative;
        }

        .header__menu ul li.active a {
            color: #f97316;
        }

        /* Cart and auth icons */
        .header__cart ul li a,
        .header__top__right__auth a {
            color: #111827;
            margin-top: 28px;
            font-size: 25px;
        }

        .header__top__right__auth a:hover {
            color: #f97316;
        }

        .dropdown-toggle-no-caret::after {
            display: none !important;
        }

        /* Language switch */
        .header__top__right__language>div {
            color: #111827;
        }

        .product__details__option .btn,
        .product__details__option .optionimage {
            background: #fff !important;
            color: #000000 !important;
            border-color: #000000f1 !important;
            border-radius: 5px !important;
            margin-right: 5px !important;
            cursor: pointer;
            transition: 0.2s;
        }

        .product__details__option .btn:hover,
        .product__details__option .optionimage:hover {
            background: #000000 !important;
            color: #ffffff !important;
        }

        .roduct__details__option .optionimage.active,
        .product__details__option .optionimage:active {
            background: #000 !important;
            color: #fff !important;
            border-color: #000 !important;
        }

        .hero__categories {
            background: #ffddb3; /* Light orange to match header */
            padding: 0;
            border-radius: 5px;
            overflow: hidden;
            border: 1px solid #ffcc99; /* Slightly darker border for definition */
        }
        
        .hero__categories__all span,
        .hero__categories__all i.fa {
            color: #000000; /* Black text and icons for better visibility */
        }
        
        .hero__categories ul {
            display: none;
            position: absolute;
            top: 47px;
            left: 15px;
            width: 255px;
            z-index: 1000;
            background: #ffddb3; /* Light orange to match header */
            border: 1px solid #ffcc99; /* Slightly darker border for definition */
            border-top: none;
            border-radius: 0 0 5px 5px;
        }

        .hero__categories.active ul {
            display: block;
        }

        .header__logo img {
            max-height: 55px;
            transition: max-height 0.3s;
        }

        .banner1 {
            width: 100%;
            height: 700px;
            display: block;
            margin: 0 auto;
            padding-top: 5px;
            padding-bottom: 10px;
        }

        .input-group {
            display: flex;
            align-items: center;
            margin-top: 20px;
            color: #ced4da;
        }

        .input-group input {
            border: 1px solid #fffffff1;
            border-radius: 5px 5 5 5px;
            padding: 10px;
            width: 100%;
            font-size: 16px;
        }

        .input-group-text {
            background-color: #ffffff;
            color: #000000;
            border: none;
            box-shadow: none;
            height: 38px;
            width: 28px;
            border-radius: 5px 0 0 5px;
        }

        .input-group-text:hover {
            background-color: #ffffff;
            box-shadow: #ffffff 0px 0px 0px 1px inset;
        }

        .input-group input:focus {
            box-shadow: none;
            outline: none;
            border-color: #ffffff;
        }

        .section-title {
            text-align: center;
            margin-bottom: 30px;
            padding-top: 40px;
        }

        .optionimage.selected {
            background-color: #e0e0e0;
            /* màu nền khi được chọn */
            border: 2px solid #007bff;
            /* viền nổi bật */
            color: #000;
        }

        .featured__item {
            box-sizing: border-box;
            border: 1px solid transparent;
            transition: border-color 0.3s ease;

        }

        .featured__item:hover {
            border-color: black;
        }

        .product__item {
            box-sizing: border-box;
            border: 1px solid transparent;
            transition: border-color 0.3s ease;

        }

        .product__item:hover {
            border-color: black;
        }

        .optionsize.active,
        .optionsize.btn-success,
        .optioncolor.active,
        .optioncolor.btn-success {
            background-color: #000000 !important;
            color: #fff !important;
            border-color: #000000 !important;
        }
        .sidebar__item__color label[style*="outline"] {
            box-shadow: 0 0 0 2px #2563eb;
        }
        .sidebar__item__size label[style*="2px solid #2563eb"] {
            box-shadow: 0 0 0 2px #2563eb;
        }
        .color-label {
    width: 30px;
    height: 30px;
    display: inline-block;
    border-radius: 50%;
    margin-right: 7px;
    cursor: pointer;
    position: relative;
    border: 2px solid #eee;
    transition: border 0.2s, box-shadow 0.2s;
}
.color-label.active,
.color-label:hover {
    border: 2.5px solid #2563eb;
    box-shadow: 0 0 0 3px #e3f0fc;
}

.size-label {
    display: inline-block;
    padding: 7px 14px;
    border-radius: 6px;
    cursor: pointer;
    margin-right: 7px;
    margin-bottom: 7px;
    border: 1.5px solid #ccc;
    background: #fff;
    font-weight: 500;
    transition: border 0.2s, background 0.2s, color 0.2s;
}
.size-label.active,
.size-label:hover {
    border: 2px solid #2563eb;
    background: #e3f0fc;
    color: #2563eb;
}
.sidebar__item__size {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 10px;
}
.size-label {
    display: inline-block;
    padding: 7px 14px;
    border-radius: 6px;
    cursor: pointer;
    border: 1.5px solid #ccc;
    background: #fff;
    font-weight: 500;
    transition: border 0.2s, background 0.2s, color 0.2s;
    margin-bottom: 6px;
}
.size-label.active,
.size-label:hover {
    border: 2px solid #2563eb;
    background: #e3f0fc;
    color: #2563eb;
}
    </style>

</head>

<body>
    <!-- Loader -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Mobile Menu -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="{{ url('/') }}"><img src="{{ asset('img/logo3.png') }}" alt="Logo"></a>
        </div>
        <div class="humberger__menu__cart">
            <ul>
                <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
                <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
            </ul>
        </div>
        <div class="humberger__menu__widget">
            <div class="header__top__right__auth">
                <a href="#"><i class="fa fa-user"></i> Đăng nhập</a>
            </div>
        </div>
        <nav class="humberger__menu__nav mobile-menu">
            <ul>
                <li class="active"><a href="{{ url('/') }}">Trang chủ</a></li>
                <li><a href="{{ url('/shop') }}">Sản phẩm</a></li>
                {{-- <li><a href="#">Trang</a>
                    <ul class="header__menu__dropdown">
                        <li><a href="{{ url('/shop-details') }}">Chi tiết sản phẩm</a></li>
                        <li><a href="{{ url('/shopping-cart') }}">Giỏ hàng</a></li>
                        <li><a href="{{ url('/checkout') }}">Thanh toán</a></li>
                        <li><a href="{{ url('/blog-details') }}">Chi tiết tin tức</a></li>
                    </ul>
                </li> --}}
                <li><a href="{{ route('blog.index')  }}">Tin tức</a></li>
                <li><a href="{{ route('shop.contact.index') }}">Liên hệ</a></li>
            </ul>
        </nav>
        <div id=" mobile-menu-wrap">
        </div>
        <div class="header__top__right__social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
            <a href="#"><i class="fa fa-pinterest-p"></i></a>
        </div>
        <div class="humberger__menu__contact">
            <ul>
                <li><i class="fa fa-envelope"></i> hello@colorlib.com</li>
                <li>Miễn phí vận chuyển cho đơn từ 99$</li>
            </ul>
        </div>
    </div>
    <!-- End Mobile Menu -->

    <!-- Hotline Bar -->
    <div class="hotline-bar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="hotline-bar__left">
                        <span class="hotline-text">
                            <i class="fa fa-phone"></i> Hotline: <strong>0865091023</strong> (8h - 21h30)
                        </span>
                        <span class="hotline-separator">|</span>
                        <a href="{{ route('shop.contact.index') }}" class="hotline-link">Liên hệ hợp tác</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="hotline-bar__right">
                        <a href="{{ route('shop.contact.index') }}" class="hotline-link">Tìm cửa hàng</a>
                        <span class="hotline-separator">|</span>
                        <a href="{{ route('profile.orders') }}" class="hotline-link">Kiểm tra đơn hàng</a>
                        <span class="hotline-separator">|</span>
                        <div class="language-selector">
                            <span class="hotline-link">VN</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Hotline Bar -->

    <!-- Desktop Header -->


    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header__logo">
                        <a href="{{ url('/') }}"><img src="{{ asset('img/logo3.png') }}" alt="Logo"></a>
                    </div>
                </div>
                <div class="col-lg-7 col-md-6">
                    <nav class="header__menu d-flex justify-content-center">
                        <ul>
                            <li><a href="{{ url('/') }}">Trang chủ</a></li>
                            <li><a href="{{ url('/shop') }}">Sản phẩm</a></li>
                            {{-- <li><a href="#">Trang
                                <ul class="header__menu__dropdown">
                                    <li><a href="{{ url('/shop-details') }}">Chi tiết sản phẩm</a></li>
                                    <li><a href="{{ url('/shopping-cart') }}">Giỏ hàng</a></li>
                                    <li><a href="{{ url('/checkout') }}">Thanh toán</a></li>
                                    <li><a href="{{ url('/blog-details') }}">Chi tiết tin tức</a></li>
                                </ul>
                            </li> --}}
                            <!-- <li><a href="{{ url('/blog') }}">Sản phẩm giảm giá</a></li> -->
                            <li><a href="{{ route('shop.contact.index') }}">Liên hệ</a></li>
                        </ul>
                    </nav>
                </div>
                {{-- Giỏ hàng --}}
                <div class="col-lg-1 col-md-6 my-auto">
                    <div class="header__cart">
                        <ul>
                            <li><a class="my-auto" href="{{ url('/shop/cart') }}"><i class="fa fa-shopping-bag"
                                        style="font-size: 20px;"></i>
                                    <span></span></a>
                            </li>
                        </ul>   
                    </div>
                </div>
                <div class="col-lg-1 col-md-6 my-auto">
                    <div class="header__top__right__auth">
                        @if (session('user'))
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle dropdown-toggle-no-caret d-flex align-items-center justify-content-center"
                                    id="dropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" style="margin-top: 1px;">
                                    @if(isset(session('user')['avatar']) && session('user')['avatar'])
                                        <img src="{{ asset('storage/' . session('user')['avatar']) }}" alt="Avatar"
                                            class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover; margin-right: 8px;">
                                    @else
                                        <i class="fa fa-user-circle" style="font-size: 40px; margin-right: 8px; color: #666;"></i>
                                    @endif
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                    <span class="dropdown-item-text">Xin chào {{ collect(explode(' ', session('user.name')))->last() }}</span>
                                    <a style="font-size: 15px; margin-top: 0px;" href="{{ route('user.profile.show') }}" class="dropdown-item">Thông tin tài khoản</a>
                                    <a style="font-size: 15px; margin-top: 0px;" href="{{ route('user.logout') }}" onclick="return confirm('Bạn có chắc muốn đăng xuất?')"
                                        title="Đăng xuất" class="dropdown-item">Đăng xuất</a>
                                </div>
                            </div>
                        @else
                            <a style="margin: 0px!important" href="{{ route('user.login') }}" title="Đăng nhập">
                                <i class="fa fa-user"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- End Desktop Header -->
    @yield('main')
    <!-- Footer -->
    <footer class="footer spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__about__logo">
                            <a href="{{ url('/') }}"><img src="{{ asset('img/logo3.png') }}"
                                    alt="Logo"></a>
                        </div>
                        <ul>
                            <li>Địa chỉ: 127 Lê Thánh Tông, Ngô Quyền, Hải Phòng</li>
                            <li>Điện thoại: 0865091023</li>
                            <li>Email: tamuon00@gmail.com</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                    <div class="footer__widget">
                        <h6>Liên kết hữu ích</h6>
                        <ul>
                            <li><a href="#">Về chúng tôi</a></li>
                            <li><a href="#">Về cửa hàng</a></li>
                            <li><a href="#">Mua sắm an toàn</a></li>
                            <li><a href="#">Thông tin giao hàng</a></li>
                            <li><a href="#">Chính sách bảo mật</a></li>
                            <li><a href="#">Sơ đồ trang</a></li>
                        </ul>
                        <ul>
                            <li><a href="#">Chúng tôi là ai</a></li>
                            <li><a href="#">Dịch vụ</a></li>
                            <li><a href="#">Dự án</a></li>
                            <li><a href="#">Liên hệ</a></li>
                            <li><a href="#">Đổi mới</a></li>
                            <li><a href="{{ route('shop.feedback.index') }}">Khách hàng nói gì</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="footer__widget">
                        <h6>Đăng ký nhận tin</h6>
                        <p>Nhận thông tin mới nhất về cửa hàng và ưu đãi đặc biệt.</p>
                        <form action="#">
                            <input type="text" placeholder="Nhập email của bạn">
                            <button type="submit" class="site-btn">Đăng ký</button>
                        </form>
                        <div class="footer__widget__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-pinterest"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer__copyright">
                        <div class="footer__copyright__text">
                            <p>
                                Copyright &copy;
                                <script>
                                    document.write(new Date().getFullYear());
                                </script> All rights reserved 
                            </p>
                        </div>
                        <div class="footer__copyright__payment">
                            <img src="{{ asset('img/payment-item.png') }}" alt="Payment">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer -->

    <!-- Js Plugins -->
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('js/mixitup.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.product__details__option .optionimage').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.product__details__option .optionimage').forEach(
                        function(b) {
                            b.classList.remove('active');
                        });
                    this.classList.add('active');
                });
            });
        });
    </script>
    {{-- Category toggle --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const catAll = document.querySelector('.hero__categories__all');
            const heroCat = document.querySelector('.hero__categories');
            catAll.addEventListener('click', function() {
                heroCat.classList.toggle('active');
            });
        });
    </script>
    {{-- Menu --}}
    <script>
        let lastScroll = 0;
        window.addEventListener('scroll', function() {
            const topBar = document.getElementById('topBar');
            if (!topBar) return;
            if (window.scrollY > 30) {
                topBar.style.transform = 'translateY(-100%)';
                topBar.style.transition = 'transform 0.3s';
            } else {
                topBar.style.transform = 'translateY(0)';
            }

        });
        //
    </script>
</body>

</html>

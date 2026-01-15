<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShoesFresh Admin</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Nunito:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin-dashboard.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">
    @stack('styles')
</head>

@php
    $admin = session('admin');
    $roleId = $admin['role_id'] ?? null;
    $roleLabel = [
        1 => 'Quản trị toàn quyền',
        3 => 'Nhân viên quầy',
        4 => 'Điều phối giao hàng',
    ][$roleId] ?? 'Thành viên';
    $isActive = function ($patterns) {
        foreach ((array) $patterns as $pattern) {
            if (request()->is($pattern)) {
                return true;
            }
        }
        return false;
    };
@endphp

<body class="admin-shell">
    <div class="admin-app" id="adminApp" data-base-url="{{ url('/') }}">
        <aside class="admin-sidebar" id="adminSidebar">
        <div class="brand-area" style="margin-bottom: 0 !important;">
                        <img width="90%" src="{{ asset('img/logo3.png') }}" alt="ShoesFresh">
                    </div>
                    <p class="nav-card__desc text-center">Admin Control</p>


            @if ($admin)
                <div class="account-summary">
                    <span class="account-name">{{ $admin['name'] ?? 'Admin' }}</span>
                    <span class="account-role">{{ $roleLabel }}</span>
                </div>
            @endif

            <div class="nav-grid">
                @if ($roleId == 1)
                    <section class="nav-card">
                        <header class="nav-card__head">
                            <span class="nav-card__title">Điều hướng chính</span>
                        </header>
                        <ul class="nav-list nav-list--grid">
                            <li class="nav-item {{ $isActive(['admin/stastic']) ? 'active' : '' }}">
                                <a href="{{ url('admin/stastic') }}" data-spa-link>
                                    <span class="nav-icon">
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M4 19h16"/>
                                            <path d="M6 15l3-4 3 3 5-7"/>
                                            <circle cx="14" cy="10" r="0.1" stroke-width="2"/>
                                        </svg>
                                    </span>
                                    <span>Thống kê</span>
                                </a>
                            </li>
                            <li class="nav-item {{ $isActive(['admin/order*']) ? 'active' : '' }}">
                                <a href="{{ url('admin/order') }}" data-spa-link>
                                    <span class="nav-icon"><i class="bi bi-cart3"></i></span>
                                    <span>Đơn hàng</span>
                                </a>
                            </li>
                            <li class="nav-item {{ $isActive(['admin/delivery*']) ? 'active' : '' }}">
                                <a href="{{ url('admin/delivery') }}" data-spa-link>
                                    <span class="nav-icon"><i class="bi bi-truck"></i></span>
                                    <span>Giao vận</span>
                                </a>
                            </li>
                            <li class="nav-item {{ $isActive(['admin/user*']) ? 'active' : '' }}">
                                <a href="{{ url('admin/user') }}" data-spa-link>
                                    <span class="nav-icon"><i class="bi bi-people"></i></span>
                                    <span>Người dùng</span>
                                </a>
                            </li>
                        </ul>
                    </section>

                    <section class="nav-card">
                        <header class="nav-card__head">
                            <span class="nav-card__title">Sản phẩm</span>
                        </header>
                        <ul class="nav-list nav-list--grid">
                            <li class="nav-item {{ $isActive(['admin/category*']) ? 'active' : '' }}">
                                <a href="{{ url('admin/category') }}" data-spa-link>
                                    <span class="nav-icon"><i class="bi bi-folder2-open"></i></span>
                                    <span>Danh mục</span>
                                </a>
                                    </li>
                            <li class="nav-item {{ $isActive(['admin/product*']) ? 'active' : '' }}">
                                <a href="{{ url('admin/product') }}" data-spa-link>
                                    <span class="nav-icon"><i class="bi bi-box-seam"></i></span>
                                    <span>Sản phẩm</span>
                                </a>
                                    </li>
                            <li class="nav-item {{ $isActive(['admin/product/trash']) ? 'active' : '' }}">
                                <a href="{{ route('product.trash') }}" data-spa-link>
                                    <span class="nav-icon"><i class="bi bi-trash"></i></span>
                                    <span>Thùng rác</span>
                                </a>
                            </li>
                            <li class="nav-item {{ $isActive(['admin/brand*']) ? 'active' : '' }}">
                                <a href="{{ url('admin/brand') }}" data-spa-link>
                                    <span class="nav-icon">
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round">
                                            <path d="M12 3l2.4 4.9 5.4.8-3.9 3.8.9 5.4L12 15.8 6.3 18.9l1-5.4-3.9-3.8 5.4-.8z"/>
                                        </svg>
                                    </span>
                                    <span>Thương hiệu</span>
                                </a>
                                    </li>
                            <li class="nav-item {{ $isActive(['admin/product/color*']) ? 'active' : '' }}">
                                <a href="{{ url('admin/product/color') }}" data-spa-link>
                                    <span class="nav-icon"><i class="bi bi-palette"></i></span>
                                    <span>Màu sắc</span>
                                </a>
                                    </li>
                            <li class="nav-item {{ $isActive(['admin/product/size*']) ? 'active' : '' }}">
                                <a href="{{ url('admin/product/size') }}" data-spa-link>
                                    <span class="nav-icon"><i class="bi bi-aspect-ratio"></i></span>
                                    <span>Kích cỡ</span>
                                </a>
                            </li>
                            <li class="nav-item {{ $isActive(['admin/discounts*']) ? 'active' : '' }}">
                                <a href="{{ route('admin.discounts.index') }}" data-spa-link>
                                    <span class="nav-icon"><i class="bi bi-tag"></i></span>
                                    <span>Giảm giá sản phẩm</span>
                                </a>
                            </li>
                        </ul>
                    </section>

                    <section class="nav-card">
                        <header class="nav-card__head">
                            <span class="nav-card__title">Marketing & Nội dung</span>
                        </header>
                        <ul class="nav-list nav-list--grid">
                            <li class="nav-item {{ $isActive(['admin/voucher*']) ? 'active' : '' }}">
                                <a href="{{ url('admin/voucher') }}" data-spa-link>
                                    <span class="nav-icon">
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                                            <rect x="3" y="6" width="18" height="12" rx="3"/>
                                            <path d="M7 9.5h5M7 14.5h3"/>
                                            <circle cx="17" cy="12" r="1.6"/>
                                        </svg>
                                    </span>
                                    <span>Mã giảm giá</span>
                                </a>
                            </li>
                            <li class="nav-item {{ $isActive(['admin/contact*']) ? 'active' : '' }}">
                                <a href="{{ url('admin/contact') }}" data-spa-link>
                                    <span class="nav-icon"><i class="bi bi-envelope-open"></i></span>
                                    <span>Liên hệ</span>
                                </a>
                            </li>
                            <li class="nav-item {{ $isActive(['admin/feedback*']) ? 'active' : '' }}">
                                <a href="{{ url('admin/feedback') }}" data-spa-link>
                                    <span class="nav-icon"><i class="bi bi-hand-thumbs-up"></i></span>
                                    <span>Feedback</span>
                                </a>
                            </li>
                            <li class="nav-item {{ $isActive(['admin/comment*']) ? 'active' : '' }}">
                                <a href="{{ url('admin/comment') }}" data-spa-link>
                                    <span class="nav-icon"><i class="bi bi-chat-square-text"></i></span>
                                    <span>Bình luận</span>
                                </a>
                            </li>
                        </ul>
                    </section>
                @elseif($roleId == 4)
                    <section class="nav-card">
                        <header class="nav-card__head">
                            <span class="nav-card__title">Tác vụ giao vận</span>
                        </header>
                        <ul class="nav-list">
                            <li class="nav-item {{ $isActive(['admin/delivery*']) ? 'active' : '' }}">
                                <a href="{{ url('admin/delivery') }}" data-spa-link>
                                    <span class="nav-icon"><i class="bi bi-truck"></i></span>
                                    <span>Quản lý giao hàng</span>
                                </a>
                            </li>
                        </ul>
                    </section>
                @elseif($roleId == 3)
                    <section class="nav-card">
                        <header class="nav-card__head">
                            <span class="nav-card__title">Điểm bán</span>
                        </header>
                        <ul class="nav-list">
                            <li class="nav-item {{ $isActive(['pos', 'pos/*']) ? 'active' : '' }}">
                                <a href="{{ url('pos') }}" data-spa-link>
                                    <span class="nav-icon"><i class="bi bi-cash-stack"></i></span>
                                    <span>Quản lý bán hàng</span>
                                </a>
                            </li>
                        </ul>
                    </section>
                        @endif

                <section class="nav-card">
                    <header class="nav-card__head">
                        <span class="nav-card__title">Hệ thống</span>
                    </header>
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a href="{{ route('admin.logout') }}" onclick="return confirm('Bạn có chắc muốn đăng xuất?')">
                                <span class="nav-icon"><i class="bi bi-box-arrow-right"></i></span>
                                <span>Đăng xuất</span>
                            </a>
                        </li>
                    </ul>
                </section>
            </div>
        </aside>

        <div class="admin-content">
            <main class="admin-main" id="adminMain">
                <button class="mobile-toggle" data-sidebar-toggle aria-label="Mở menu" style="margin-bottom: 16px;">
                    <i class="bi bi-list"></i>
                </button>
            @yield('main')
            </main>

        </div>
    </div>

    <div id="pageScripts">
        @stack('scripts')
    </div>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
    <script type="module" src="{{ asset('assets/js/admin-spa.js') }}"></script>
</body>

</html>

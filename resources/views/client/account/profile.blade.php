@extends('client.layout.master')

@section('main')
<style>
    .account-hero {
        background: linear-gradient(135deg, #fdeee4, #f7f9ff);
        padding: 50px 0;
    }
    .profile-card {
        border-radius: 30px;
        background: #fff;
        position: relative;
    }
    .profile-card .blur-circle {
        position: absolute;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255,196,141,0.35), transparent 70%);
        top: -80px;
        right: -40px;
        z-index: 0;
    }
    .profile-card .info-tile {
        background: #fef6ee;
        border-radius: 18px;
        padding: 16px 20px;
        height: 100%;
        box-shadow: inset 0 0 0 1px rgba(255, 171, 92, 0.12);
    }
    .profile-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 16px;
    }
    .profile-grid .info-tile {
        width: 100%;
    }
    .profile-grid .label {
        font-size: 0.9rem;
        text-transform: uppercase;
        color: #a36a3f;
        letter-spacing: .05em;
        display: flex;
        align-items: center;
        margin-bottom: 6px;
    }
    .profile-grid .label i {
        margin-right: 8px;
    }
    .profile-grid .value {
        font-size: 1rem;
        color: #0f172a;
        font-weight: 600;
    }
    .profile-card .btn-warning {
        background: linear-gradient(120deg, #ffc48d, #ff9f57);
        border: none;
    }
</style>
<section class="account-hero">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="profile-card shadow-lg rounded-4 border-0 bg-white p-4 position-relative overflow-hidden">
                    <div class="blur-circle"></div>
                    <div class="text-center mb-4">
                        @if(isset($user['avatar']) && $user['avatar'])
                            <img src="{{ asset('storage/' . $user['avatar']) }}" alt="Avatar" class="rounded-circle border border-4 border-warning-subtle" style="width:120px;height:120px;object-fit:cover;">
                        @else
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center" style="width:120px;height:120px;">
                                <i class="fa fa-user text-secondary" style="font-size:48px;"></i>
                            </div>
                        @endif
                        <h3 class="fw-bold mt-3 mb-0">{{ $user['name'] ?? 'Người dùng' }}</h3>
                        <p class="text-muted">Thông tin tài khoản</p>
                    </div>

                    <div class="row g-3 profile-grid">
                        <div class="col-md-6">
                            <div class="info-tile">
                                <span class="label"><i class="fa fa-envelope me-2 text-primary"></i>Email</span>
                                <p class="value">{{ $user['email'] ?? '—' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-tile">
                                <span class="label"><i class="fa fa-phone me-2 text-success"></i>Số điện thoại</span>
                                <p class="value">{{ $user['phone'] ?? '—' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-tile">
                                <span class="label"><i class="fa fa-venus-mars me-2 text-warning"></i>Giới tính</span>
                                <p class="value">
                                    @if(($user['gender'] ?? '') == 'male') Nam
                                    @elseif(($user['gender'] ?? '') == 'female') Nữ
                                    @elseif(($user['gender'] ?? '') == 'other') Khác
                                    @else — @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-tile">
                                <span class="label"><i class="fa fa-birthday-cake me-2 text-danger"></i>Ngày sinh</span>
                                <p class="value">{{ $user['birth_date'] ?? '—' }}</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="info-tile">
                                <span class="label"><i class="fa fa-map-marker me-2 text-info"></i>Địa chỉ</span>
                                <p class="value mb-0">{{ $user['address'] ?? '—' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4 d-flex flex-wrap gap-2 justify-content-center">
                        <a href="{{ route('user.profile.edit', $user['id']) }}" class="btn btn-warning px-4 text-white">
                            <i class="fa fa-edit me-1"></i> Cập nhật thông tin
                        </a>
                        <a href="{{ route('profile.orders') }}" class="btn btn-outline-primary px-4">
                            <i class="fa fa-history me-1"></i> Lịch sử mua hàng
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

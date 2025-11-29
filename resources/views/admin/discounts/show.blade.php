@extends('admin.layout.master')

@section('main')
    <div class="page-heading mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h3>Chi tiết chương trình giảm giá</h3>
            <div>
                <a href="{{ route('admin.discounts.edit', $discount) }}" class="btn btn-warning me-2">
                    <i class="bi bi-pencil"></i> Chỉnh sửa
                </a>
                <a href="{{ route('admin.discounts.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Thông tin chương trình giảm giá</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Mã giảm giá:</div>
                        <div class="col-md-8">#{{ $discount->id }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Trạng thái:</div>
                        <div class="col-md-8">
                            @if($discount->is_active && $discount->start_date <= now() && $discount->end_date >= now())
                                <span class="badge bg-success">Đang áp dụng</span>
                            @elseif($discount->end_date < now())
                                <span class="badge bg-secondary">Đã hết hạn</span>
                            @elseif(!$discount->is_active)
                                <span class="badge bg-warning">Tạm dừng</span>
                            @else
                                <span class="badge bg-info">Sắp diễn ra</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Phần trăm giảm giá:</div>
                        <div class="col-md-8">
                            <span class="badge bg-danger">{{ $discount->discount_percent }}%</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Thời gian áp dụng:</div>
                        <div class="col-md-8">
                            Từ {{ \Carbon\Carbon::parse($discount->start_date)->format('d/m/Y H:i') }}<br>
                            Đến {{ \Carbon\Carbon::parse($discount->end_date)->format('d/m/Y H:i') }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Ngày tạo:</div>
                        <div class="col-md-8">{{ $discount->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 fw-bold">Cập nhật lần cuối:</div>
                        <div class="col-md-8">{{ $discount->updated_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Thông tin sản phẩm</h5>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset($discount->product->thumbnail) }}" 
                         alt="{{ $discount->product->name }}" 
                         class="img-fluid rounded mb-3"
                         style="max-height: 200px; width: auto;">
                    <h5>{{ $discount->product->name }}</h5>
                    <p class="text-muted">Mã sản phẩm: #{{ $discount->product->id }}</p>
                    
                    <div class="d-flex justify-content-around align-items-center mb-3">
                        <div class="text-center">
                            <div class="text-muted small">Giá gốc</div>
                            <div class="text-decoration-line-through">
                                {{ number_format($discount->product->price) }} đ
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-muted small">Giảm giá</div>
                            <div class="text-danger fw-bold">
                                {{ $discount->discount_percent }}%
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-muted small">Giá sau giảm</div>
                            <div class="text-success fw-bold">
                                {{ number_format($discount->product->price * (1 - $discount->discount_percent / 100)) }} đ
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('admin.products.edit', $discount->product) }}" 
                       class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-box-arrow-up-right"></i> Xem sản phẩm
                    </a>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title">Hành động</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($discount->is_active)
                            <form action="{{ route('admin.discounts.toggle-status', $discount) }}" method="POST" class="d-grid">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-pause"></i> Tạm dừng
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.discounts.toggle-status', $discount) }}" method="POST" class="d-grid">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-play"></i> Kích hoạt
                                </button>
                            </form>
                        @endif
                        
                        <form action="{{ route('admin.discounts.destroy', $discount) }}" method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa chương trình giảm giá này?')">
                                <i class="bi bi-trash"></i> Xóa giảm giá
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

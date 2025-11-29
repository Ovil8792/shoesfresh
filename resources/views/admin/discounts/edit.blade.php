@extends('admin.layout.master')

@section('main')
    <div class="page-heading mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h3>Chỉnh sửa chương trình giảm giá</h3>
            <a href="{{ route('admin.discounts.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <strong>Thông tin giảm giá</strong>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.discounts.update', $discount) }}" method="POST" id="discountForm">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <!-- Thông tin sản phẩm (chỉ hiển thị, không chỉnh sửa) -->
                    <div class="col-12">
                        <div class="card bg-light mb-3">
                            <div class="card-body">
                                <h6>Thông tin sản phẩm</h6>
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <img src="{{ asset($discount->product->thumbnail) }}" 
                                             alt="{{ $discount->product->name }}" 
                                             class="img-fluid rounded"
                                             style="width: 80px; height: 80px; object-fit: cover;">
                                    </div>
                                    <div>
                                        <h5 class="mb-1">{{ $discount->product->name }}</h5>
                                        <p class="mb-1">Mã sản phẩm: #{{ $discount->product->id }}</p>
                                        <p class="mb-0">Giá gốc: {{ number_format($discount->product->price) }} đ</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Phần trăm giảm giá -->
                    <div class="col-md-6">
                        <label for="discount_percent" class="form-label">Phần trăm giảm giá (%) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" 
                                   class="form-control @error('discount_percent') is-invalid @enderror" 
                                   id="discount_percent" 
                                   name="discount_percent" 
                                   value="{{ old('discount_percent', $discount->discount_percent) }}"
                                   min="1" 
                                   max="100" 
                                   required>
                            <span class="input-group-text">%</span>
                            @error('discount_percent')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Trạng thái -->
                    <div class="col-md-6">
                        <label class="form-label">Trạng thái</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" 
                                   id="is_active" name="is_active" value="1"
                                   {{ $discount->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                {{ $discount->is_active ? 'Đang kích hoạt' : 'Tạm dừng' }}
                            </label>
                        </div>
                    </div>

                    <!-- Ngày bắt đầu -->
                    <div class="col-md-6">
                        <label for="start_date" class="form-label">Ngày bắt đầu <span class="text-danger">*</span></label>
                        <input type="datetime-local" 
                               class="form-control @error('start_date') is-invalid @enderror" 
                               id="start_date" 
                               name="start_date" 
                               value="{{ old('start_date', \Carbon\Carbon::parse($discount->start_date)->format('Y-m-d\TH:i')) }}"
                               required>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ngày kết thúc -->
                    <div class="col-md-6">
                        <label for="end_date" class="form-label">Ngày kết thúc <span class="text-danger">*</span></label>
                        <input type="datetime-local" 
                               class="form-control @error('end_date') is-invalid @enderror" 
                               id="end_date" 
                               name="end_date" 
                               value="{{ old('end_date', \Carbon\Carbon::parse($discount->end_date)->format('Y-m-d\TH:i')) }}"
                               required>
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Xem trước giảm giá -->
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">Xem trước giảm giá</h6>
                                <div class="row">
                                    <div class="col-md-2 text-center">
                                        <img src="{{ asset($discount->product->thumbnail) }}" 
                                             alt="{{ $discount->product->name }}" 
                                             class="img-fluid rounded"
                                             style="width: 100px; height: 100px; object-fit: cover;">
                                    </div>
                                    <div class="col-md-10">
                                        <h5>{{ $discount->product->name }}</h5>
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <span class="text-muted">Giá gốc:</span>
                                                <span id="original-price" class="text-decoration-line-through text-muted">
                                                    {{ number_format($discount->product->price) }} đ
                                                </span>
                                            </div>
                                            <div class="me-3">
                                                <span class="text-muted">Giảm:</span>
                                                <span id="discount-amount" class="text-danger fw-bold">
                                                    {{ $discount->discount_percent }}%
                                                </span>
                                            </div>
                                            <div>
                                                <span class="text-muted">Giá sau giảm:</span>
                                                <span id="final-price" class="fw-bold text-success">
                                                    {{ number_format($discount->product->price * (1 - $discount->discount_percent / 100)) }} đ
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <span class="text-muted">Thời gian áp dụng: </span>
                                            <span id="discount-period">
                                                Từ {{ \Carbon\Carbon::parse($discount->start_date)->format('d/m/Y H:i') }} 
                                                đến {{ \Carbon\Carbon::parse($discount->end_date)->format('d/m/Y H:i') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Cập nhật giảm giá
                    </button>
                    <a href="{{ route('admin.discounts.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const discountPercent = document.getElementById('discount_percent');
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');
        const originalPrice = parseFloat({{ $discount->product->price }});
        
        // Cập nhật xem trước khi có thay đổi
        function updatePreview() {
            const discount = parseFloat(discountPercent.value) || 0;
            const discountAmount = (originalPrice * discount) / 100;
            const finalPrice = originalPrice - discountAmount;
            
            // Cập nhật giá
            document.getElementById('discount-amount').textContent = discount + '% (-' + discountAmount.toLocaleString() + ' đ)';
            document.getElementById('final-price').textContent = finalPrice.toLocaleString() + ' đ';
            
            // Cập nhật thời gian áp dụng
            if (startDate.value && endDate.value) {
                const start = new Date(startDate.value).toLocaleString('vi-VN');
                const end = new Date(endDate.value).toLocaleString('vi-VN');
                document.getElementById('discount-period').textContent = `Từ ${start} đến ${end}`;
            }
        }
        
        // Gắn sự kiện thay đổi
        discountPercent.addEventListener('input', updatePreview);
        startDate.addEventListener('change', updatePreview);
        endDate.addEventListener('change', updatePreview);
        
        // Cập nhật xem trước ban đầu
        updatePreview();
        
        // Validate form
        document.getElementById('discountForm').addEventListener('submit', function(e) {
            const start = new Date(startDate.value);
            const end = new Date(endDate.value);
            
            if (end <= start) {
                e.preventDefault();
                alert('Ngày kết thúc phải sau ngày bắt đầu');
                return false;
            }
            
            return true;
        });
        
        // Toggle switch status text
        const statusSwitch = document.getElementById('is_active');
        const statusLabel = statusSwitch.nextElementSibling;
        
        statusSwitch.addEventListener('change', function() {
            statusLabel.textContent = this.checked ? 'Đang kích hoạt' : 'Tạm dừng';
        });
    });
</script>
@endpush

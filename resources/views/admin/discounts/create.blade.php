@extends('admin.layout.master')

@section('main')
    <div class="page-heading mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h3>Thêm chương trình giảm giá</h3>
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
            <form action="{{ route('admin.discounts.store') }}" method="POST" id="discountForm">
                @csrf

                <div class="row g-3">
                    <!-- Chọn sản phẩm -->
                    <div class="col-md-6">
                        <label for="product_id" class="form-label">Chọn sản phẩm <span class="text-danger">*</span></label>
                        <select class="form-select @error('product_id') is-invalid @enderror" id="product_id" name="product_id" required>
                            <option value="">-- Chọn sản phẩm --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-thumbnail="{{ asset($product->thumbnail) }}">
                                    {{ $product->name }} ({{ number_format($product->price) }}đ)
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phần trăm giảm giá -->
                    <div class="col-md-6">
                        <label for="discount_percent" class="form-label">Phần trăm giảm giá (%) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" 
                                   class="form-control @error('discount_percent') is-invalid @enderror" 
                                   id="discount_percent" 
                                   name="discount_percent" 
                                   min="1" 
                                   max="100" 
                                   required>
                            <span class="input-group-text">%</span>
                            @error('discount_percent')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Ngày bắt đầu -->
                    <div class="col-md-6">
                        <label for="start_date" class="form-label">Ngày bắt đầu <span class="text-danger">*</span></label>
                        <input type="datetime-local" 
                               class="form-control @error('start_date') is-invalid @enderror" 
                               id="start_date" 
                               name="start_date" 
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
                                        <img id="product-thumbnail" src="{{ asset('assets/images/no-image.jpg') }}" 
                                             alt="Hình ảnh sản phẩm" 
                                             class="img-fluid rounded"
                                             style="width: 100px; height: 100px; object-fit: cover;">
                                    </div>
                                    <div class="col-md-10">
                                        <h5 id="product-name">Chưa chọn sản phẩm</h5>
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <span class="text-dark">Giá gốc:</span>
                                                <span id="original-price" class="text-decoration-line-through text-dark">0 đ</span>
                                            </div>
                                            <div class="me-3">
                                                <span class="text-dark">Giảm:</span>
                                                <span id="discount-amount" class="text-danger fw-bold">0%</span>
                                            </div>
                                            <div>
                                                <span class="text-dark">Giá sau giảm:</span>
                                                <span id="final-price" class="fw-bold text-success">0 đ</span>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <span class="text-dark">Thời gian áp dụng: </span>
                                            <span id="discount-period" class="text-dark">Chưa cập nhật</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Lưu giảm giá
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
        const productSelect = document.getElementById('product_id');
        const discountPercent = document.getElementById('discount_percent');
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');
        
        // Cập nhật xem trước khi có thay đổi
        function updatePreview() {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const price = parseFloat(selectedOption.dataset.price) || 0;
            const discount = parseFloat(discountPercent.value) || 0;
            const discountAmount = (price * discount) / 100;
            const finalPrice = price - discountAmount;
            
            // Cập nhật hình ảnh và tên sản phẩm
            const thumbnail = selectedOption.dataset.thumbnail || '{{ asset("assets/images/no-image.jpg") }}';
            document.getElementById('product-thumbnail').src = thumbnail;
            document.getElementById('product-name').textContent = selectedOption.text || 'Chưa chọn sản phẩm';
            
            // Cập nhật giá
            document.getElementById('original-price').textContent = price.toLocaleString() + ' đ';
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
        productSelect.addEventListener('change', updatePreview);
        discountPercent.addEventListener('input', updatePreview);
        startDate.addEventListener('change', updatePreview);
        endDate.addEventListener('change', updatePreview);
        
        // Đặt ngày mặc định
        const now = new Date();
        startDate.value = now.toISOString().slice(0, 16);
        
        const tomorrow = new Date(now);
        tomorrow.setDate(tomorrow.getDate() + 1);
        endDate.value = tomorrow.toISOString().slice(0, 16);
        
        // Cập nhật xem trước ban đầu
        updatePreview();
        
        // Validate form
        document.getElementById('discountForm').addEventListener('submit', function(e) {
            if (!productSelect.value) {
                e.preventDefault();
                alert('Vui lòng chọn sản phẩm');
                return false;
            }
            
            const start = new Date(startDate.value);
            const end = new Date(endDate.value);
            
            if (end <= start) {
                e.preventDefault();
                alert('Ngày kết thúc phải sau ngày bắt đầu');
                return false;
            }
            
            return true;
        });
    });
</script>
@endpush

<!-- Modal Thêm Mã Giảm Giá -->
<div class="modal fade" id="addVoucherModal" tabindex="-1" aria-labelledby="addVoucherModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('voucher.store') }}" method="POST" id="voucherForm">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addVoucherModalLabel">Thêm mã giảm giá</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="code" class="form-label">Mã giảm giá</label>
            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" required>
            @error('code')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"></textarea>
            @error('description')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="discount_type" class="form-label">Loại giảm giá</label>
            <select class="form-select @error('discount_type') is-invalid @enderror" id="discount_type" name="discount_type" required>
              <option value="percent">Phần trăm (%)</option>
              <option value="fixed">Số tiền cố định</option>
            </select>
            @error('discount_type')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="discount_value" class="form-label">Giá trị giảm</label>
            <input type="number" class="form-control @error('discount_value') is-invalid @enderror" id="discount_value" name="discount_value" required min="1">
            @error('discount_value')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="max_discount" class="form-label">Giảm tối đa</label>
            <input type="number" class="form-control @error('max_discount') is-invalid @enderror" id="max_discount" name="max_discount" required min="0">
            @error('max_discount')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="min_order_value" class="form-label">Giá trị đơn tối thiểu</label>
            <input type="number" class="form-control @error('min_order_value') is-invalid @enderror" id="min_order_value" name="min_order_value" required min="0">
            @error('min_order_value')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="usage_limit" class="form-label">Số lượt sử dụng</label>
            <input type="number" class="form-control @error('usage_limit') is-invalid @enderror" id="usage_limit" name="usage_limit" required min="1">
            @error('usage_limit')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="valid_from" class="form-label">
              <i class="bi bi-calendar-event me-2"></i>Ngày bắt đầu <small class="text-muted">(dd/mm/yyyy)</small>
            </label>
            <input type="date" class="form-control @error('valid_from') is-invalid @enderror" id="valid_from" name="valid_from" required>
            <div class="form-text">Chọn ngày bắt đầu hiệu lực của voucher</div>
            @error('valid_from')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="valid_to" class="form-label">
              <i class="bi bi-calendar-check me-2"></i>Ngày kết thúc <small class="text-muted">(dd/mm/yyyy)</small>
            </label>
            <input type="date" class="form-control @error('valid_to') is-invalid @enderror" id="valid_to" name="valid_to" required>
            <div class="form-text">Chọn ngày kết thúc hiệu lực của voucher</div>
            @error('valid_to')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
          <button type="submit" class="btn btn-primary">Lưu</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('voucherForm');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors
        document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        
        // Disable submit button and show loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang lưu...';
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close modal and reload page to show new voucher
                const modal = bootstrap.Modal.getInstance(document.getElementById('addVoucherModal'));
                modal.hide();
                location.reload();
            } else if (data.errors) {
                // Show validation errors
                for (const [field, messages] of Object.entries(data.errors)) {
                    const input = document.querySelector(`[name="${field}"]`);
                    if (input) {
                        input.classList.add('is-invalid');
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback d-block';
                        errorDiv.textContent = Array.isArray(messages) ? messages[0] : messages;
                        input.parentNode.appendChild(errorDiv);
                    }
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Fallback to regular form submission if AJAX fails
            form.submit();
        })
        .finally(() => {
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Lưu';
        });
    });
    
    // Clear errors when user starts typing
    form.querySelectorAll('input, select, textarea').forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            const errorDiv = this.parentNode.querySelector('.invalid-feedback');
            if (errorDiv) {
                errorDiv.remove();
            }
        });
    });
});
</script>
<!-- Kết thúc Modal -->

<!-- Modal Thêm Mã Giảm Giá -->
<div class="modal fade" id="addVoucherModal" tabindex="-1" aria-labelledby="addVoucherModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('voucher.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addVoucherModalLabel">Thêm mã giảm giá</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="code" class="form-label">Mã giảm giá</label>
            <input type="text" class="form-control" id="code" name="code" required>
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea class="form-control" id="description" name="description"></textarea>
          </div>
          <div class="mb-3">
            <label for="discount_type" class="form-label">Loại giảm giá</label>
            <select class="form-select" id="discount_type" name="discount_type" required>
              <option value="percent">Phần trăm (%)</option>
              <option value="fixed">Số tiền cố định</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="discount_value" class="form-label">Giá trị giảm</label>
            <input type="number" class="form-control" id="discount_value" name="discount_value" required min="1">
          </div>
          <div class="mb-3">
            <label for="max_discount" class="form-label">Giảm tối đa</label>
            <input type="number" class="form-control" id="max_discount" name="max_discount" min="0">
          </div>
          <div class="mb-3">
            <label for="min_order_value" class="form-label">Giá trị đơn tối thiểu</label>
            <input type="number" class="form-control" id="min_order_value" name="min_order_value" min="0">
          </div>
          <div class="mb-3">
            <label for="usage_limit" class="form-label">Số lượt sử dụng</label>
            <input type="number" class="form-control" id="usage_limit" name="usage_limit" min="1">
          </div>
          <div class="mb-3">
            <label for="valid_from" class="form-label">Ngày bắt đầu</label>
            <input type="date" class="form-control" id="valid_from" name="valid_from" required>
          </div>
          <div class="mb-3">
            <label for="valid_to" class="form-label">Ngày kết thúc</label>
            <input type="date" class="form-control" id="valid_to" name="valid_to" required>
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
<!-- Kết thúc Modal -->

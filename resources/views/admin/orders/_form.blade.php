<div class="mb-3">
    <label for="order_code" class="form-label">Mã đơn hàng</label>
    <input type="text" id="order_code" name="order_code" value="{{ old('order_code', $order->order_code ?? '') }}" class="form-control" placeholder="Nhập mã đơn hàng" required>
</div>

<div class="mb-3">
    <label for="customer_name" class="form-label">Tên khách hàng</label>
    <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name', $order->customer_name ?? '') }}" class="form-control" placeholder="Nhập tên khách hàng" required>
</div>

<div class="mb-3">
    <label for="customer_phone" class="form-label">Số điện thoại</label>
    <input type="text" id="customer_phone" name="customer_phone" value="{{ old('customer_phone', $order->customer_phone ?? '') }}" class="form-control" placeholder="Nhập số điện thoại" required>
</div>

<div class="mb-3">
    <label for="customer_email" class="form-label">Email</label>
    <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email', $order->customer_email ?? '') }}" class="form-control" placeholder="Nhập email">
</div>

<div class="mb-3">
    <label for="address" class="form-label">Địa chỉ</label>
    <textarea id="address" name="address" class="form-control" rows="3" placeholder="Nhập địa chỉ" required>{{ old('address', $order->address ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="total_amount" class="form-label">Tổng tiền (VNĐ)</label>
    <input type="number" id="total_amount" name="total_amount" value="{{ old('total_amount', $order->total_amount ?? '') }}" class="form-control" placeholder="Nhập tổng tiền" required>
</div>

<div class="mb-3">
    <label for="status" class="form-label">Trạng thái</label>
    <select id="status" name="status" class="form-select" required>
        <option value="">Chọn trạng thái</option>
        <option value="pending" {{ old('status', $order->status ?? '') == 'pending' ? 'selected' : '' }}>Đang chờ</option>
        <option value="processing" {{ old('status', $order->status ?? '') == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
        <option value="shipped" {{ old('status', $order->status ?? '') == 'shipped' ? 'selected' : '' }}>Đã giao hàng</option>
        <option value="completed" {{ old('status', $order->status ?? '') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
        <option value="cancelled" {{ old('status', $order->status ?? '') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
    </select>
</div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Lưu
    </button>
    <a href="{{ route('admin.order') }}" class="btn btn-outline-secondary">Hủy</a>
</div>


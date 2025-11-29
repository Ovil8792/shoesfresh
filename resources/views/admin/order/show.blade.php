@extends('admin.layout.master')
@section('main')
    <div class="container" style="max-width: 900px;">
        <div class="row justify-content-center mt-5">
            <div class="col-md-12">
                <div class="card shadow-lg" style="border-radius: 16px;">
                    <div class="card-header text-center"
                        style="background: #4663b2; color: #fff; border-top-left-radius: 16px; border-top-right-radius: 16px;">
                        <h4 class="mb-0 py-2">Chi tiết đơn hàng #{{ $order->id }}</h4>
                    </div>
                    <div class="card-body px-5 py-4">
                        <table class="table table-borderless mb-4">
                            <tr>
                                <td><b>Tên khách hàng:</b></td>
                                <td>{{ $order->user->name ?? 'Chưa xác định' }}</td>
                            </tr>
                            <tr>
                                <td><b>Tổng tiền:</b></td>
                                <td>{{ number_format($order->total_amount, 0, ',', '.') }}₫</td>
                            </tr>
                            <tr>
                                <td><b>Voucher:</b></td>
                                <td>{{ $order->voucher_id ?? 'Không áp dụng' }}</td>
                            </tr>
                            <tr>
                                <td><b>Giảm giá:</b></td>
                                <td>{{ number_format($order->discount_applied, 0, ',', '.') }}₫</td>
                            </tr>
                            <tr>
                                <td><b>Trạng thái:</b></td>
                                <td>
                                    <form action="{{ route('order.updateStatus', $order->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('PUT')

                                        <select name="status"
                                                class="form-select form-select-sm order-status-dropdown"
                                                style="min-width:160px; display:inline-block;"
                                                {{ $order->status == 'completed' ? 'disabled' : '' }}>
                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                            <option value="delivering" {{ $order->status == 'delivering' ? 'selected' : '' }}>Đang giao</option>
                                            <option value="completed"  {{ $order->status == 'completed'  ? 'selected' : '' }}>Hoàn tất</option>
                                            <option value="cancelled"  {{ $order->status == 'cancelled'  ? 'selected' : '' }}>Đã hủy</option>
                                            <option value="paid"       {{ $order->status == 'paid'       ? 'selected' : '' }}>Đã thanh toán</option>
                                        </select>


                                        {{-- input ẩn để nhét lý do hủy trước khi submit --}}
                                        <input type="hidden" name="cancel_reason" class="cancel-reason-input" value="">
                                    </form>

                                    @error('cancel_reason')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                        @if ($order->status == 'cancelled')
                                <tr>
                                    <td><b>Lý do hủy:</b></td>
                                    <td>{{ $order->cancel_reason ?? 'Không có lý do' }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td><b>Thanh toán:</b></td>
                                <td>
                                    @php
                                        $pm = strtoupper((string) $order->payment_method);
                                        $st = (string) $order->status;
                                        // VNPay và đơn không pending/cancelled ⇒ coi như đã thanh toán (hiển thị)
                                        $isPaidByDisplay = ($pm === 'VNPAY') && !in_array($st, ['pending','cancelled','Đã huỷ'], true);
                                    @endphp

                                    @if($isPaidByDisplay)
                                        <span class="badge bg-success">Đã thanh toán</span>
                                    @else
                                        {{ ucfirst($order->payment_method) }}
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td><b>Địa chỉ giao:</b></td>
                                <td>{{ $order->shipping_address }}</td>
                            </tr>
                            <tr>
                                <td><b>Ngày tạo:</b></td>
                                <td>{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '' }}</td>
                            </tr>
                        </table>

                        <h5 class="mb-3"><b>Danh sách sản phẩm</b></h5>
                        <div class="table-responsive">
                            <table class="table table-striped align-middle" style="background: #f7faff;">
                                <thead>
                                    <tr>
                                        <th>ID sản phẩm</th>
                                        <th>Danh mục sản phẩm</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Giá</th>
                                        <th>Tổng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($order->orderItems as $item)
                                        <tr>
                                            <td>{{ $item->variant->product->id ?? 'N/A' }}</td>
                                            <td>{{ $item->variant->product->category->name ?? 'N/A' }}</td>
                                            <td>{{ $item->variant->product->name ?? 'N/A' }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->price, 0, ',', '.') }}₫</td>
                                            <td>{{ number_format($item->quantity * $item->price, 0, ',', '.') }}₫</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-danger">Không có sản phẩm nào trong
                                                đơn này</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-center bg-white"
                        style="border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                        <a href="{{ route('order.index') }}" class="btn btn-outline-secondary px-4 me-2">Quay lại</a>
                        {{-- Nếu cần, thêm nút chỉnh sửa hoặc các nút khác ở đây --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<div class="modal fade" id="cancelReasonModal" tabindex="-1" aria-labelledby="cancelReasonLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="cancelReasonForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelReasonLabel">Nhập lý do hủy đơn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <textarea class="form-control" id="cancelReasonInput" rows="3" placeholder="Vui lòng nhập lý do hủy..." required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Quay lại</button>
                    <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdown = document.querySelector('.order-status-dropdown');
        if (!dropdown) return;

        let prevStatus = dropdown.value;
        let currentForm = dropdown.closest('form');

        dropdown.addEventListener('focus', function(){ prevStatus = this.value; });

        dropdown.addEventListener('change', function () {
            if (this.value === 'cancelled') {
                // Mở modal để nhập lý do
                const modalEl = document.getElementById('cancelReasonModal');
                const bsModal = new bootstrap.Modal(modalEl);
                bsModal.show();

                // Nếu đóng modal mà không submit -> revert về trạng thái cũ
                modalEl.addEventListener('hidden.bs.modal', function () {
                    const reasonHidden = currentForm.querySelector('.cancel-reason-input');
                    if (!reasonHidden.value) dropdown.value = prevStatus;
                }, { once: true });
            } else {
                // Trạng thái khác hủy -> submit luôn
                currentForm.submit();
            }
        });

        // Submit modal: nhét lý do vào hidden input rồi submit form
        document.getElementById('cancelReasonForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const reason = document.getElementById('cancelReasonInput').value.trim();
            if (!reason) return;

            currentForm.querySelector('.cancel-reason-input').value = reason;
            bootstrap.Modal.getInstance(document.getElementById('cancelReasonModal')).hide();
            currentForm.submit();
        });
    });
</script>


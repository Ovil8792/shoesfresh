@extends('admin.layout.master')
@section('main')
    <div class="page-heading">
        <h3>Đơn hàng</h3>
    </div>

    <section class="section">
        <div class="row" id="table-head">
            <div class="col-12">
                <div class="card-content">
                    {{-- Tìm kiếm --}}
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        <form method="GET" action="{{ route('order.index') }}" class="d-flex" style="gap: 8px;">
                            <input
                                type="text"
                                name="keyword"
                                placeholder="Tìm kiếm ..."
                                value="{{ request('keyword') }}"
                                class="form-control"
                                style="max-width: 180px; border-radius: 8px; border: 1px solid #e1e7f0; background: #f8faff;"
                            >
                            <select
                                name="status"
                                class="form-select"
                                style="min-width: 140px; border-radius: 8px; border: 1px solid #e1e7f0; background: #f8faff;"
                            >
                                <option value="" {{ ($status === '') ? 'selected' : '' }}>-- Tất cả trạng thái --</option>
                                <option value="processing" {{ ($status === 'processing') ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="confirmed" {{ ($status === 'confirmed') ? 'selected' : '' }}>Đã xác nhận</option>
                                <option value="completed"  {{ ($status === 'completed')  ? 'selected' : '' }}>Hoàn tất</option>
                                <option value="cancelled"  {{ ($status === 'cancelled')  ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                            <button
                                type="submit"
                                class="btn"
                                style="border: 1px solid #4663b2; color: #4663b2; background: #fff; border-radius: 6px; font-weight: 500; min-width: 90px;"
                            >
                                Tìm kiếm
                            </button>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <thead class="table-white">
                            <tr>
                                <th>ID</th>
                                <th>Họ tên</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Voucher</th>
                                <th>Giảm giá</th>
                                <th>Trạng thái</th>
                                <th>Thanh toán</th>
                                <th>Địa chỉ giao</th>
                                <th>Ngày tạo</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>

                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->phone }}</td>

                                    <td>{{ $item->voucher_id ?? 'Không áp dụng' }}</td>
                                    <td>{{ number_format($item->discount_applied, 0, ',', '.') }}₫</td>

                                    <td>
                                        @php
                                            $badgeClass = match($item->status) {
                                                'processing'  => 'badge bg-warning text-dark rounded-pill px-3 py-2',
                                                'confirmed'   => 'badge bg-info rounded-pill px-3 py-2',
                                                'delivering'  => 'badge bg-primary rounded-pill px-3 py-2',
                                                'completed'   => 'badge bg-success rounded-pill px-3 py-2',
                                                'cancelled'   => 'badge bg-danger rounded-pill px-3 py-2',
                                                default       => 'badge bg-secondary rounded-pill px-3 py-2',
                                            };
                                            $statusText = match($item->status) {
                                                'processing'  => 'Đang xử lý',
                                                'confirmed'   => 'Đã xác nhận',
                                                'delivering'  => 'Đang giao',
                                                'completed'   => 'Hoàn tất',
                                                'cancelled'   => 'Đã hủy',
                                                default       => $item->status,
                                            };
                                        @endphp
                                        <span class="{{ $badgeClass }}">{{ $statusText }}</span>
                                    </td>

                                    <td>
                                        @php
                                            $pm = strtoupper((string) $item->payment_method);
                                            $st = (string) $item->status;
                                            
                                            // Logic: Nếu đơn hàng đã hoàn thành thì phải đã thanh toán
                                            if ($st === 'completed') {
                                                $paymentStatus = 'Đã thanh toán';
                                                $paymentClass = 'success';
                                            } elseif ($pm === 'VNPAY') {
                                                // Nếu thanh toán bằng VNPay, kể cả khi hủy vẫn hiển thị đã thanh toán
                                                $paymentStatus = 'Đã thanh toán';
                                                $paymentClass = 'success';
                                            } elseif ($pm === 'COD') {
                                                $paymentStatus = 'Chưa thanh toán';
                                                $paymentClass = 'warning';
                                            } else {
                                                $paymentStatus = strtoupper($item->payment_method);
                                                $paymentClass = 'secondary';
                                            }
                                        @endphp
                                        <span class="badge bg-{{ $paymentClass }}">{{ $paymentStatus }}</span>
                                        @if($st === 'cancelled' && $pm === 'VNPAY')
                                            <br><small class="text-danger">(Cần hoàn tiền)</small>
                                        @endif
                                    </td>
                                    <td>{{ $item->shipping_address }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('order.show', $item->id) }}"
                                               class="btn btn-sm btn-info">
                                                Xem
                                            </a>
                                            <a href="{{ route('order.delete', $item->id) }}"
                                               onclick="return confirm('Bạn có chắc muốn xoá đơn hàng này?')"
                                               class="btn btn-sm btn-danger">
                                                Xóa
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Modal lý do hủy -->
                    <div class="modal fade" id="cancelReasonModal" tabindex="-1" aria-labelledby="cancelReasonLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="cancelReasonForm">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="cancelReasonLabel">Nhập lý do hủy đơn</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                    </div>
                                    <div class="modal-body">
                                        <textarea class="form-control" name="cancel_reason" id="cancelReasonInput" rows="3" placeholder="Nhập lý do hủy..." required></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Script cho modal và xử lý submit --}}
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            let currentForm = null;
                            let oldStatus = null;

                            document.querySelectorAll('.order-status-dropdown').forEach(function(dropdown) {
                                dropdown.addEventListener('focus', function() {
                                    oldStatus = this.value;
                                });
                                dropdown.addEventListener('change', function(e) {
                                    if (this.value === 'cancelled') {
                                        currentForm = this.closest('form');
                                        var cancelModal = new bootstrap.Modal(document.getElementById('cancelReasonModal'));
                                        cancelModal.show();
                                    } else {
                                        this.closest('form').submit();
                                    }
                                });
                            });

                            document.getElementById('cancelReasonForm').addEventListener('submit', function(e) {
                                e.preventDefault();
                                let reason = document.getElementById('cancelReasonInput').value;
                                if(currentForm) {
                                    currentForm.querySelector('.cancel-reason-input').value = reason;
                                    currentForm.submit();
                                }
                                bootstrap.Modal.getInstance(document.getElementById('cancelReasonModal')).hide();
                                document.getElementById('cancelReasonInput').value = '';
                            });

                            document.getElementById('cancelReasonModal').addEventListener('hidden.bs.modal', function () {
                                if(currentForm && currentForm.querySelector('.order-status-dropdown').value === 'cancelled' && !currentForm.querySelector('.cancel-reason-input').value) {
                                    currentForm.querySelector('.order-status-dropdown').value = oldStatus;
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </section>
@endsection

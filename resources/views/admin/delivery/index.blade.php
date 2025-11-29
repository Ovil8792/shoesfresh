@extends('admin.layout.master')
@section('main')
    {{-- Thông báo thành công --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center"
            style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; max-width: 250px;"
            role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    @endif

    <div class="page-heading">
        <h3>Quản lý giao hàng</h3>
    </div>

    <section class="section">
        <div class="row" id="table-head">
            <div class="col-12">
                <div class="card-content">
                    {{-- Nút thêm --}}
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">

                        {{-- Nút tìm kiếm --}}
                        <form action="{{ route('delivery.index') }}" method="GET" class="d-flex w-auto"
                            style="max-width: 200px;">
                            <input type="text" name="keyword" class="form-control form-control-sm me-2"
                                placeholder="Tìm theo đơn hàng..." value="{{ request('keyword') }}">
                            <button type="submit" class="btn btn-outline-primary btn-sm">Tìm kiếm</button>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <thead class="table-white">
                                <tr>
                                    <th>ID</th>
                                    <th>Đơn hàng</th>
                                    <th>Người giao</th>
                                    {{-- <th>Trạng thái</th> --}}
                                    <th>Địa chỉ giao hàng</th>
                                    <th>Ngày tạo</th>
                                    {{-- <th>Ngày cập nhật</th> --}}
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $hasDelivery = false; @endphp
                                @foreach ($deliveries as $delivery)
                                    @if ($delivery->order && $delivery->order->status == 'delivering')
                                        @php $hasDelivery = true; @endphp
                                        <tr>
                                            <td>{{ $delivery->id }}</td>
                                            <td>{{ $delivery->order_id }}</td>
                                            <td>{{ $delivery->user->name ?? 'Chưa có' }}</td>
                                            <td>{{ $delivery->order->shipping_address }}</td>
                                            <td>{{ $delivery->created_at }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('delivery.show', $delivery->id) }}"
                                                    class="btn btn-sm btn-info rounded-pill px-3 py-1 d-inline-flex align-items-center me-1"
                                                    title="Xem chi tiết">
                                                    <i class="fa-solid fa-eye me-1"></i>
                                                </a>
                                                @if (empty($delivery->user_id))
                                                    <a href="{{ route('delivery.accept', $delivery->id) }}"
                                                        onclick="return confirm('Bạn có chắc muốn nhận đơn hàng này?')"
                                                        class="btn btn-sm btn-success rounded-pill px-3 py-1 d-inline-flex align-items-center"
                                                        title="Nhận đơn">
                                                        <i class="bi bi-check-circle-fill me-1"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('delivery.cancel', $delivery->id) }}"
                                                        onclick="return confirm('Bạn có chắc muốn huỷ nhận đơn hàng này?')"
                                                        class="btn btn-sm btn-danger rounded-pill px-3 py-1 d-inline-flex align-items-center"
                                                        title="Huỷ nhận">
                                                        <i class="bi bi-x-circle-fill me-1"></i>
                                                    </a>
                                                @endif
                                            </td>

                                        </tr>
                                    @endif
                                @endforeach
                                @if (!$hasDelivery)
                                    <tr>
                                        <td colspan="5" class="text-center text-danger">Chưa có đơn giao hàng</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    {{-- <div class="mt-3">{{ $deliveries->appends(request()->query())->links() }}</div> --}}
                </div>
            </div>
        </div>
    </section>
@endsection

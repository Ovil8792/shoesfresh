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
    
    {{-- Thông báo lỗi --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show text-center"
            style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; max-width: 250px;"
            role="alert">
            {{ session('error') }}
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
                    <!-- Danh sách đơn hàng chờ giao -->
                    <h5 class="mb-3">Đơn hàng chờ giao</h5>
                    @if(isset($availableDeliveries) && $availableDeliveries->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <thead class="table-warning">
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Khách hàng</th>
                                    <th>Số điện thoại</th>
                                    <th>Địa chỉ giao hàng</th>
                                    <th>Ngày tạo</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($availableDeliveries as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->name }}</td>
                                    <td>{{ $order->phone }}</td>
                                    <td>{{ $order->shipping_address }}</td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('order.show', $order->id) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i> Xem chi tiết
                                        </a>
                                        <form action="{{ route('delivery.accept', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="bi bi-check"></i> Nhận đơn
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-info">Không có đơn hàng nào chờ giao.</div>
                    @endif
                    
                    <!-- Danh sách đơn hàng đang giao -->
                    <h5 class="mb-3 mt-4">Đơn hàng đang giao</h5>
                    @if(isset($deliveries) && $deliveries->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Khách hàng</th>
                                    <th>Số điện thoại</th>
                                    <th>Địa chỉ giao hàng</th>
                                    <th>Người giao</th>
                                    <th>Ngày tạo</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deliveries as $delivery)
                                <tr>
                                    <td>#{{ $delivery->order->id }}</td>
                                    <td>{{ $delivery->order->name }}</td>
                                    <td>{{ $delivery->order->phone }}</td>
                                    <td>{{ $delivery->order->shipping_address }}</td>
                                    <td>{{ $delivery->user->name ?? 'Chưa xác định' }}</td>
                                    <td>{{ $delivery->order->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('order.show', $delivery->order->id) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> Xem chi tiết
                                        </a>
                                        <form action="{{ route('delivery.confirm', $delivery->order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Xác nhận giao hàng thành công?')">
                                                <i class="bi bi-check-circle"></i> Xác nhận giao thành công
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-info">Không có đơn hàng nào đang giao.</div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

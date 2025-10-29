@extends('admin.layout.main')
@section("main")
<div class="container-fluid">
    <style>
        .status-dot { display:inline-block; width:10px; height:10px; border-radius:50%; margin-right:8px; }
    </style>
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Danh sách hóa đơn</h2>
                    <p class="text-muted mb-0">Quản lý tất cả hóa đơn trong hệ thống</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoices Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Danh sách hóa đơn</h5>
                <div class="d-flex gap-2">
                    <form method="GET" class="d-flex gap-2">
                        <div class="input-group" style="width: 160px;">
                            <span class="input-group-text">ID</span>
                            <input type="number" name="search_id" value="{{ $searchId ?? '' }}" class="form-control" placeholder="ID">
                        </div>
                        <div class="input-group" style="width: 260px;">
                            <span class="input-group-text">Tên</span>
                            <input type="text" name="search_name" value="{{ $searchName ?? '' }}" class="form-control" placeholder="Tên hóa đơn">
                        </div>
                        <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
                        <a href="{{ route('admin.category') }}" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i></a>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="hoadonTable">
                    <thead>
                        <tr>
                            <th class="border-0">#</th>
                            <th class="border-0">Khách hàng</th>
                            <th class="border-0">Mã sản phẩm</th>
                            <th class="border-0">Số lượng</th>
                            <th class="border-0">Tổng tiền</th>
                            <th class="border-0">Trạng thái</th>
                            <th class="border-0 text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hoadons as $hoadon)
                        <tr>
                            <td>{{ $hoadon->id }}</td>

                            <td>
                                @if($hoadon->user_id == 0)
                                UserTest
                                @else
                                {{ $hoadon->user_id }}
                                @endif
                            </td>

                            <td>{{ $hoadon->sanpham_id }}</td>
                            <td>{{ $hoadon->soluong }}</td>
                            <td>{{ $hoadon->tongtien }}</td>
                            <td>
                                @php
                                    $statusName = null;
                                    foreach ($trangthaihoadons as $tthd) {
                                        if ($tthd->id == $hoadon->trangthaihoadon_id) { $statusName = $tthd->name; break; }
                                    }
                                    $statusColor = 'bg-secondary';
                                    if ($statusName === 'Đã thanh toán' || $statusName === 'Hoàn thành') {
                                        $statusColor = 'bg-success bg-opacity-75';
                                    } elseif ($statusName === 'Đã hủy') {
                                        $statusColor = 'bg-danger';
                                    } elseif ($statusName === 'Đang xử lý') {
                                        $statusColor = 'bg-warning';
                                    } elseif ($statusName === 'Đang giao hàng') {
                                        $statusColor = 'bg-info';
                                    } elseif ($statusName === 'Chưa thanh toán' || $statusName === 'Đã hoàn trả') {
                                        $statusColor = 'bg-secondary';
                                    }
                                @endphp
                                <span class="status-dot {{ $statusColor }}"></span>{{ $statusName ?? '—' }}
                            </td>
                            <td>
                                <a href="{{ route('admin.hoadon.detail', $hoadon->id) }}" class="btn btn-primary">Chi tiết</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('admin.layout.main')
@section("main")
<style>
    .truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: block; /* nếu áp dụng trên span trong td */
}
</style>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Danh sách sản phẩm</h2>
                    <p class="text-muted mb-0">Quản lý tất cả sản phẩm trong hệ thống</p>
                </div>
                <div>
                    <a href="#" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Thêm sản phẩm mới
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-door-open text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">Tổng số sản phẩm</h6>
                            <h4 class="mb-0">num $</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-check-circle text-success fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">Text</h6>
                            <h4 class="mb-0"></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-clock text-warning fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">Text</h6>
                            <h4 class="mb-0"></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-currency-dollar text-info fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">Giá trung bình</h6>
                            <h4 class="mb-0"> num $</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rooms Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Danh sách sản phẩm</h5>
                <div class="d-flex gap-2">
                    <form method="GET" class="d-flex gap-2">
                        <div class="input-group" style="width: 160px;">
                            <span class="input-group-text">ID</span>
                            <input type="number" name="search_id" value="{{ $searchId ?? '' }}" class="form-control" placeholder="ID">
                        </div>
                        <div class="input-group" style="width: 260px;">
                            <span class="input-group-text">Tên</span>
                            <input type="text" name="search_name" value="{{ $searchName ?? '' }}" class="form-control" placeholder="Tên sản phẩm">
                        </div>
                        <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
                        <a href="#" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i></a>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="roomsTable">
                    <thead>
                        <tr>
                            <th class="border-0">#</th>
                            <th class="border-0">Tên sản phẩm </th>
                            <th class="border-0">Mã sản phẩm</th>
                            <th class="border-0">Ảnh</th>
                            <th class="border-0">Giá (VNĐ)</th>
                            <th class="border-0">Hãng</th>
                            <th class="border-0">Mô tả</th>
                            <th class="border-0">Kích cỡ</th>
                            <th class="border-0">Màu</th>
                            <th class="border-0">Thiết kế</th>
                            <th class="border-0">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $item )
                        <tr>
                           
                           <td class="align-middle text-muted">
                            <span class="badge bg-light text-dark">{{ $item->id }}</span>
                        </td>
                           <td class="align-middle text-muted">
                            <span class="mb-0 fw-semibol">{{ $item->name }}</span>
                           </td>
                           <td class="align-middle text-muted">
                                <span class="mb-0 fw-semibol">{{ $item->product_id }}</span>
                           </td>
                           <td class="align-middle text-muted">
                                <img width="80%" src="{{ $item->image }}">
                           </td>
                           <td class="align-middle text-muted">
                                <span class="mb-0 fw-semibol">{{ number_format($item->price,0,",",".") }} VND</span>
                           </td>
                           <td class="align-middle text-muted">
                            <span class="mb-0 fw-semibol">{{ $item->brand }}</span>
                           </td>
                           <td class="align-middle text-muted">
                            <span style="width:100px" class="mb-0 fw-semibol truncate">{{ $item->description }}</span>
                           </td>
                           <td class="align-middle text-muted">
                            <span class="mb-0 fw-semibol">{{ $item->size }}</span>
                           </td>
                           <td class="align-middle text-muted">
                            <span class="mb-0 fw-semibol">{{ $item->color }}</span>
                           </td>
                           <td class="align-middle text-muted">
                            <span class="mb-0 fw-semibol">{{ $item->design }}</span>
                           </td>
                            <td class="align-middle text-muted">
                                <span class="mb-0 fw-semibol">{{ $item->status }}</span>
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
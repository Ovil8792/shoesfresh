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
            style="position: fixed; top: 70px; left: 50%; transform: translateX(-50%); z-index: 9999; max-width: 300px;"
            role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    @endif

    <div class="page-heading">
        <h3>Danh sách giảm giá sản phẩm</h3>
    </div>

    <!-- Bảng Danh sách giảm giá -->
    <!-- Bảng Danh sách giảm giá -->
    <section class="section">
        <div class="row" id="table-head">
            <div class="col-12">
                <div class="card-content">
                    {{-- Nút thêm --}}
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        <div class="d-flex gap-2 mb-2 mb-md-0">
                            <a href="{{ route('admin.discounts.create') }}" class="btn btn-primary" data-bs-toggle="modal">
                                + Thêm giảm giá
                            </a>
                        </div>
                        <form action="{{ route('admin.discounts.index') }}" method="GET" class="d-flex w-auto" style="max-width: 200px;">
                            <input type="text" name="keyword" class="form-control form-control-sm me-2"
                                placeholder="Tìm theo tên sản phẩm..." value="{{ request('keyword') }}">
                            <button type="submit" class="btn btn-outline-primary btn-sm">Tìm kiếm</button>
                        </form>
                    </div>

                    <div class="table-responsive">
                        {{-- Bảng giảm giá --}}
                        <table class="table table-striped table-bordered align-middle">
                            <thead class="table-white">
                                <tr>
                                    <th>ID</th>
                                    <th>Sản phẩm</th>
                                    <th>Giảm giá</th>
                                    <th>Ngày bắt đầu</th>
                                    <th>Ngày kết thúc</th>
                                    <th>Trạng thái</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($discounts as $discount)
                                    <tr>
                                        <td>{{ $discount->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($discount->product->thumbnail)
                                                    <div class="me-3" style="width: 60px; height: 60px; overflow: hidden;">
                                                        <img src="{{ asset($discount->product->thumbnail) }}" 
                                                             alt="{{ $discount->product->name }}"
                                                             style="width: 100%; height: 100%; object-fit: cover;">
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ $discount->product->name }}</h6>
                                                    <small class="text-muted">#{{ $discount->product->id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-danger">{{ $discount->discount_percent }}%</span>
                                        </td>
                                        <td>{{ $discount->start_date->format('d/m/Y H:i') }}</td>
                                        <td>{{ $discount->end_date->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if ($discount->is_active && $discount->start_date <= now() && $discount->end_date >= now())
                                                <span class="badge bg-success">Đang áp dụng</span>
                                            @elseif($discount->end_date < now())
                                                <span class="badge bg-secondary">Đã hết hạn</span>
                                            @elseif(!$discount->is_active)
                                                <span class="badge bg-warning">Tạm dừng</span>
                                            @else
                                                <span class="badge bg-info">Sắp diễn ra</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex flex-wrap gap-1 justify-content-center">
                                                <a href="{{ route('admin.discounts.edit', $discount) }}" 
                                                   class="btn btn-sm btn-warning"
                                                   data-bs-toggle="tooltip" 
                                                   title="Chỉnh sửa">
                                                    Sửa
                                                </a>
                                                <form action="{{ route('admin.discounts.toggle-status', $discount) }}" 
                                                      method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            class="btn btn-sm {{ $discount->is_active ? 'btn-secondary' : 'btn-success' }}"
                                                            data-bs-toggle="tooltip"
                                                            title="{{ $discount->is_active ? 'Tạm dừng' : 'Kích hoạt' }}">
                                                        {{ $discount->is_active ? 'Tắt' : 'Bật' }}
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.discounts.destroy', $discount) }}" 
                                                      method="POST" 
                                                      onsubmit="return confirm('Bạn có chắc muốn xoá không?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger"
                                                            data-bs-toggle="tooltip"
                                                            title="Xóa">
                                                        Xóa
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Không có chương trình giảm giá nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <nav>
                            {{ $discounts->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Kích hoạt tooltip
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush

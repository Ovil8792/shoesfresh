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
        <div class="d-flex justify-content-between align-items-center">
            <h3>Thùng rác sản phẩm</h3>
            <a href="{{ route('product.index') }}" class="btn btn-outline-primary">
                <i class="fa fa-arrow-left me-1"></i>Quay lại
            </a>
        </div>
    </div>
    <!-- Bảng Danh sách sản phẩm trong thùng rác -->
    <section class="section">
        <div class="row" id="table-head">
            <div class="col-12">
                <div class="card-content">
                    {{-- Tìm kiếm --}}
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        <form action="{{ route('product.trash') }}" method="GET" class="d-flex w-auto"
                            style="max-width: 200px;">
                            <input type="text" name="keyword" class="form-control form-control-sm me-2"
                                placeholder="Tìm theo tên..." value="{{ request('keyword') }}">
                            <button type="submit" class="btn btn-outline-primary btn-sm">Tìm kiếm</button>
                        </form>
                    </div>

                    <div class="table-responsive">
                        {{-- Bảng danh sách --}}
                        <table class="table table-striped table-bordered align-middle">
                            <thead class="table-white">
                                <tr>
                                    <th>ID</th>
                                    <th>Danh mục</th>
                                    <th>Tên</th>
                                    <th>Giá</th>
                                    <th>Hình ảnh</th>
                                    <th>Ngày xóa</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->category ? $product->category->name : '' }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ number_format($product->price, 0, ',', '.') }}VND</td>
                                        <td>
                                            @if ($product->thumbnail)
                                                <img src="{{ asset($product->thumbnail) }}" alt="Ảnh sản phẩm"
                                                    style="max-width: 80px;">
                                            @else
                                                Không có ảnh
                                            @endif
                                        </td>
                                        <td>{{ $product->deleted_at ? $product->deleted_at->format('d/m/Y H:i') : '' }}</td>
                                        <td class="text-center">
                                            <div class="d-flex flex-wrap gap-1 justify-content-center">
                                                <a href="{{ route('product.restore', $product->id) }}" 
                                                   onclick="return confirm('Bạn có chắc muốn khôi phục sản phẩm này?')" 
                                                   class="btn btn-sm btn-success">
                                                    <i class="fa fa-undo me-1"></i>Khôi phục
                                                </a>
                                                <a href="{{ route('product.forceDelete', $product->id) }}" 
                                                   onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn sản phẩm này? Hành động này không thể hoàn tác!')" 
                                                   class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash me-1"></i>Xóa vĩnh viễn
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <div class="py-4">
                                                <i class="fa fa-trash" style="font-size: 48px; color: #ccc;"></i>
                                                <p class="mt-2 text-muted">Thùng rác trống</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <nav>
                            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

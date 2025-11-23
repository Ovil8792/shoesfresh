@extends('admin.layout.main')

@section('page-title', 'Chi tiết sản phẩm')
@section('main')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">Chi tiết sản phẩm</h2>
                <p class="text-muted mb-0">Thông tin chi tiết về sản phẩm</p>
            </div>
            <div>
                <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Sửa
                </a>
                <a href="{{ route('admin.product') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Danh sách
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white"><h5 class="card-title mb-0">Thông tin sản phẩm</h5></div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">ID</th>
                            <td>{{ $product->id }}</td>
                        </tr>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <td>{{ $product->name }}</td>
                        </tr>
                        <tr>
                            <th>Danh mục</th>
                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Giá</th>
                            <td>{{ number_format($product->price, 0, ',', '.') }} VND</td>
                        </tr>
                        <tr>
                            <th>Thương hiệu</th>
                            <td>{{ $product->brand ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Màu sắc</th>
                            <td>{{ $product->color ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Kích cỡ</th>
                            <td>{{ $product->size ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Thiết kế</th>
                            <td>{{ $product->design ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Trạng thái</th>
                            <td>
                                <span class="badge bg-{{ $product->status == 'active' ? 'success' : ($product->status == 'inactive' ? 'secondary' : 'warning') }}">
                                    {{ $product->status ?? 'N/A' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Mô tả</th>
                            <td>{{ $product->description ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Ngày tạo</th>
                            <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Ngày cập nhật</th>
                            <td>{{ $product->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($variants && $variants->count() > 0)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><h5 class="card-title mb-0">Biến thể sản phẩm ({{ $variants->count() }})</h5></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Màu sắc</th>
                                    <th>Kích cỡ</th>
                                    <th>Giá</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($variants as $variant)
                                <tr>
                                    <td>{{ $variant->id }}</td>
                                    <td>{{ $variant->color ?? 'N/A' }}</td>
                                    <td>{{ $variant->size ?? 'N/A' }}</td>
                                    <td>{{ number_format($variant->price, 0, ',', '.') }} VND</td>
                                    <td>
                                        <span class="badge bg-{{ $variant->status == 'active' ? 'success' : ($variant->status == 'inactive' ? 'secondary' : 'warning') }}">
                                            {{ $variant->status ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.product.show', $variant->id) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><h5 class="card-title mb-0">Hình ảnh</h5></div>
                <div class="card-body text-center">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded">
                    @else
                        <p class="text-muted">Chưa có hình ảnh</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


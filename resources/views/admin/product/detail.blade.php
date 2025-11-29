@extends('admin.layout.master')
@section('main')
    <div class="page-heading mb-4">
        <h3 class="fw-bold">Chi tiết sản phẩm</h3>
    </div>
    <div class="row justify-content-center fs-5">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="row g-0">
                    <div class="col-md-5 bg-light d-flex flex-column align-items-center justify-content-center p-4">
                        <div class="mb-3 w-100 text-center">
                            @if ($product->thumbnail)
                                <img src="{{ asset($product->thumbnail) }}" alt="Ảnh sản phẩm"
                                    class="img-fluid rounded shadow" style="max-height: 320px; object-fit: contain;">
                            @else
                                <div class="text-muted">Không có ảnh</div>
                            @endif
                        </div>
                        {{-- @if ($product->images && $product->images->count())
                            <div class="d-flex flex-wrap gap-2 justify-content-center">
                                @foreach ($product->images as $img)
                                    <img src="{{ asset($img->url) }}" alt="Ảnh phụ" class="rounded border"
                                        style="width: 60px; height: 60px; object-fit: cover; transition: 0.2s;">
                                @endforeach
                            </div>
                        @else
                            <div class="text-muted">Không có ảnh</div>
                        @endif --}}
                    </div>
                    <div class="col-md-7">
                        <div class="card-body p-4">
                            <h2 class="fw-bold mb-2 text-primary">{{ $product->name }}</h2>
                            <div class="mb-2">
                                <span
                                    class="badge bg-info text-dark">{{ $product->category->name ?? 'Không có danh mục' }}</span>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted">Thương hiệu:</span>
                                <span
                                    class="text-muted">{{ $product->brand ? $product->brand->name : 'Không có thương hiệu' }}</span>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted">Mã sản phẩm:</span>
                                <span class="text-muted ">{{ $variant->sku }}</span>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted">Kích cỡ:</span>
                                @if ($product->variants && $product->variants->count())
                                    @foreach ($product->variants->sortBy('size.value') as $variant)
                                        <span
                                            class="text-muted">{{ $variant->size->label ?? ($variant->size->value ?? '-') }}</span>
                                        @if (!$loop->last)
                                            -
                                        @endif
                                    @endforeach
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                            <div class="mb-2">
                                <span class="text-muted">Màu sắc:</span>
                                <span class="text-muted ">{{ $variant->color->name }}</span>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted">Tổng số lượng:</span>
                                <span class="text-muted">{{ $product->variants->sum('stock') }}</span>
                            </div>

                            <div class="mb-2">
                                <span class="text-muted">Giá:</span>
                                <span class="text-danger fs-5 fw-bold">{{ number_format($product->price, 0, ',', '.') }}
                                    VNĐ</span>
                            </div>

                            <div class="mb-2">
                                <span class="text-muted">Trạng thái:</span>
                                @if ($product->status == 1)
                                    <span class="badge bg-success">Hiển thị</span>
                                @else
                                    <span class="badge bg-secondary">Ẩn</span>
                                @endif
                            </div>
                            <div class="mb-2">
                                <span class="text-muted">Ngày tạo:</span>
                                {{ $product->created_at ? $product->created_at->format('d/m/Y') : '' }}
                            </div>
                            <div class="mb-3">
                                <span class="text-muted">Ngày cập nhật:</span>
                                {{ $product->updated_at ? $product->updated_at->format('d/m/Y') : '' }}
                            </div>
                            <div class="mb-3">
                                <strong class="text-muted">Mô tả:</strong>
                                <div class="border rounded p-3 bg-light mt-1" style="min-height: 80px; font-size: 1.05rem;">
                                    {!! nl2br(e($product->description)) !!}
                                </div>
                            </div>
                            <div class="text-end mt-4">
                                <a href="{{ route('product.index') }}" class="btn btn-outline-secondary px-4">Quay lại</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

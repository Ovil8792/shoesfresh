@extends('admin.layout.master')
@section('main')
    <style>
        .img-action-group .btn-delete-img {
            display: none;
        }

        .img-action-group:hover .btn-delete-img {
            display: inline-block;
        }
    </style>
    <div class="page-heading mb-4">
        <h3 class="fw-bold">Ảnh của sản phẩm: {{ $product->name }}</h3>
    </div>
    <div>
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addImageModal">
            + Thêm ảnh
        </button>
    </div>

    <div class="card shadow border-0">
        <div class="card-body">
            <div class="row g-3">
                @forelse($product->images as $img)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 text-center">
                        <div class="position-relative img-action-group">
                            <img src="{{ asset($img->url) }}" class="img-fluid rounded border mb-2"
                                style="height:110px;object-fit:cover;">
                            <form action="{{ route('product.image.delete', $img->id) }}" method="GET"
                                onsubmit="return confirm('Xóa ảnh này?');" class="d-inline">
                                @csrf

                                <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 btn-delete-img"
                                    title="Xóa">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">Chưa có ảnh nào cho sản phẩm này.</div>
                @endforelse
            </div>
        </div>
    </div>
    <a href="{{ route('product.index') }}" class="btn btn-outline-secondary mt-4">Quay lại</a>


    {{-- Modal them anh --}}
    <div class="modal fade" id="addImageModal" tabindex="-1" aria-labelledby="addImageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('product.image.store',$product->id) }}" method="POST" enctype="multipart/form-data"
                class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addImageModalLabel">Thêm ảnh cho sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="image" class="form-label">Chọn ảnh</label>
                        <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple required>
                    </div>
                </div>
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Thêm ảnh</button>
                </div>
            </form>
        </div>
    </div>
@endsection

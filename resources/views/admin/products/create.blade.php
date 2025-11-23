@extends('admin.layout.main')

@section('page-title', 'Thêm sản phẩm')
@section('main')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">Thêm sản phẩm mới</h2>
                <p class="text-muted mb-0">Tạo mới một sản phẩm với các biến thể</p>
            </div>
            <a href="{{ route('admin.product') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Danh sách</a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white"><h5 class="card-title mb-0">Thông tin sản phẩm</h5></div>
                    <div class="card-body">
                        @include('admin.products._form', ['product' => null, 'categories' => $categories])
                    </div>
                </div>

                <!-- Variants Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Biến thể sản phẩm</h5>
                        <button type="button" class="btn btn-sm btn-primary" id="addVariant">
                            <i class="bi bi-plus-circle"></i> Thêm biến thể
                        </button>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small">Thêm các biến thể khác nhau của sản phẩm (màu sắc, kích cỡ, giá...)</p>
                        <div id="variantsContainer">
                            <!-- Variants will be added here dynamically -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white"><h5 class="card-title mb-0">Hành động</h5></div>
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="bi bi-save"></i> Lưu sản phẩm
                        </button>
                        <a href="{{ route('admin.product') }}" class="btn btn-outline-secondary w-100">Hủy</a>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white"><h5 class="card-title mb-0">Hình ảnh sản phẩm</h5></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="image" class="form-label">Ảnh chính</label>
                            <input type="file" id="image" name="image" class="form-control" accept="image/*" onchange="previewImage(this, 'mainPreview')">
                            <div class="mt-2">
                                <img id="mainPreview" src="" alt="Preview" class="img-thumbnail" style="display: none; max-width: 100%; max-height: 200px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
let variantIndex = 0;

document.getElementById('addVariant').addEventListener('click', function() {
    const container = document.getElementById('variantsContainer');
    const variantHtml = `
        <div class="variant-item border rounded p-3 mb-3" data-index="${variantIndex}">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Biến thể #${variantIndex + 1}</h6>
                <button type="button" class="btn btn-sm btn-danger removeVariant">
                    <i class="bi bi-trash"></i> Xóa
                </button>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Màu sắc</label>
                    <input type="text" name="variants[${variantIndex}][color]" class="form-control" placeholder="VD: Đỏ, Xanh...">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kích cỡ</label>
                    <input type="text" name="variants[${variantIndex}][size]" class="form-control" placeholder="VD: 40, 41, 42...">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Giá (VNĐ)</label>
                    <input type="number" name="variants[${variantIndex}][price]" class="form-control" placeholder="0" min="0">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Trạng thái</label>
                    <select name="variants[${variantIndex}][status]" class="form-select">
                        <option value="active">Hoạt động</option>
                        <option value="inactive">Không hoạt động</option>
                        <option value="out_of_stock">Hết hàng</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Thiết kế</label>
                    <input type="text" name="variants[${variantIndex}][design]" class="form-control" placeholder="VD: Cổ cao, Cổ thấp...">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ảnh biến thể</label>
                    <input type="file" name="variants[${variantIndex}][image]" class="form-control" accept="image/*" onchange="previewImage(this, 'variantPreview${variantIndex}')">
                    <div class="mt-2">
                        <img id="variantPreview${variantIndex}" src="" alt="Preview" class="img-thumbnail" style="display: none; max-width: 100%; max-height: 150px;">
                    </div>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', variantHtml);
    variantIndex++;
});

document.addEventListener('click', function(e) {
    if (e.target.closest('.removeVariant')) {
        e.target.closest('.variant-item').remove();
    }
});

function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}
</script>
@endsection


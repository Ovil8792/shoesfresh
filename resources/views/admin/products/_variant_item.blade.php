<div class="variant-item border rounded p-3 mb-3" data-index="{{ $index }}">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0">Biến thể #{{ $index + 1 }}</h6>
        <button type="button" class="btn btn-sm btn-danger removeVariant">
            <i class="bi bi-trash"></i> Xóa
        </button>
    </div>
    <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Màu sắc</label>
            <input type="text" name="variants[{{ $index }}][color]" class="form-control" value="{{ $variant->color }}" placeholder="VD: Đỏ, Xanh...">
        </div>
        <div class="col-md-6">
            <label class="form-label">Kích cỡ</label>
            <input type="text" name="variants[{{ $index }}][size]" class="form-control" value="{{ $variant->size }}" placeholder="VD: 40, 41, 42...">
        </div>
        <div class="col-md-6">
            <label class="form-label">Giá (VNĐ)</label>
            <input type="number" name="variants[{{ $index }}][price]" class="form-control" value="{{ $variant->price }}" placeholder="0" min="0">
        </div>
        <div class="col-md-6">
            <label class="form-label">Trạng thái</label>
            <select name="variants[{{ $index }}][status]" class="form-select">
                <option value="active" {{ $variant->status == 'active' ? 'selected' : '' }}>Hoạt động</option>
                <option value="inactive" {{ $variant->status == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                <option value="out_of_stock" {{ $variant->status == 'out_of_stock' ? 'selected' : '' }}>Hết hàng</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Thiết kế</label>
            <input type="text" name="variants[{{ $index }}][design]" class="form-control" value="{{ $variant->design }}" placeholder="VD: Cổ cao, Cổ thấp...">
        </div>
        <div class="col-md-6">
            <label class="form-label">Ảnh biến thể</label>
            @if($variant->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $variant->image) }}" alt="Variant image" class="img-thumbnail" style="max-width: 100%; max-height: 150px;">
                </div>
            @endif
            <input type="file" name="variants[{{ $index }}][image]" class="form-control" accept="image/*" onchange="previewImage(this, 'variantPreview{{ $index }}')">
            <div class="mt-2">
                <img id="variantPreview{{ $index }}" src="" alt="Preview" class="img-thumbnail" style="display: none; max-width: 100%; max-height: 150px;">
            </div>
        </div>
    </div>
</div>


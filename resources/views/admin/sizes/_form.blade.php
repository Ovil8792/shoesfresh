<div class="mb-3">
    <label for="value" class="form-label">Kích cỡ</label>
    <input type="text" id="value" name="value" value="{{ old('value', $size->value ?? '') }}" class="form-control" placeholder="VD: 41, 42..." required>
</div>
<div class="mb-3">
    <label for="description" class="form-label">Mô tả</label>
    <input type="text" id="description" name="description" value="{{ old('description', $size->description ?? '') }}" class="form-control" placeholder="Mô tả ngắn">
</div>
<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Lưu</button>
    <a href="{{ route('admin.size') }}" class="btn btn-outline-secondary">Hủy</a>
</div>



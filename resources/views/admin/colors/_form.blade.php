<div class="mb-3">
    <label for="name" class="form-label">Tên màu</label>
    <input type="text" id="name" name="name" value="{{ old('name', $color->name ?? '') }}" class="form-control" placeholder="Nhập tên màu" required>
</div>
<div class="mb-3">
    <label for="hex" class="form-label">Mã màu (HEX)</label>
    <input type="text" id="hex" name="hex" value="{{ old('hex', $color->hex ?? '') }}" class="form-control" placeholder="#ffffff" required>
</div>
<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Lưu</button>
    <a href="{{ route('admin.color') }}" class="btn btn-outline-secondary">Hủy</a>
</div>



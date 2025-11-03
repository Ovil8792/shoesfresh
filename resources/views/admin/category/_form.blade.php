<div class="mb-3">
    <label for="name" class="form-label">Tên danh mục</label>
    <input type="text" id="name" name="name" value="{{ old('name', $category->name ?? '') }}" class="form-control" placeholder="Nhập tên danh mục" required>
</div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Lưu
    </button>
    <a href="{{ route('admin.category') }}" class="btn btn-outline-secondary">Hủy</a>
</div>

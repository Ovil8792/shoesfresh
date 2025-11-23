@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-3">
    <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
    <input type="text" id="name" name="name" value="{{ old('name', $product->name ?? '') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Nhập tên sản phẩm" required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="product_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
        <select id="product_id" name="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
            <option value="">-- Chọn danh mục --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('product_id', $product->product_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('product_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="price" class="form-label">Giá (VNĐ) <span class="text-danger">*</span></label>
        <input type="number" id="price" name="price" value="{{ old('price', $product->price ?? '') }}" class="form-control @error('price') is-invalid @enderror" placeholder="0" min="0" required>
        @error('price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="brand" class="form-label">Thương hiệu</label>
        <input type="text" id="brand" name="brand" value="{{ old('brand', $product->brand ?? '') }}" class="form-control" placeholder="VD: Nike, Adidas...">
    </div>

    <div class="col-md-6 mb-3">
        <label for="status" class="form-label">Trạng thái</label>
        <select id="status" name="status" class="form-select">
            <option value="active" {{ old('status', $product->status ?? 'active') == 'active' ? 'selected' : '' }}>Hoạt động</option>
            <option value="inactive" {{ old('status', $product->status ?? '') == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
            <option value="out_of_stock" {{ old('status', $product->status ?? '') == 'out_of_stock' ? 'selected' : '' }}>Hết hàng</option>
        </select>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="color" class="form-label">Màu sắc</label>
        <input type="text" id="color" name="color" value="{{ old('color', $product->color ?? '') }}" class="form-control" placeholder="VD: Đỏ, Xanh, Đen...">
    </div>

    <div class="col-md-6 mb-3">
        <label for="size" class="form-label">Kích cỡ</label>
        <input type="text" id="size" name="size" value="{{ old('size', $product->size ?? '') }}" class="form-control" placeholder="VD: 40, 41, 42...">
    </div>
</div>

<div class="mb-3">
    <label for="design" class="form-label">Thiết kế</label>
    <input type="text" id="design" name="design" value="{{ old('design', $product->design ?? '') }}" class="form-control" placeholder="VD: Cổ cao, Cổ thấp, Thể thao...">
</div>

<div class="mb-3">
    <label for="description" class="form-label">Mô tả</label>
    <textarea id="description" name="description" class="form-control" rows="4" placeholder="Nhập mô tả sản phẩm...">{{ old('description', $product->description ?? '') }}</textarea>
</div>


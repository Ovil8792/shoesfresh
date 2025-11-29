@extends('admin.layout.master')
@section('main')
    <div class="page-heading mb-3">
        <h3>Cập nhật sản phẩm</h3>
    </div>

    <div class="card">
        <div class="card-header">
            <strong>Thông tin sản phẩm</strong>
        </div>
        <div class="card-body">
            <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Hàng 1: Tên + Danh mục + Thương hiệu --}}
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="name" class="form-label">Tên sản phẩm</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name', $product->name) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="category_id" class="form-label">Danh mục</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="brand_id" class="form-label">Thương hiệu</label>
                        <select class="form-select" id="brand_id" name="brand_id" required>
                            <option value="">-- Chọn thương hiệu --</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Hàng 2: Slug + Giá + Trạng thái --}}
                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <label for="price" class="form-label">Giá</label>
                        <input type="number" class="form-control" id="price" name="price"
                            value="{{ old('price', $product->price) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="image" class="form-label">Ảnh sản phẩm</label>
                    <input type="file" class="form-control" id="image" name="image">
                    @if ($product->thumbnail)
                        <div class="mt-2">
                            <img src="{{ asset($product->thumbnail) }}" alt="Ảnh hiện tại" style="max-width: 120px;">
                        </div>
                    @endif
                    </div>
                    <div class="col-md-4">
                        <label for="status" class="form-label">Trạng thái</label>
                        <select class="form-select" id="status" name="status">
                            <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Hiển thị</option>
                            <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Ẩn</option>
                        </select>
                    </div>
                </div>

                {{-- Mô tả --}}
                <div class="mt-3">
                    <label for="description" class="form-label">Mô tả</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                </div>

                {{-- Biến thể sản phẩm --}}
                <div class="mt-4">
                    <label class="form-label">Biến thể sản phẩm</label>
                    <table class="table table-bordered align-middle" id="variant-table">
                        <thead class="table-light">
                            <tr>
                                <th>Kích cỡ</th>
                                <th>Màu sắc</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($product->variants as $i => $variant)
                                <tr>
                                    <td>
                                        <select name="variants[{{ $i }}][size_id]" class="form-select" required>
                                            <option value="">-- Chọn kích cỡ --</option>
                                            @foreach ($sizes as $size)
                                                <option value="{{ $size->id }}"
                                                    {{ $variant->size_id == $size->id ? 'selected' : '' }}>
                                                    {{ $size->value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="variants[{{ $i }}][color_id]" class="form-select"
                                            required>
                                            <option value="">-- Chọn màu sắc --</option>
                                            @foreach ($colors as $color)
                                                <option value="{{ $color->id }}"
                                                    {{ $variant->color_id == $color->id ? 'selected' : '' }}>
                                                    {{ $color->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="variants[{{ $i }}][price]"
                                            class="form-control" value="{{ $variant->price }}" required>
                                    </td>
                                    <td>
                                        <input type="number" name="variants[{{ $i }}][stock]"
                                            class="form-control" value="{{ $variant->stock }}" required>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-variant">Xóa</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>
                                        <select name="variants[0][size_id]" class="form-select" required>
                                            <option value="">-- Chọn kích cỡ --</option>
                                            @foreach ($sizes as $size)
                                                <option value="{{ $size->id }}">{{ $size->value }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="variants[0][color_id]" class="form-select" required>
                                            <option value="">-- Chọn màu sắc --</option>
                                            @foreach ($colors as $color)
                                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="variants[0][price]" class="form-control" required>
                                    </td>
                                    <td>
                                        <input type="number" name="variants[0][stock]" class="form-control" required>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-variant">Xóa</button>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-success btn-sm" id="add-variant">+ Thêm biến thể</button>
                </div>

                {{-- Nút hành động --}}
                <div class="text-end mt-4">
                    <a href="{{ route('product.index') }}" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
                </div>
            </form>
        </div>
    </div>


    {{-- Script thêm/xóa dòng biến thể --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let variantTable = document.getElementById('variant-table').getElementsByTagName('tbody')[0];
            let addBtn = document.getElementById('add-variant');
            let variantIndex = {{ $product->variants->count() > 0 ? $product->variants->count() : 1 }};

            addBtn.addEventListener('click', function() {
                let row = document.createElement('tr');
                row.innerHTML = `
                    <td>
                        <select name="variants[${variantIndex}][size_id]" class="form-select" required>
                            <option value="">-- Chọn kích cỡ --</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->value }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="variants[${variantIndex}][color_id]" class="form-select" required>
                            <option value="">-- Chọn màu sắc --</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="variants[${variantIndex}][price]" class="form-control" required>
                    </td>
                    <td>
                        <input type="number" name="variants[${variantIndex}][stock]" class="form-control" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-variant">Xóa</button>
                    </td>
                `;
                variantTable.appendChild(row);
                variantIndex++;
            });

            variantTable.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('remove-variant')) {
                    let row = e.target.closest('tr');
                    if (variantTable.rows.length > 1) {
                        row.remove();
                    }
                }
            });
        });
    </script>
@endsection

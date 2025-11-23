@extends('admin.layout.main')

@section('page-title', 'Xóa sản phẩm')
@section('main')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0">Xác nhận xóa sản phẩm</h2>
            <p class="text-muted mb-0">Bạn có chắc chắn muốn xóa sản phẩm này?</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @php
                $product = \App\Models\Product::findOrFail($id);
            @endphp
            
            <div class="row">
                <div class="col-md-8">
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
                    </table>
                </div>
                <div class="col-md-4 text-center">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded mb-3">
                    @endif
                </div>
            </div>

            <form method="POST" action="{{ route('admin.product.delete.confirm', $id) }}" class="mt-4">
                @csrf
                @method('DELETE')
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Xác nhận xóa
                    </button>
                    <a href="{{ route('admin.product') }}" class="btn btn-outline-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


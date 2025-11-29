@extends('admin.layout.master')
@section('main')
    <div class="container">
        <h4>Danh sách màu sắc</h4>
        <!-- Nút mở modal -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addColorModal">
            Thêm màu sắc
        </button>
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center"
            style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; max-width: 250px;"
            role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên màu</th>
                    <th>Mã màu</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($colors as $color)
                    <tr>
                        <td>{{ $color->id }}</td>
                        <td>{{ $color->name }}</td>
                        <td>
                            <span
                                style="display:inline-block;width:30px;height:20px;background:{{ $color->hex_code }};border:1px solid #ccc;"></span>
                            {{ $color->hex_code }}
                        </td>
                        <td>
                            <a href="{{ route('product.color.delete', $color->id) }}"
                                onclick="return confirm('Bạn có chắc muốn xoá không?')"
                                class="btn btn-sm btn-danger">
                                Xóa
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- {{ $colors->links() }} --}}

        <!-- Modal thêm màu sắc -->
        <div class="modal fade" id="addColorModal" tabindex="-1" aria-labelledby="addColorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('product.color.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addColorModalLabel">Thêm màu sắc</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="colorName" class="form-label">Tên màu</label>
                                <input type="text" name="name" class="form-control" id="colorName" required>
                            </div>
                            <div class="mb-3">
                                <label for="colorHex" class="form-label">Mã màu (hex)</label>
                                <input type="color" name="hex_code" class="form-control form-control-color" id="colorHex"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-success">Lưu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
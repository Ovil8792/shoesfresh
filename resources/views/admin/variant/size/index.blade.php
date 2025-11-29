{{-- filepath: c:\wamp64\www\du-an-tot-nghiep\HPsneaker\resources\views\admin\variant\size\index.blade.php --}}
@extends('admin.layout.master')
@section('main')
    <div class="container">
        <h4>Danh sách kích cỡ</h4>
        <!-- Nút mở modal -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addSizeModal">
            Thêm kích cỡ
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
                    <th>Kích cỡ</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sizes as $size)
                    <tr>
                        <td>{{ $size->id }}</td>
                        <td>{{ $size->value }}</td>
                        <td>
                            <a href="{{ route('product.size.delete', $size->id) }}"
                                onclick="return confirm('Bạn có chắc muốn xoá không?')"
                                class="btn btn-sm btn-danger">
                                Xóa
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- {{ $sizes->links() }} --}}

        <!-- Modal thêm kích cỡ -->
        <div class="modal fade" id="addSizeModal" tabindex="-1" aria-labelledby="addSizeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('product.size.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addSizeModalLabel">Thêm kích cỡ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="sizeLabel" class="form-label">Kích cỡ</label>
                                <input type="text" name="value" class="form-control" id="sizeLabel" required>
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
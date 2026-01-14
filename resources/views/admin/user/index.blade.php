@extends('admin.layout.master')
@section('main')
    {{-- Thông báo thành công --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center"
            style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; max-width: 250px;"
            role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    @endif
    {{-- Thông báo lỗi --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show text-center"
            style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; max-width: 300px;"
            role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    @endif
    {{-- end Thông báo --}}

    <div class="page-heading">
        <h3>Danh sách tài khoản người dùng</h3>
    </div>
    <!-- Bảng Danh sách tài khoản người dùng -->
    <section class="section">
        <div class="row" id="table-head">
            <div class="col-12">
                <div class="card-content">
                    {{-- Nút thêm --}}
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        <a href="" class="btn btn-primary mb-2 mb-md-0" data-bs-toggle="modal"
                            data-bs-target="#addUserModal">
                            + Thêm tài khoản
                        </a>
                        {{-- Nút tìm kiếm --}}
                        <form action="{{ route('user.index') }}" method="GET" class="d-flex w-auto"
                            style="max-width: 400px;">
                            <input type="text" name="keyword" class="form-control form-control-sm me-2"
                                placeholder="Tìm theo tên..." value="{{ request('keyword') }}">
                            <select name="role_id" class="form-select form-select-sm me-2" style="width:120px;">
                                <option value="">Tất cả</option>
                                <option value="1" {{ request('role_id') == 1 ? 'selected' : '' }}>Admin</option>
                                <option value="2" {{ request('role_id') == 2 ? 'selected' : '' }}>Staff</option>
                                <option value="3" {{ request('role_id') == 3 ? 'selected' : '' }}>Customer</option>
                            </select>
                            <button type="submit" class="btn btn-outline-primary btn-sm">Tìm kiếm</button>
                        </form>

                    </div>

                    <div class="table-responsive">
                        {{-- Bảng tài khoản --}}
                        <table class="table table-striped table-bordered align-middle">
                            <thead class="table-white">
                                <tr>
                                    <th>ID</th>
                                    <th>Tài khoản </th>
                                    <th>Email </th>
                                    <th>Quyền </th>
                                    <th>Ngày tạo</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @switch($user->role_id)
                                                @case(1)
                                                    Quản trị viên
                                                @break

                                                @case(2)
                                                    Khách hàng
                                                @break

                                                @case(3)
                                                    Nhân viên
                                                @break

                                                @case(4)
                                                    Nhân viên giao hàng
                                                @break

                                                @default
                                                    Chưa phân quyền
                                            @endswitch
                                        </td>

                                        <td>{{ $user->created_at ? $user->created_at->format('d/m/Y') : '' }}</td>
                                        <td class="text-center">
                                            <div class="d-flex flex-wrap gap-1 justify-content-center">
                                                <a href="{{ route('user.show', $user->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    Xem
                                                </a>
                                                <a href="{{ route('user.edit', $user->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    Sửa
                                                </a>
                                                @if($user->role_id != 1)
                                                    <a href="{{ route('user.delete', $user->id) }}"
                                                        onclick="return confirm('Bạn có chắc muốn xoá không?')"
                                                        class="btn btn-sm btn-danger">
                                                        Xóa
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $users->appends(request()->query())->links() }}</div>
                </div>
            </div>
        </div>
        </div>
    </section>
    {{-- End Danh mục sản phẩm --}}
    @include('admin.user.create')
@endsection

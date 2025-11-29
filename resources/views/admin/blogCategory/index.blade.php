{{-- filepath: c:\wamp64\www\du-an-tot-nghiep\HPsneaker\resources\views\admin\blogCategory\index.blade.php --}}
@extends('admin.layout.master')
@section('main')
    {{-- Thông báo thành công --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center"
            style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; max-width: 250px;"
            role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    @endif
    {{-- end Thông báo thành công --}}

    <div class="page-heading">
        <h3>Danh mục bài viết</h3>
    </div>
    <!-- Bảng Danh mục bài viết -->
    <section class="section">
        <div class="row" id="table-head">
            <div class="col-12">
                <div class="card-content">
                    {{-- Nút thêm --}}
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        <a href="#" class="btn btn-primary mb-2 mb-md-0" data-bs-toggle="modal"
                            data-bs-target="#addBlogCategoryModal">
                            + Thêm danh mục bài viết
                        </a>
                        {{-- Nút tìm kiếm --}}
                        <form action="{{ route('blog_category.index') }}" method="GET" class="d-flex w-auto"
                            style="max-width: 200px;">
                            <input type="text" name="keyword" class="form-control form-control-sm me-2"
                                placeholder="Tìm theo tên..." value="{{ request('keyword') }}">
                            <button type="submit" class="btn btn-outline-primary btn-sm">Tìm kiếm</button>
                        </form>
                    </div>

                    <div class="table-responsive">
                        {{-- Bảng danh mục bài viết --}}
                        <table class="table table-striped table-bordered align-middle">
                            <thead class="table-white">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên danh mục</th>
                                    <th>Slug</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Ngày cập nhật</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($blogCategories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->slug }}</td>
                                        <td>
                                            @if($category->status == 1)
                                                <span class="badge bg-success rounded-pill px-3 py-2">Hiển thị</span>
                                            @else
                                                <span class="badge bg-danger rounded-pill px-3 py-2">Ẩn</span>
                                            @endif
                                        </td>
                                        <td>{{ $category->created_at }}</td>
                                        <td>{{ $category->updated_at }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('blog_category.edit', $category->id) }}"
                                                class="btn btn-sm btn-warning rounded-pill px-3 py-1 d-inline-flex align-items-center me-1">
                                                <i class="bi bi-pencil-square me-1"></i> Sửa
                                            </a>
                                            <a href="{{ route('blog_category.delete', $category->id) }}"
                                                onclick="return confirm('Bạn có chắc muốn xoá không?')"
                                                class="btn btn-sm btn-danger rounded-pill px-3 py-1 d-inline-flex align-items-center">
                                                <i class="bi bi-trash me-1"></i> Xóa
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="mt-3">{{ $categories->appends(request()->query())->links() }}</div> --}}
                </div>
            </div>
        </div>
    </section>
    {{-- End Danh mục bài viết --}}

    @include('admin.blogCategory.create')

    {{-- Modal Thêm Danh Mục Bài Viết --}}
@endsection
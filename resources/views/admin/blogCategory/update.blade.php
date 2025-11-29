{{-- filepath: c:\wamp64\www\du-an-tot-nghiep\HPsneaker\resources\views\admin\blogCategory\update.blade.php --}}
@extends('admin.layout.master')
@section('main')
<div class="row justify-content-center mt-4">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header text-center bg-primary">
                <h4 class="mb-0 text-white">Sửa danh mục bài viết</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('blog_category.update', $blogCategory->id) }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="mb-3">
                        <label class="form-label">Tên danh mục bài viết</label>
                        <input type="text" class="form-control" name="name" value="{{ $blogCategory->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" class="form-control" name="slug" value="{{ $blogCategory->slug }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select class="form-select" name="status">
                            <option value="1" @if($blogCategory->status == 1) selected @endif>Hiển thị</option>
                            <option value="0" @if($blogCategory->status == 0) selected @endif>Ẩn</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('blog_category.index') }}" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
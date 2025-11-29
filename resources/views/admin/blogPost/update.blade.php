@extends('admin.layout.master')
@section('main')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>Sửa bài viết</h3>
        </div>
        <form action="{{ route('blog_post.update', $blogPost->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label for="title" class="form-label">Tiêu đề</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $blogPost->title) }}" required>
                </div>
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $blogPost->slug) }}">
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Nội dung</label>
                    <textarea class="form-control" id="content" name="content" rows="5" required>{{ old('content', $blogPost->content) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="thumbnail" class="form-label">Ảnh đại diện</label>
                    @if($blogPost->thumbnail)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $blogPost->thumbnail) }}" alt="Thumbnail" style="max-height:120px;">
                        </div>
                    @endif
                    <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                </div>
                <div class="mb-3">
                    <label for="blog_category_id" class="form-label">Danh mục</label>
                    <select class="form-select" id="blog_category_id" name="blog_category_id" required>
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($BlogCategory as $category)
                            <option value="{{ $category->id }}" {{ old('blog_category_id', $blogPost->blog_category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select class="form-select" id="status" name="status">
                        <option value="1" {{ old('status', $blogPost->status) == 1 ? 'selected' : '' }}>Hiển thị</option>
                        <option value="0" {{ old('status', $blogPost->status) == 0 ? 'selected' : '' }}>Ẩn</option>
                    </select>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('blog_post.index') }}" class="btn btn-secondary">Quay lại</a>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('admin.layout.master')
@section('main')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>{{ $blogPost->title }}</h3>
            <span class="badge bg-secondary">{{ $blogPost->blogCategory->name ?? '-' }}</span>
        </div>
        <div class="card-body">
            @if($blogPost->thumbnail)
                <img src="{{ asset('storage/' . $blogPost->thumbnail) }}" alt="Thumbnail" class="img-fluid mb-3" style="max-height:300px;">
            @endif
            <div class="mb-2">
                <strong>Slug:</strong> {{ $blogPost->slug }}
            </div>
            <div class="mb-2">
                <strong>Trạng thái:</strong>
                @if($blogPost->status == 1)
                    <span class="badge bg-success">Hiển thị</span>
                @else
                    <span class="badge bg-danger">Ẩn</span>
                @endif
            </div>
            <div class="mb-2">
                <strong>Ngày đăng:</strong> {{ $blogPost->published_at ? \Carbon\Carbon::parse($blogPost->published_at)->format('d/m/Y H:i') : '-' }}
            </div>
            <div class="mb-2">
                <strong>Ngày sửa:</strong> {{ $blogPost->updated_at ? \Carbon\Carbon::parse($blogPost->updated_at)->format('d/m/Y H:i') : '-' }}
            </div>
            <hr>
            <div>
                {!! nl2br(e($blogPost->content)) !!}
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('blog_post.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
            <a href="{{ route('blog_post.edit', $blogPost->id) }}" class="btn btn-warning">Sửa</a>
        </div>
    </div>
</div>
@endsection

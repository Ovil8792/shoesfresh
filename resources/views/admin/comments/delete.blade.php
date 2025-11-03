@extends('admin.layout.main')

@section('page-title', 'Xóa bình luận')
@section('main')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0 text-danger">Xóa bình luận</h2>
            <p class="text-muted mb-0">Hành động này không thể hoàn tác.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <p>Bạn có chắc chắn muốn xóa bình luận <strong>ID: {{ $comment->id ?? $id ?? '' }}</strong>?</p>
            @if(isset($comment) && $comment->content)
            <div class="alert alert-info">
                <strong>Nội dung:</strong> {{ mb_substr($comment->content, 0, 100) }}{{ strlen($comment->content) > 100 ? '...' : '' }}
            </div>
            @endif
            <div class="d-flex gap-2">
                @isset($comment)
                <a href="{{ route('admin.comment.delete', ['id' => $comment->id]) }}" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Xóa ngay
                </a>
                @else
                <a href="{{ route('admin.comment.delete', ['id' => $id]) }}" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Xóa ngay
                </a>
                @endisset
                <a href="{{ route('admin.comment') }}" class="btn btn-outline-secondary">Hủy</a>
            </div>
        </div>
    </div>
</div>
@endsection


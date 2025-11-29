
@extends('admin.layout.master')
@section('main')
<div class="page-heading mb-4">
    <h3 class="fw-bold">Chi tiết bình luận</h3>
</div>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-lg border-0">
            <div class="row g-0">

                <div class="col-md-7">
                    <div class="card-body p-4">
                        <h2 class="fw-bold mb-2 text-primary">{{ $comment->name }}</h2>

                        <div class="mb-2">
                            <span class="text-muted">Trạng thái:</span>
                            @if($comment->status == 1)
                                <span class="badge bg-success">Đã duyệt</span>
                            @else
                                <span class="badge bg-danger rounded-pill px-3 py-2">Không hợp lệ</span>
                            @endif
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">Ngày bình luận:</span> {{ $comment->created_at ? $comment->created_at->format('d/m/Y') : '' }}
                        </div>
                        <div class="mb-3">
                            <strong class="text-muted">Bình luận:</strong>
                            <div class="border rounded p-3 bg-light mt-1" style="min-height: 80px; font-size: 1.05rem;">
                                {!! nl2br(e($comment->cmt)) !!}
                            </div>
                        </div>
                        <div class="text-end mt-4">
                            <a href="{{ route('comment.index') }}" class="btn btn-outline-secondary px-4">Quay lại</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

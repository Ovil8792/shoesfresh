@extends('admin.layout.main')

@section('page-title', 'Chi tiết bình luận')
@section('main')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Chi tiết bình luận</h2>
                    <p class="text-muted mb-0">Xem thông tin chi tiết bình luận</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.comment') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Danh sách
                    </a>
                    @isset($comment)
                    <a href="{{ route('admin.comment.edit', ['id' => $comment->id]) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Sửa
                    </a>
                    <a href="{{ route('admin.comment.delete', ['id' => $comment->id]) }}" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa không?')">
                        <i class="bi bi-trash"></i> Xóa
                    </a>
                    @endisset
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 text-muted">ID</div>
                <div class="col-md-9">{{ $comment->id ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Người bình luận</div>
                <div class="col-md-9">{{ $comment->user->name ?? 'Người dùng mẫu' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Sản phẩm</div>
                <div class="col-md-9">{{ $comment->product->name ?? 'Sản phẩm mẫu' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Nội dung</div>
                <div class="col-md-9">{{ $comment->content ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Đánh giá</div>
                <div class="col-md-9">
                    @if(isset($comment) && $comment->rating)
                        <div class="text-warning">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $comment->rating)
                                    <i class="bi bi-star-fill"></i>
                                @else
                                    <i class="bi bi-star"></i>
                                @endif
                            @endfor
                            <span class="text-dark ms-1">{{ $comment->rating }}/5</span>
                        </div>
                    @else
                        -
                    @endif
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Trạng thái</div>
                <div class="col-md-9">
                    @if(isset($comment) && $comment->status)
                        @php
                            $statusBadges = [
                                'pending' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger'
                            ];
                            $badge = $statusBadges[$comment->status] ?? 'secondary';
                            $statusText = [
                                'pending' => 'Chờ duyệt',
                                'approved' => 'Đã duyệt',
                                'rejected' => 'Từ chối'
                            ];
                        @endphp
                        <span class="badge bg-{{ $badge }}">{{ $statusText[$comment->status] ?? ucfirst($comment->status) }}</span>
                    @else
                        -
                    @endif
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Ngày tạo</div>
                <div class="col-md-9">{{ $comment->created_at ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 text-muted">Cập nhật lần cuối</div>
                <div class="col-md-9">{{ $comment->updated_at ?? '-' }}</div>
            </div>
        </div>
    </div>
</div>
@endsection


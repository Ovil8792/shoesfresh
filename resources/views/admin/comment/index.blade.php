@extends('admin.layout.master')
@section('main')
<div class="page-heading">
        <h3>Bình luận</h3>
    </div>
    <section class="section">
        <div class="row" id="table-head">
            <div class="col-12">
                <div class="card-content">
                    {{-- Nút thêm --}}
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        {{-- Nút tìm kiếm --}}
                        <form action="{{ route('comment.index') }}" method="GET" class="d-flex w-auto"
                            style="max-width: 200px;">
                            <input type="text" name="keyword" class="form-control form-control-sm me-2"
                                placeholder="Tìm theo tên..." value="{{ request('keyword') }}">
                            <button type="submit" class="btn btn-outline-primary btn-sm">Tìm kiếm</button>
                        </form>

                    </div>

                    <div class="table-responsive">
                        {{-- Bảng bình luận --}}
                        <table class="table table-striped table-bordered align-middle">
                            <thead class="table-white">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Bình luận</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($comments as $comment)
                                    <tr>
                                        <td>{{ $comment->id }}</td>
                                        <td>{{ $comment->name }}</td>
                                        <td>{{ $comment->email }}</td>
                                        <td>{{ $comment->cmt }}</td>
                                        <td>
                                            @if($comment->status == 1)
                                                <span class="badge bg-success rounded-pill px-3 py-2">Duyệt</span>
                                            @else
                                                <span class="badge bg-danger rounded-pill px-3 py-2">Không hợp lệ</span>
                                            @endif
                                        </td>
                                        <td>{{ $comment->created_at }}</td>
                                        <td>
                                            <a href="{{ route('comment.delete', $comment->id) }}"
                                                onclick="return confirm('Bạn có chắc muốn xoá không?')"
                                                class="btn btn-sm btn-danger rounded-pill px-3 py-1 d-inline-flex align-items-center">
                                                <i class="bi bi-trash me-1"></i> Xóa
                                            </a>
                                            <a href="{{ route('comment.show', $comment->id) }}"
                                                class="btn btn-sm btn-info rounded-pill px-3 py-1 d-inline-flex align-items-center me-1">
                                                <i class="bi bi-eye me-1"></i> Chi tiết
                                            </a>
                                            <a href="{{ route('comment.edit', $comment->id) }}"
                                                class="btn btn-sm btn-warning rounded-pill px-3 py-1 d-inline-flex align-items-center me-1">
                                                <i class="bi bi-pencil-square me-1"></i> Sửa
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    {{-- cái này  --}}
@endsection

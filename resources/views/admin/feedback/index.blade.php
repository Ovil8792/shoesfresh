@extends('admin.layout.master')
@section('main')
<div class="page-heading">
        <h3>Phản hồi</h3>
    </div>
    <section class="section">
        <div class="row" id="table-head">
            <div class="col-12">
                <div class="card-content">
                    {{-- Nút thêm --}}
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        {{-- Nút tìm kiếm --}}
                        <form action="{{ route('feedback.index') }}" method="GET" class="d-flex w-auto"
                            style="max-width: 200px;">
                            <input type="text" name="keyword" class="form-control form-control-sm me-2"
                                placeholder="Tìm theo tên..." value="{{ request('keyword') }}">
                            <button type="submit" class="btn btn-outline-primary btn-sm">Tìm kiếm</button>
                        </form>

                    </div>

                    <div class="table-responsive">
                        {{-- Bảng liên hệ --}}
                        <table class="table table-striped table-bordered align-middle">
                            <thead class="table-white">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên</th>
                                    <th>Nội dung</th>
                                    <th>Trạng thái</th>
                                    <th>Hình ảnh</th>
                                    <th>Ngày gửi</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($feedbacks as $feedback)
                                    <tr>
                                        <td>{{ $feedback->id }}</td>
                                        <td>{{ $feedback->name }}</td>
                                        <td>{{ $feedback->mess }}</td>
                                        <td>
                                            @if($feedback->status == 1)
                                                <span class="badge bg-success rounded-pill px-3 py-2">Hiển thị</span>
                                            @else
                                                <span class="badge bg-danger rounded-pill px-3 py-2">Chặn</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($feedback->img)
                                                @php
                                                    $ext = strtolower(pathinfo($feedback->img, PATHINFO_EXTENSION));
                                                @endphp

                                                @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                    <img src="{{ asset('storage/' . $feedback->img) }}" alt="Ảnh" style="max-width: 100px;">
                                                @elseif (in_array($ext, ['mp4', 'mov', 'avi', 'webm']))
                                                    <video controls style="max-width: 150px; max-height: 100px;">
                                                        <source src="{{ asset('storage/' . $feedback->img) }}" type="video/{{ $ext }}">
                                                        Trình duyệt không hỗ trợ video.
                                                    </video>
                                                @else
                                                    <a href="{{ asset('storage/' . $feedback->img) }}" target="_blank">Xem file</a>
                                                @endif
                                            @else
                                                Không có file
                                            @endif
                                        </td>
                                        <td>{{ $feedback->created_at }}</td>
                                        <td>
                                            <a href="{{ route('feedback.delete', $feedback->id) }}"
                                                onclick="return confirm('Bạn có chắc muốn xoá không?')"
                                                class="btn btn-sm btn-danger rounded-pill px-3 py-1 d-inline-flex align-items-center">
                                                <i class="bi bi-trash me-1"></i> Xóa
                                            </a>
                                            <a href="{{ route('feedback.show', $feedback->id) }}"
                                                class="btn btn-sm btn-info rounded-pill px-3 py-1 d-inline-flex align-items-center me-1">
                                                <i class="bi bi-eye me-1"></i> Chi tiết
                                            </a>
                                            <a href="{{ route('feedback.edit', $feedback->id) }}"
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
    {{-- cái này --}}
@endsection

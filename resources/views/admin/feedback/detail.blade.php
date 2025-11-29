
@extends('admin.layout.master')
@section('main')
<div class="page-heading mb-4">
    <h3 class="fw-bold">Chi tiết phản hồi</h3>
</div>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-lg border-0">
            {{-- <div class="row g-0">
                <div class="mb-3 w-100 text-center">
                            @if($feedback->img)
                                <img src="{{ asset('storage/' . $feedback->img) }}" alt="Ảnh từ khách hàng" class="img-fluid rounded shadow"
                                style="max-height: 300px; object-fit: contain;">
                            @else
                                <div class="text-muted">Không có ảnh</div>
                            @endif
                </div> --}}
                <div class="col-md-7">
                    <div class="card-body p-4">
                        <h2 class="fw-bold mb-2 text-primary">{{ $feedback->name }}</h2>
                        <div class="mb-2">
                            <span class="text-muted">Ngày gửi:</span> {{ $feedback->created_at ? $feedback->created_at->format('d/m/Y') : '' }}
                        </div>
                        <div class="mb-3 w-100 text-center">
                            @if ($feedback->img)
                            @php
                                $ext = strtolower(pathinfo($feedback->img, PATHINFO_EXTENSION));
                            @endphp

                            @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                <img src="{{ asset('storage/' . $feedback->img) }}" alt="Ảnh từ khách hàng"
                                    class="img-fluid rounded shadow" style="max-height: 300px; object-fit: contain;">
                            @elseif (in_array($ext, ['mp4', 'webm', 'mov', 'avi']))
                                <video controls class="img-fluid rounded shadow" style="max-height: 300px; object-fit: contain;">
                                    <source src="{{ asset('storage/' . $feedback->img) }}" type="video/{{ $ext }}">
                                    Trình duyệt không hỗ trợ định dạng video này.
                                </video>
                            @else
                                <a href="{{ asset('storage/' . $feedback->img) }}" target="_blank" class="btn btn-outline-primary">
                                    Xem file đính kèm
                                </a>
                            @endif
                        @else
                            <div class="text-muted">Không có ảnh/video</div>
                        @endif
                </div>
                        <div class="mb-3">
                            <strong class="text-muted">Mô tả:</strong>
                            <div class="border rounded p-3 bg-light mt-1" style="min-height: 80px; font-size: 1.05rem;">
                                {!! nl2br(e($feedback->mess)) !!}
                            </div>
                        </div>
                        <div class="text-end mt-4">
                            <a href="{{ route('feedback.index') }}" class="btn btn-outline-secondary px-4">Quay lại</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

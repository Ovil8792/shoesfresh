
@extends('admin.layout.master')
@section('main')
<div class="page-heading mb-4">
    <h3 class="fw-bold">Chi tiết liên hệ</h3>
</div>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-lg border-0">
            <div class="row g-0">

                <div class="col-md-7">
                    <div class="card-body p-4">
                        <h2 class="fw-bold mb-2 text-primary">{{ $contact->name }}</h2>

                        <div class="mb-2">
                            <span class="text-muted">Trạng thái:</span>
                            @if($contact->status == 1)
                                <span class="badge bg-success">Đang xử lý</span>
                            @else
                                <span class="badge bg-secondary">Đã xử lý</span>
                            @endif
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">Ngày gửi:</span> {{ $contact->created_at ? $contact->created_at->format('d/m/Y') : '' }}
                        </div>
                        <div class="mb-3">
                            <strong class="text-muted">Mô tả:</strong>
                            <div class="border rounded p-3 bg-light mt-1" style="min-height: 80px; font-size: 1.05rem;">
                                {!! nl2br(e($contact->mess)) !!}
                            </div>
                        </div>
                        <div class="text-end mt-4">
                            <a href="{{ route('contact.index') }}" class="btn btn-outline-secondary px-4">Quay lại</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('admin.layout.master')
@section('main')

@php use Illuminate\Support\Str; @endphp

<div class="container mt-5">
    <h4>Kết quả tìm kiếm cho: "{{ $keyword }}"</h4>
    <div class="row mt-3">
        @forelse ($feedbacks as $feedback)
            <div class="col-md-3 mb-4">
                <div class="card">
                    <a href="{{ route('admin.feedback.detail', ['name' => Str::slug($feedback->name), 'id' => $feedback->id]) }}">
                        <img src="{{ asset('storage/' . $feedback->img) }}" class="card-img-top" alt="{{ $feedback->name }}">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('admin.feedback.detail', ['name' => Str::slug($feedback->name), 'id' => $feedback->id]) }}" class="text-decoration-none text-dark">
                                {{ $feedback->name }}
                            </a>
                        </h5>
                    </div>
                </div>
            </div>
        @empty
            <p>Không tìm thấy sản phẩm phù hợp.</p>
        @endforelse
    </div>
</div>
@endsection

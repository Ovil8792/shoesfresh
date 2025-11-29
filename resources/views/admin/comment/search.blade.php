@extends('admin.layout.master')
@section('main')

@php use Illuminate\Support\Str; @endphp

<div class="container mt-5">
    <h4>Kết quả tìm kiếm cho: "{{ $keyword }}"</h4>
    <div class="row mt-3">
        @forelse ($comments as $comment)
            <div class="col-md-3 mb-4">
                <div class="card">
                    <a href="{{ route('admin.comment.detail', ['name' => Str::slug($comment->name), 'id' => $comment->id]) }}">
                        <img src="{{ asset('storage/' . $comment->img) }}" class="card-img-top" alt="{{ $comment->name }}">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('admin.feedback.detail', ['name' => Str::slug($comment->name), 'id' => $comment->id]) }}" class="text-decoration-none text-dark">
                                {{ $comment->name }}
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

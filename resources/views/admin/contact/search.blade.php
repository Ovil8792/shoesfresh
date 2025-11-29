@extends('admin.layout.master')
@section('main')

@php use Illuminate\Support\Str; @endphp

<div class="container mt-5">
    <h4>Kết quả tìm kiếm cho: "{{ $keyword }}"</h4>
    <div class="row mt-3">
        @forelse ($contacts as $contact)
            <div class="col-md-3 mb-4">
                <div class="card">
                    <a href="{{ route('admin.contact.detail', ['name' => Str::slug($contact->name), 'id' => $contact->id]) }}">
                        <img src="{{ asset('storage/' . $contact->thumbnail) }}" class="card-img-top" alt="{{ $contact->name }}">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('admin.contact.detail', ['name' => Str::slug($contact->name), 'id' => $contact->id]) }}" class="text-decoration-none text-dark">
                                {{ $contact->name }}
                            </a>
                        </h5>
                        {{-- <p class="card-text">{{ number_format($contact->price, 0, ',', '.') }} đ</p> --}}
                    </div>
                </div>
            </div>
        @empty
            <p>Không tìm thấy sản phẩm phù hợp.</p>
        @endforelse
    </div>
</div>
@endsection

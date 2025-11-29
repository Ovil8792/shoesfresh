@extends('client.layout.master')
@section('main')

@php use Illuminate\Support\Str; @endphp

<div class="container mt-5">
    <h4>Kết quả tìm kiếm cho: "{{ $keyword }}"</h4>
    <div class="row mt-3">
        @forelse ($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card">
                    <a href="{{ route('shop.product.show', ['name' => Str::slug($product->name), 'id' => $product->id]) }}">
                        <img src="{{ asset($product->thumbnail) }}" class="card-img-top" alt="{{ $product->name }}">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('shop.product.show', ['name' => Str::slug($product->name), 'id' => $product->id]) }}" class="text-decoration-none text-dark">
                                {{ $product->name }}
                            </a>
                        </h5>
                        <p class="card-text">{{ number_format($product->price, 0, ',', '.') }} đ</p>
                    </div>
                </div>
            </div>
        @empty
            <p>Không tìm thấy sản phẩm phù hợp.</p>
        @endforelse
    </div>
</div>
@endsection

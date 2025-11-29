@extends('client.layout.master')

@section('main')
<div class="container py-4">
    <h2 class="mb-4">Sản phẩm đang giảm giá</h2>
    
    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                @php
                    $discount = $product->discounts->first();
                    $discountedPrice = $product->price * (1 - $discount->discount_percent / 100);
                @endphp
                <div class="col-md-3 col-6 mb-4">
                    <div class="card product-card h-100">
                        <div class="position-relative">
                            <a href="{{ route('shop.product.show', ['name' => \Illuminate\Support\Str::slug($product->name), 'id' => $product->id]) }}">
                                @php
                                    // Check if thumbnail exists in the public/uploads directory
                                    $thumbnailPath = 'uploads/products/' . basename($product->thumbnail);
                                    $imagePath = $product->thumbnail ? (str_starts_with($product->thumbnail, 'http') ? $product->thumbnail : asset($thumbnailPath)) : asset('assets/images/no-image.jpg');
                                @endphp
                                <img src="{{ $imagePath }}" 
                                     class="card-img-top" 
                                     alt="{{ $product->name }}"
                                     onerror="this.onerror=null; this.src='{{ asset('assets/images/no-image.jpg') }}'"
                                     style="height: 200px; width: 100%; object-fit: cover;">
                            </a>
                            @if($discount)
                                <div class="discount-badge">
                                    -{{ $discount->discount_percent }}%
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <h5 class="card-title product-title">
                                <a href="{{ route('shop.product.show', ['name' => \Illuminate\Support\Str::slug($product->name), 'id' => $product->id]) }}" class="text-dark">
                                    {{ $product->name }}
                                </a>
                            </h5>
                            <div class="d-flex align-items-center mb-2">
                                <span class="text-danger fw-bold me-2">{{ number_format($discountedPrice) }}đ</span>
                                <small class="text-muted text-decoration-line-through">{{ number_format($product->price) }}đ</small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-stopwatch"></i> 
                                    Còn {{ now()->diffInDays($discount->end_date) }} ngày
                                </span>
                                <button class="btn btn-sm btn-outline-primary" onclick="addToCart({{ $product->id }})">
                                    <i class="bi bi-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    @else
        <div class="alert alert-info">
            Hiện tại không có sản phẩm nào đang giảm giá.
        </div>
    @endif
</div>

<style>
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid #eee;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    .discount-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #dc3545;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-weight: bold;
        font-size: 0.9rem;
    }
    .product-title {
        font-size: 1rem;
        height: 3rem;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
</style>

@endsection

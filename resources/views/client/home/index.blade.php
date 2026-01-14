@extends('client.layout.master')
@section('main')

{{-- ===================== HERO SECTION ===================== --}}
<section class="hero py-4" style="background-color: #fff3e6;">
    <div class="container">
        <div class="row d-flex justify-content-center">
            {{-- Search + Phone --}}
            <div class="col-lg-9">
                <div class="hero__search d-flex gap-3 justify-content-center">
                    <div class="hero__search__form">
                        <form action="{{ route('product.search') }}" method="GET" class="d-flex bg-white rounded" style="box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
                            <input type="text" 
                                   placeholder="Tìm kiếm sản phẩm" 
                                   name="keyword" 
                                   class="form-control border-0 py-2 px-3"
                                   style="background: transparent; border-radius: 0 !important;">
                            <button type="submit" 
                                    class="btn px-4" 
                                    style="background-color: #FF6B35; color: white; border: none; border-radius: 0 !important;">
                                Tìm kiếm
                            </button>
                        </form>
                    </div>
        </div>
    </div>
</section>

{{-- ===================== BANNER ===================== --}}
<div class="container my-4">
    <img class="w-100 rounded" src="https://supersports.com.vn/cdn/shop/files/1545x500_V_4d59d442-0590-433b-8045-319e7b1c61a6.jpg?v=1761892009&width=1920" alt="" style="box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
</div>

{{-- ===================== THƯƠNG HIỆU ===================== --}}
<section class="categories py-5">
    <div class="container">
        <h2 class="section-title text-center mb-4">Thương hiệu</h2>
        <div class="owl-carousel categories__slider">
            @foreach ($brands as $brand)
                <div class="text-center p-3">
                    <div class="categories__item set-bg d-flex align-items-center justify-content-center shadow-sm rounded"
                        data-setbg="{{ asset($brand->logo) }}"
                        style="height: 120px; background-size: contain !important; background-repeat: no-repeat;">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===================== VOUCHER ===================== --}}
@if($vouchers->count() > 0)
<section class="vouchers py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <h2 class="section-title text-center mb-4">Mã giảm giá</h2>
        <div class="row g-4">
            @foreach ($vouchers as $voucher)
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="voucher-card shadow-sm rounded p-4 bg-white position-relative" style="border-left: 4px solid #FF6B35;">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="flex-grow-1">
                                <h5 class="text-primary fw-bold mb-2">{{ $voucher->code }}</h5>
                                @if($voucher->description)
                                    <p class="text-muted small mb-2">{{ $voucher->description }}</p>
                                @endif
                            </div>
                            <div class="text-end">
                                @if($voucher->discount_type == 'percent')
                                    <span class="badge bg-danger fs-6 px-3 py-2">
                                        -{{ number_format($voucher->discount_value, 0, ',', '.') }}%
                                    </span>
                                @else
                                    <span class="badge bg-danger fs-6 px-3 py-2">
                                        -{{ number_format($voucher->discount_value, 0, ',', '.') }} đ
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="voucher-info">
                            @if($voucher->min_order_value > 0)
                                <p class="small text-muted mb-1">
                                    <i class="fa fa-shopping-cart me-1"></i>
                                    Áp dụng cho đơn hàng từ {{ number_format($voucher->min_order_value, 0, ',', '.') }} đ
                                </p>
                            @endif
                            @if($voucher->max_discount)
                                <p class="small text-muted mb-1">
                                    <i class="fa fa-gift me-1"></i>
                                    Giảm tối đa {{ number_format($voucher->max_discount, 0, ',', '.') }} đ
                                </p>
                            @endif
                            <p class="small text-muted mb-0">
                                <i class="fa fa-calendar me-1"></i>
                                HSD: {{ \Carbon\Carbon::parse($voucher->valid_to)->format('d/m/Y') }}
                            </p>
                        </div>
                        
                        <div class="mt-3">
                            <button class="btn btn-sm btn-outline-primary w-100 copy-voucher-btn" 
                                    data-code="{{ $voucher->code }}"
                                    onclick="copyVoucherCode('{{ $voucher->code }}', this)">
                                <i class="fa fa-copy me-1"></i> Sao chép mã
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===================== COMPONENT LIST SẢN PHẨM ===================== --}}
@php
    $sections = [
        'Sản phẩm bán chạy nhất' => $bestSellers,
        'Sản phẩm mới nhất' => $newProducts,
        'Sản phẩm đánh giá cao' => $topRatedProducts,
    ];
@endphp

@foreach ($sections as $title => $items)
<section class="featured spad py-5">
    <div class="container">
        <h2 class="section-title mb-4">{{ $title }}</h2>
        <div class="row g-4">

            @foreach ($items as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="featured__item shadow-sm rounded p-2 bg-white product-card">

                        <a href="{{ route('shop.product.show', ['name' => Str::slug($product->name), 'id' => $product->id]) }}">
                            <div class="featured__item__pic set-bg rounded overflow-hidden"
                                style="height: 220px;">
                                <img src="{{ $product->thumbnail }}" alt="" style="width:100%; height:100%; object-fit:cover;">
                            </div>
                        </a>

                        <div class="featured__item__text mt-3">
                            <h6 class="text-dark">
                                <a href="{{ route('shop.product.show', ['name' => Str::slug($product->name), 'id' => $product->id]) }}" class="text-decoration-none text-dark">
                                    {{ $product->name }}
                                </a>
                            </h6>
                            <h5 class="text-primary fw-bold">{{ number_format($product->price, 0, ',', '.') }} đ</h5>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
@endforeach

@endsection

{{-- CSS thêm để giao diện đẹp hơn --}}
<style>
    .product-card {
        transition: 0.3s;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    
    .voucher-card {
        transition: 0.3s;
        height: 100%;
    }
    .voucher-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
    }
    
</style>

<script>
    function copyVoucherCode(code, button) {
        navigator.clipboard.writeText(code).then(function() {
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fa fa-check me-1"></i> Đã sao chép!';
            button.classList.remove('btn-outline-primary');
            button.classList.add('btn-success');
            
            setTimeout(function() {
                button.innerHTML = originalText;
                button.classList.remove('btn-success');
                button.classList.add('btn-outline-primary');
            }, 2000);
        }).catch(function(err) {
            alert('Không thể sao chép mã. Vui lòng thử lại.');
        });
    }
</script>

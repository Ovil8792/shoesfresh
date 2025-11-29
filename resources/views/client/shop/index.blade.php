@extends('client.layout.master')
@section('main')
    <section class="product spad pt-5 pb-5">
        <div class="container">
            <div class="row g-4"> {{-- Thêm g-4 cho khoảng cách giữa sidebar và nội dung --}}
                
                {{-- 1. SIDEBAR DANH MỤC (Lọc) --}}
                <div class="col-lg-3 col-md-5">
                    <form method="GET" action="{{ route('shop.index') }}">
                        <div class="sidebar p-3 shadow-sm rounded bg-white">
                            
                            {{-- Danh mục --}}
                            <div class="sidebar__item mb-4 pb-3 border-bottom">
    <h4 class="mb-3 text-dark fw-bold border-bottom pb-2">Danh mục giày</h4>
    <div class="sidebar-list">
        @foreach ($categories as $category)
            <div class="form-check mb-2">
                <input type="radio" name="category" value="{{ $category->id }}"
                    id="category-{{ $category->id }}"
                    {{ request('category') == $category->id ? 'checked' : '' }} 
                    class="form-check-input filter-radio-input">
                <label class="form-check-label filter-option-label" for="category-{{ $category->id }}">
                    {{ $category->name }}
                </label>
            </div>
        @endforeach
    </div>
</div>
                            
                            {{-- Thương hiệu --}}
                            {{-- Thương hiệu --}}
<div class="sidebar__item mb-4 pb-3 border-bottom">
    <h4 class="mb-3 text-dark fw-bold border-bottom pb-2">Thương hiệu</h4>
    <div class="sidebar-list">
        @foreach ($brands as $brand)
            <div class="form-check mb-2">
                <input type="radio" name="brand" value="{{ $brand->id }}"
                    id="brand-{{ $brand->id }}"
                    {{ request('brand') == $brand->id ? 'checked' : '' }} 
                    class="form-check-input filter-radio-input">
                <label class="form-check-label filter-option-label" for="brand-{{ $brand->id }}">
                    {{ $brand->name }}
                </label>
            </div>
        @endforeach
        <div class="form-check mb-2">
            <input type="radio" name="brand" value="" id="brand-all"
                {{ request('brand') ? '' : 'checked' }} 
                class="form-check-input filter-radio-input">
            <label class="form-check-label filter-option-label" for="brand-all">
                Tất cả
            </label>
        </div>
    </div>
</div>
                            
                            {{-- Khoảng giá --}}
                            <div class="sidebar__item mb-4 pb-3 border-bottom">
                                <h4 class="mb-3 text-dark fw-bold border-bottom pb-2">Khoảng giá</h4>
                                <div class="price-range-buttons d-grid" style="gap: 8px;">
                                    <button type="button" class="btn price-range-btn text-start" data-min="0" data-max="200000">Dưới 200K</button>
                                    <button type="button" class="btn price-range-btn text-start" data-min="200000" data-max="500000">200K - 500K</button>
                                    <button type="button" class="btn price-range-btn text-start" data-min="500000" data-max="1000000">500K - 1.000K</button>
                                    <button type="button" class="btn price-range-btn text-start" data-min="1000000" data-max="3000000">1.000K - 3.000K</button>
                                    <button type="button" class="btn price-range-btn text-start" data-min="3000000" data-max="99999999">Trên 3.000K</button>
                                </div>
                                <input type="hidden" id="minRange" name="min_price" value="{{ request('min_price', 0) }}">
                                <input type="hidden" id="maxRange" name="max_price" value="{{ request('max_price', 99999999) }}">
                            </div>
                            
                            {{-- Màu sắc --}}
                            <div class="sidebar__item sidebar__item__color--option mb-4 pb-3 border-bottom">
                                <h4 class="mb-3 text-dark fw-bold border-bottom pb-2">Màu sắc</h4>
                                <div class="sidebar__item__color d-flex flex-wrap" style="gap: 10px;">
                                    @foreach ($colors as $color)
                                        <label for="color-{{ $color->id }}"
                                            class="color-label d-flex align-items-center justify-content-center {{ request('color') == $color->id ? 'active' : '' }}"
                                            style="background-color: {{ $color->hex_code }};" title="{{ $color->name }}">
                                            <input type="radio" name="color" value="{{ $color->id }}"
                                                id="color-{{ $color->id }}"
                                                style="opacity:0;position:absolute;inset:0;margin:0;"
                                                {{ request('color') == $color->id ? 'checked' : '' }}>
                                            {{-- Dấu check (nếu cần) --}}
                                            @if (request('color') == $color->id)
                                                <i class="fa fa-check text-white" style="text-shadow: 0 0 3px rgba(0,0,0,0.5);"></i>
                                            @endif
                                        </label>
                                    @endforeach
                                    {{-- Nút xóa màu --}}
                                    @if (request('color'))
                                        <a href="{{ route('shop.index', array_merge(request()->except('color', 'page'))) }}" class="btn btn-sm btn-outline-danger ms-2">Xóa màu</a>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- Kích cỡ --}}
                            <div class="sidebar__item mb-4 pb-3 border-bottom">
                                <h4 class="mb-3 text-dark fw-bold border-bottom pb-2">Kích cỡ</h4>
                                <div class="sidebar__item__size d-flex flex-wrap" style="gap: 8px;">
                                    @foreach ($sizes as $size)
                                        <label for="size-{{ $size->id }}"
                                            class="size-label d-flex align-items-center justify-content-center {{ is_array(request('sizes')) && in_array($size->id, request('sizes')) ? 'active' : '' }}"
                                            style="width: 40px; height: 40px; margin: 0; border: 1px solid #ddd; cursor: pointer; border-radius: 4px; transition: all 0.2s;">
                                            {{ $size->value }}
                                            <input type="checkbox" name="sizes[]" value="{{ $size->id }}"
                                                id="size-{{ $size->id }}" style="display:none"
                                                {{ is_array(request('sizes')) && in_array($size->id, request('sizes')) ? 'checked' : '' }}>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Nút Lọc và Làm mới --}}
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary fw-bold">LỌC SẢN PHẨM</button>
                                <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary">Làm mới bộ lọc</a>
                            </div>
                        </div>
                    </form>
                </div>
                {{-- End Sidebar --}}

                {{-- 2. DANH SÁCH SẢN PHẨM --}}
                <div class="col-lg-9 col-md-7">
                    <div class="filter__item mb-4 p-3 rounded bg-white shadow-sm">
                        <div class="row align-items-center">
                            
                            {{-- Sắp xếp --}}
                            <div class="col-lg-6 col-md-6">
                                <div class="filter__sort d-flex align-items-center gap-2">
                                    <span class="text-muted small">Sắp xếp theo:</span>
                                    <select class="form-select form-select-sm w-auto" id="sortSelect" onchange="document.getElementById('sortForm').submit()">
                                        <option value="">Mặc định</option>
                                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                                    </select>
                                    <form method="GET" id="sortForm">
                                        {{-- Giữ lại các tham số lọc khác --}}
                                        @foreach (request()->except('sort', 'page') as $key => $value)
                                            @if (is_array($value))
                                                @foreach ($value as $item)
                                                    <input type="hidden" name="{{ $key }}[]" value="{{ $item }}">
                                                @endforeach
                                            @else
                                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                            @endif
                                        @endforeach
                                        <input type="hidden" name="sort" id="sortInput" value="{{ request('sort') }}">
                                    </form>
                                </div>
                            </div>
                            
                            {{-- Số lượng tìm thấy --}}
                            <div class="col-lg-6 col-md-6 text-end">
                                <div class="filter__found">
                                    <h6>Tìm thấy: <span class="text-danger fw-bold">{{ $products->total() }}</span> sản phẩm</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Danh sách sản phẩm --}}
                    <div class="row">
                        @forelse($products as $product)
                            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                                <div class="product__item shadow-sm rounded bg-white product-card"> {{-- Thêm shadow và rounded --}}
                                    <a href="{{ route('shop.product.show', ['name' => Str::slug($product->name), 'id' => $product->id]) }}">
                                        <div class="product__item__pic set-bg rounded-top overflow-hidden" 
                                            style="height: 250px;">
                                            <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" style="width:100%; height:100%; object-fit: cover;">
                                        </div>
                                    </a>

                                    <div class="product__item__text p-3">
                                        <h6 class="mb-2 text-truncate" title="{{ $product->name }}">
                                            <a href="{{ route('shop.product.show', ['name' => Str::slug($product->name), 'id' => $product->id]) }}" 
                                               class="text-decoration-none text-dark fw-normal">{{ $product->name }}</a>
                                        </h6>
                                        @php
                                            $activeDiscount = $product->discounts->where('is_active', true)
                                                ->where('start_date', '<=', now())
                                                ->where('end_date', '>=', now())
                                                ->first();
                                            $hasDiscount = $activeDiscount !== null;
                                            $discountedPrice = $hasDiscount ? $product->price * (1 - $activeDiscount->discount_percent / 100) : $product->price;
                                        @endphp
                                        
                                        @if($hasDiscount)
                                            <div class="d-flex align-items-baseline gap-2">
                                                <h5 class="text-danger fw-bold mb-0">{{ number_format($discountedPrice, 0, ',', '.') }} đ</h5>
                                                <small class="text-muted text-decoration-line-through">{{ number_format($product->price, 0, ',', '.') }} đ</small>
                                            </div>
                                            <div class="text-success small mt-1">
                                                <i class="bi bi-stopwatch"></i> Còn {{ now()->diffInDays($activeDiscount->end_date) }} ngày
                                            </div>
                                        @else
                                            <h5 class="text-danger fw-bold">{{ number_format($product->price, 0, ',', '.') }} đ</h5>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-warning text-center" role="alert">
                                    <i class="fa fa-info-circle me-2"></i>Không có sản phẩm nào phù hợp với tiêu chí lọc của bạn.
                                </div>
                            </div>
                        @endforelse
                    </div>
                    
                    {{-- Phân trang --}}
                    <div class="text-center mt-4">
                        <nav>
                            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>

                </div>
                {{-- End Danh sách sản phẩm --}}
            </div>
        </div>
    </section>
@endsection
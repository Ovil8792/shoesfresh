@extends('client.layout.master')
@section('main')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-pill px-4 py-3 text-center"
            style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; max-width: 300px;"
            role="alert">
            <strong><i class="bi bi-check-circle-fill me-1"></i></strong> {{ session('success') }}
            <button type="button" class="btn btn-sm btn-light border ms-2" style="position: absolute; top: 5px; right: 10px;"
                data-bs-dismiss="alert" aria-label="Đóng">
                ✖
            </button>
        </div>
    @endif

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/br2.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>{{ $product->name ?? 'Chi tiết sản phẩm' }}</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ url('/') }}">Trang chủ</a>
                            <a href="{{ url('/shop') }}">Cửa hàng</a>
                            <span>{{ $product->name ?? '' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <!-- Ảnh sản phẩm -->
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item mb-3">
                            <img src="{{ asset($product->thumbnail) }}" alt="{{ $product->name }}"
                                class="img-fluid rounded shadow" style="width:100%;max-height:400px;object-fit:cover;">
                        </div>
                        @if (isset($product->gallery) && count($product->gallery))
                            <div class="product__details__pic">
                                @foreach ($product->gallery as $img)
                                    <img src="{{ asset($img->url) }}" alt="" class="img-thumbnail"
                                        style="width:80px;height:80px;object-fit:cover;">
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Thông tin sản phẩm -->
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3 class="mb-2">{{ $product->name ?? 'Tên sản phẩm' }}</h3>
                        <div class="product__details__rating mb-2">
                            {{-- rating avg --}}
                            <div class="average-rating mb-2" style="font-size: 20px;">
                                @php
                                    $average = $averageRating ?? 0;
                                @endphp
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($average >= $i)
                                        <i class="fa fa-star text-warning"></i>
                                    @elseif ($average >= $i - 0.5)
                                        <i class="fa fa-star-half-o text-warning"></i>
                                    @else
                                        <i class="fa fa-star-o text-warning"></i>
                                    @endif
                                @endfor
                                <span class="ml-2 text-muted">({{ number_format($average, 1) }} trên
                                    {{ $reviews->count() }} lượt đánh giá)</span>
                            </div>
                        </div>
                        @php
                            $activeDiscount = $product->discounts->where('is_active', true)
                                ->where('start_date', '<=', now())
                                ->where('end_date', '>=', now())
                                ->first();
                            $hasDiscount = $activeDiscount !== null;
                            $discountedPrice = $hasDiscount ? $product->price * (1 - $activeDiscount->discount_percent / 100) : $product->price;
                        @endphp
                        
                        <div id="variantPrice" class="product__details__price mb-3">
                            @if($hasDiscount)
                                <div class="d-flex align-items-baseline gap-3">
                                    <h4 class="text-danger fw-bold mb-0">{{ number_format($discountedPrice, 0, ',', '.') }} đ</h4>
                                    <div class="d-flex">
                                        <small class="text-muted text-decoration-line-through">{{ number_format($product->price, 0, ',', '.') }} đ</small>
                                    </div>
                                </div>
                                <div class="text-success small mt-1">
                                    <i class="bi bi-stopwatch"></i> Còn {{ now()->diffInDays($activeDiscount->end_date) }} ngày
                                </div>
                            @else
                                <h4 class="text-danger fw-bold">{{ number_format($product->price, 0, ',', '.') }} đ</h4>
                            @endif
                        </div>
                        @if ($product->variants && $product->variants->count())
                            <div class="product__details__option mb-3">
                                <span>Chọn màu:</span>
                                <div class="d-flex flex-wrap mt-2 mb-2" id="colorOptions">
                                    @php
                                        $colors = $product->variants->pluck('color')->unique('id');
                                    @endphp
                                    @foreach ($colors as $color)
                                        <label class="optioncolor btn btn-outline-dark me-2 mb-2"
                                            data-color="{{ $color->id }}">
                                            <span class="option-value">{{ $color->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <span>Chọn size:</span>
                                <div class="d-flex flex-wrap mt-2" id="sizeOptions">
                                </div>
                            </div>
                            <form action="{{ route('shop.product.addToCart', ['id' => $product->id]) }}" method="POST"
                                class="d-inline" id="addToCartForm">
                                @csrf
                                <input type="hidden" name="product_variant_id" id="product_variant_id" value="">
                                <div class="pro-qty">
                                    <input type="number" name="quantity" value="1" min="1"
                                        style="width:50px;text-align:center;">
                                </div>
                                <button type="submit" class="primary-btn mr-2" id="addToCartBtn" disabled
                                    style="background-color: rgb(121, 121, 250)">Thêm vào giỏ hàng</button>
                                <div id="addToCartError" class="mt-2" style="display: none;"></div>
                            </form>
                        @endif
                        <ul class="mt-3 list-unstyled" style="color: black">
                            @php
                                $totalStock = $product->variants->sum('stock');
                            @endphp
                            <li><b>Tình trạng:</b>
                                <span>
                                    @if ($totalStock > 0)
                                        Còn hàng
                                    @else
                                        Hết hàng
                                    @endif
                                </span>
                            </li>
                            <li><b>Vận chuyển:</b> <span>Giao nhanh 1-2 ngày. <samp>Miễn phí vận chuyển</samp></span></li>
                            <li><b>Chia sẻ:</b>
                                <div class="share mt-1">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Tab mô tả, thông tin, đánh giá -->
            <div class="col-lg-12 mt-5">
                <div class="product__details__tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                aria-selected="true">Mô tả</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab" aria-selected="false">
                                Bình luận <span>({{ $comments->count() }})</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content p-3 border border-top-0 rounded-bottom bg-light">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Mô tả sản phẩm</h6>
                                <p>{{ $product->description ?? 'Mô tả sản phẩm sẽ hiển thị ở đây.' }}</p>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-3" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h5>Nhận xét của bạn</h5>
                                {{-- dùng từ đây --}}
                                @if (session('user'))
                                    <div class="row">
                                        {{-- bình luận --}}
                                        <div class="col-md-12">
                                            @if (session('user'))
                                                <form id="starRatingForm" method="POST">
                                                    @csrf
                                                    <div class="form-group mb-2">
                                                        <div id="interactiveRating" style="font-size: 24px;">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i class="fa fa-star-o star"
                                                                    data-value="{{ $i }}"></i>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="rating" id="ratingInput"
                                                        value="{{ $existingRating ?? '' }}">
                                                </form>
                                            @else
                                                <p>Vui lòng <a href="{{ route('user.login') }}">đăng nhập</a> để đánh giá.
                                                </p>
                                            @endif
                                            @if (session('success'))
                                                <div class="alert alert-warning alert-dismissible fade show"
                                                    role="alert">
                                                    {{ session('success') }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Đóng">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                            <form action="{{ route('product.comment.store', $product->id) }}"
                                                method="POST" class="mb-4">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="cmt">Bình luận</label>
                                                    <textarea class="form-control" name="cmt" rows="3" required></textarea>
                                                </div>
                                                <button type="submit" class="primary-btn mr-2"
                                                    style="background-color: rgb(121, 121, 250)">Gửi bình luận</button>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <p>Vui lòng <a href="{{ route('user.login') }}">đăng nhập</a> để bình luận hoặc đánh
                                        giá.</p>
                                @endif
                                {{-- đến hết đây --}}
                                {{-- Hiển thị danh sách bình luận --}}
                                @if ($comments && $comments->count())
                                    @foreach ($comments as $comment)
                                        <div class="mb-3 p-3 border rounded bg-white">
                                            <strong>
                                                {{ $comment->name }}
                                                @if (isset($comment->rating))
                                                    <span class="ms-2">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $comment->rating)
                                                                <i class="fa fa-star text-warning"></i>
                                                            @else
                                                                <i class="fa fa-star-o text-warning"></i>
                                                            @endif
                                                        @endfor
                                                    </span>
                                                @endif
                                            </strong>
                                            <span
                                                class="text-muted">({{ $comment->created_at->format('d/m/Y H:i') }})</span>
                                            <p class="mb-0">{{ $comment->cmt }}</p>
                                        </div>
                                    @endforeach
                                @else
                                    <p>Chưa có bình luận nào cho sản phẩm này.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Product Section Begin -->
    <div class="related-product mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related__product__title ">
                        <h2>Sản phẩm liên quan</h2>
                    </div>
                </div>
            </div>
            <div class="categories__slider owl-carousel">
                @foreach ($relatedProducts as $item)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="product__item h-100 d-flex flex-column">
                            <div class="product__item__pic mb-2">
                                <img src="{{ asset($item->thumbnail) }}" alt="{{ $item->name }}"
                                    class="img-fluid rounded" style="height:180px;object-fit:cover;width:100%;">
                                {{-- <ul class="product__item__pic__hover">
                                    <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                    <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                </ul> --}}
                            </div>
                            <div class="product__item__text flex-grow-1 d-flex flex-column justify-content-between">
                                <h6 class="mb-2">
                                    <a
                                        href="{{ route('shop.product.show', ['name' => Str::slug($item->name), 'id' => $item->id]) }}">
                                        {{ $item->name }}
                                    </a>
                                </h6>
                                <h5 class="text-danger mb-0">{{ number_format($item->price, 0, ',', '.') }} đ</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Product Details Section End -->

    <style>
        .optionsize:hover,
        .optioncolor:hover {
            background-color: #222 !important;
            color: #fff !important;
            border-color: #222 !important;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
        }

        .optionsize.active,
        .optionsize.btn-success,
        .optioncolor.active,
        .optioncolor.btn-success {
            background-color: #000 !important;
            color: #fff !important;
            border-color: #000 !important;
        }
    </style>

    <script>
        // Dữ liệu biến thể từ backend
        const variants = @json($variants);

        let selectedColor = null;
        let selectedSize = null;
        let currentVariantStock = 0;


        // Khi chọn màu
        document.querySelectorAll('.optioncolor').forEach(function(btn) {
            btn.addEventListener('click', function() {
                // Xóa active và border của tất cả các nút màu
                document.querySelectorAll('.optioncolor').forEach(el => {
                    el.classList.remove('active', 'border-dark', 'border-2');
                    el.classList.add('border-1');
                });
                // Thêm active và border đen đậm cho nút được chọn
                this.classList.add('active', 'border-dark', 'border-2');
                this.classList.remove('border-1');

                selectedColor = this.getAttribute('data-color');
                renderSizes();
                selectedSize = null;
                document.getElementById('product_variant_id').value = '';
                document.getElementById('addToCartBtn').disabled = true;

                // Giữ nguyên giá gốc thay vì reset rỗng
                document.getElementById('variantPrice').textContent =
                    "{{ number_format($product->price ?? 0, 0, ',', '.') }} đ";
            });
        });

        // Render size theo màu đã chọn
        function renderSizes() {
            const sizeOptions = document.getElementById('sizeOptions');
            sizeOptions.innerHTML = '';
            const sizes = variants.filter(v => v.color_id == selectedColor)
                .map(v => ({
                    id: v.size_id,
                    value: v.size_value,
                    variant_id: v.id,
                    stock: v.stock,
                    price: v.price
                }));
            // Loại bỏ size trùng
            const uniqueSizes = [];
            sizes.forEach(s => {
                if (!uniqueSizes.find(u => u.id === s.id)) uniqueSizes.push(s);
            });
            // Sắp xếp size từ bé đến lớn (nếu value là số)
            uniqueSizes.sort((a, b) => {
                let va = isNaN(a.value) ? a.value : Number(a.value);
                let vb = isNaN(b.value) ? b.value : Number(b.value);
                if (va < vb) return -1;
                if (va > vb) return 1;
                return 0;
            });

            uniqueSizes.forEach(s => {
                const label = document.createElement('label');
                label.className = 'optionsize btn btn-outline-secondary me-2 mb-2';
                label.setAttribute('data-variant', s.variant_id);
                label.setAttribute('data-stock', s.stock);
                label.innerHTML = `<span class="option-value">${s.value}</span>`;
                label.addEventListener('click', function() {
                    // Xóa active và border của tất cả các nút size
                    document.querySelectorAll('.optionsize').forEach(el => {
                        el.classList.remove('active', 'border-dark', 'border-2');
                        el.classList.add('border-1');
                    });
                    // Thêm active và border đen đậm cho nút được chọn
                    this.classList.add('active', 'border-dark', 'border-2');
                    this.classList.remove('border-1');

                    document.getElementById('product_variant_id').value = this.getAttribute('data-variant');
                    document.getElementById('addToCartBtn').disabled = false;
                    currentVariantStock = parseInt(this.getAttribute('data-stock')) || 0;

                    // Hiển thị giá tương ứng
                    const variantId = Number(this.getAttribute('data-variant'));
                    const selectedVariant = variants.find(v => Number(v.id) === variantId);

                    if (selectedVariant && selectedVariant.price) {
                        document.getElementById('variantPrice').textContent =
                            Number(selectedVariant.price).toLocaleString('vi-VN') + ' đ';
                    }

                });

                sizeOptions.appendChild(label);
            });
        }

        // Khi load trang, disable nút Thêm vào giỏ hàng
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('addToCartBtn').disabled = true;
        });

        // Hiển thị thông báo lỗi
        let errorTimeout = null;
        
        function showError(message) {
            const errorDiv = document.getElementById('addToCartError');
            if (errorDiv) {
                // Xóa bỏ thông báo cũ nếu có
                errorDiv.innerHTML = '';
                
                // Tạo thông báo mới
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                alertDiv.role = 'alert';
                alertDiv.innerHTML = `
                    <i class="fa-solid fa-circle-exclamation me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                
                errorDiv.appendChild(alertDiv);
                errorDiv.style.display = 'block';
                
                // Hủy timeout cũ nếu có
                if (errorTimeout) {
                    clearTimeout(errorTimeout);
                }
                
                // Tự động ẩn sau 5 giây
                errorTimeout = setTimeout(() => {
                    errorDiv.style.display = 'none';
                }, 5000);
                
                // Cuộn đến thông báo lỗi
                errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }

        // Ngăn submit nếu chưa chọn màu và size hoặc vượt quá tồn kho biến thể
        document.getElementById('addToCartForm').addEventListener('submit', function(e) {
            const quantity = parseInt(document.querySelector('input[name="quantity"]').value) || 1;
            const colorSelected = document.querySelector('.optioncolor.active');
            const sizeSelected = document.querySelector('.optionsize.active');
            
            // Ẩn thông báo lỗi cũ nếu có
            const errorDiv = document.getElementById('addToCartError');
            if (errorDiv) {
                errorDiv.style.display = 'none';
            }
            
            // Chỉ hiển thị thông báo khi chưa chọn đủ thông tin
            if (!colorSelected || !sizeSelected) {
                e.preventDefault();
                showError('Vui lòng chọn đầy đủ màu và size trước khi thêm vào giỏ hàng!');
                return;
            }
            
            // Các kiểm tra khác (không hiển thị thông báo ở đây)
            if (!document.getElementById('product_variant_id').value) {
                e.preventDefault();
                return;
            }
            
            if (quantity > currentVariantStock) {
                e.preventDefault();
                return;
            }
        });
    </script>

    {{-- Đánh giá sao --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('#interactiveRating .star');
            const ratingInput = document.getElementById('ratingInput');

            highlightStars(parseInt(ratingInput.value || 0));

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.dataset.value);
                    ratingInput.value = rating;
                    highlightStars(rating);

                    // Gửi AJAX đánh giá
                    fetch(`{{ route('shop.submitReview', $product->id) }}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                rating
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Đánh giá của bạn đã được lưu!');
                                // Cập nhật lại số sao trung bình và lượt đánh giá
                                const avgContainer = document.querySelector('.average-rating');
                                if (avgContainer) {
                                    const average = data.average_rating;
                                    const count = data.review_count;
                                    let starsHtml = '';
                                    for (let i = 1; i <= 5; i++) {
                                        if (average >= i) {
                                            starsHtml +=
                                                '<i class="fa fa-star text-warning"></i>';
                                        } else if (average >= i - 0.5) {
                                            starsHtml +=
                                                '<i class="fa fa-star-half-o text-warning"></i>';
                                        } else {
                                            starsHtml +=
                                                '<i class="fa fa-star-o text-warning"></i>';
                                        }
                                    }
                                    avgContainer.innerHTML = starsHtml +
                                        `<span class="ml-2 text-muted">(${average} trên ${count} lượt đánh giá)</span>`;
                                }
                            } else {
                                alert('Lỗi: ' + (data.message || 'Không thể gửi đánh giá.'));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Có lỗi xảy ra, vui lòng thử lại.');
                        });
                });
            });

            function highlightStars(rating) {
                stars.forEach(star => {
                    if (parseInt(star.dataset.value) <= rating) {
                        star.classList.remove('fa-star-o');
                        star.classList.add('fa-star', 'text-warning');
                    } else {
                        star.classList.remove('fa-star', 'text-warning');
                        star.classList.add('fa-star-o');
                    }
                });
            }
        });
    </script>

    {{-- Bình luận --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const commentForm = document.getElementById('commentForm');
            const commentMessage = document.getElementById('comment-message');
            const commentsContainer = document.querySelector('.tab-pane#tabs-3 .product__details__tab__desc');

            if (commentForm) {
                commentForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(commentForm);

                    fetch("{{ route('product.comment.store', $product->id) }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            commentMessage.innerHTML =
                                `<div class="alert alert-${data.status ? 'success' : 'warning'}">${data.message}</div>`;
                            if (data.status && data.comment) {
                                const commentHtml = `
                    <div class="mb-3 p-3 border rounded bg-white">
                        <strong>${data.comment.name}</strong>
                        <span class="text-muted">(vừa xong)</span>
                        <p class="mb-0">${data.comment.cmt}</p>
                        </div>`;
                                commentsContainer.insertAdjacentHTML('beforeend', commentHtml);
                                commentForm.reset();
                            }
                        })
                        .catch(err => {
                            commentMessage.innerHTML =
                                `<div class="alert alert-danger">Lỗi gửi bình luận</div>`;
                            console.error(err);
                        });
                });
            }
        });
    </script>
@endsection

{{-- filepath: resources/views/client/orders/order-detail.blade.php --}}
@extends('client.layout.master')

@section('main')
<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Chi tiết đơn hàng #{{ $order->id }}</h4>
        </div>
        <div class="card-body">
            @php
                $steps = [
                    'pending'     => 'Chờ xác nhận',
                    'processing'  => 'Đang xử lý',
                    'delivering'  => 'Đang giao hàng',
                    'completed'   => 'Hoàn thành',
                    'cancelled'   => 'Đã hủy'
                ];
                $current = $order->status;
                $stepKeys = array_keys($steps);
                $currentIndex = array_search($current, $stepKeys);
            @endphp
            <div class="order-tracking mb-4">
                @foreach($steps as $key => $label)
                    <div class="step {{ $current == $key ? 'current' : ($currentIndex > array_search($key, $stepKeys) ? 'active' : '') }}">
                        <div class="circle">{{ $loop->iteration }}</div>
                        <div class="label">{{ $label }}</div>
                    </div>
                    @if(!$loop->last)
                        <div class="bar"></div>
                    @endif
                @endforeach
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p><b>Ngày đặt:</b> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="col-md-6">
                    @php
                        $pm = strtoupper((string) $order->payment_method);
                        $st = (string) $order->status;
                        
                        if ($pm === 'COD') {
                            $paymentLabel = 'Thanh toán khi nhận hàng';
                            if ($st === 'completed') {
                                $paymentStatus = 'Đã thanh toán';
                                $showStatus = true;
                            } else {
                                $showStatus = false;
                            }
                        } elseif ($pm === 'VNPAY') {
                            $paymentLabel = 'VNPAY';
                            // Nếu thanh toán bằng VNPay, kể cả khi hủy vẫn hiển thị đã thanh toán
                                $paymentStatus = 'Đã thanh toán';
                            $showStatus = true;
                        } else {
                            $paymentLabel = $order->payment_method;
                            if ($st === 'completed') {
                                $paymentStatus = 'Đã thanh toán';
                            } else {
                                $paymentStatus = 'Không xác định';
                            }
                            $showStatus = true;
                        }
                    @endphp

                    <p><b>Thanh toán:</b> {{ $paymentLabel }}
                        @if($showStatus)
                            - <span class="fw-bold text-{{ $paymentStatus === 'Đã thanh toán' ? 'success' : 'danger' }}">{{ $paymentStatus }}</span>
                            @if($st === 'cancelled' && $pm === 'VNPAY')
                                <br><small class="text-danger">⚠️ Đơn hàng đã hủy - Đang xử lý hoàn tiền</small>
                            @endif
                        @endif
                    </p>

                </div>
                <div class="col-md-6">
                    <p><b>Tổng tiền:</b> <span class="text-danger fw-bold">{{ number_format($order->total_amount, 0, ',', '.') }} đ</span></p>
                </div>
            </div>
            <hr>
            <h5 class="mb-3">Danh sách sản phẩm</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tên sản phẩm</th>
                            <th>Màu & Size</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            @if(isset($canComment) && $canComment)
                            <th>Đánh giá & Bình luận</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $key => $item)
                        @php
                            $product = $item->variant->product ?? null;
                            $productId = $product->id ?? null;
                            $existingComment = isset($comments[$productId]) ? $comments[$productId]->first() : null;
                            $existingReview = isset($reviews[$productId]) ? $reviews[$productId] : null;
                        @endphp
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><a style="text-decoration: none; color: black;" href="{{ route('shop.product.show', ['name' => Str::slug($product->name), 'id' => $product->id]) }}">{{ $product->name ?? '' }}</a></td>
                            <td>
                                @if($item->variant)
                                    <span class="badge bg-secondary" style="color: white;">Màu: {{ $item->variant->color->name ?? '' }}</span>
                                    <span class="badge bg-secondary" style="color: white;">Size: {{ $item->variant->size->value ?? '' }}</span>
                                @endif
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 0, ',', '.') }} đ</td>
                            @if(isset($canComment) && $canComment && $productId)
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="collapse" 
                                    data-bs-target="#commentSection{{ $productId }}" aria-expanded="false">
                                    <i class="fa fa-comment"></i> Đánh giá & Bình luận
                                </button>
                            </td>
                            @endif
                        </tr>
                        @if(isset($canComment) && $canComment && $productId)
                        <tr>
                            <td colspan="6" class="p-0 border-0">
                                <div class="collapse" id="commentSection{{ $productId }}">
                                    <div class="card card-body bg-light m-3">
                                        <h6 class="mb-3">
                                            <i class="fa fa-star text-warning"></i> Đánh giá sản phẩm: {{ $product->name }}
                                        </h6>
                                        
                                        {{-- Form đánh giá sao --}}
                                        <div class="mb-3">
                                            <label class="form-label">Đánh giá:</label>
                                            <div id="ratingSection{{ $productId }}" style="font-size: 20px;">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fa fa-star-o star-rating" 
                                                       data-product-id="{{ $productId }}" 
                                                       data-rating="{{ $i }}"
                                                       style="cursor: pointer; color: #ffc107;"></i>
                                                @endfor
                                                <span id="ratingText{{ $productId }}" class="ms-2 text-muted"></span>
                                            </div>
                                            <input type="hidden" id="ratingInput{{ $productId }}" 
                                                   value="{{ $existingReview->rating ?? '' }}">
                                        </div>
                                        
                                        {{-- Form bình luận --}}
                                        <form id="commentForm{{ $productId }}" class="comment-form" 
                                              data-product-id="{{ $productId }}"
                                              data-comment-url="{{ route('product.comment.store', $productId) }}"
                                              data-review-url="{{ route('shop.submitReview', $productId) }}">
                                            @csrf
                                            <div class="mb-2">
                                                <label for="commentText{{ $productId }}" class="form-label">Bình luận:</label>
                                                <textarea class="form-control" id="commentText{{ $productId }}" 
                                                          name="cmt" rows="3" 
                                                          placeholder="Chia sẻ cảm nhận của bạn về sản phẩm...">{{ $existingComment->cmt ?? '' }}</textarea>
                                            </div>
                                            <div id="commentMessage{{ $productId }}" class="mb-2"></div>
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fa fa-paper-plane"></i> Gửi bình luận
                                            </button>
                                        </form>
                                        
                                        {{-- Hiển thị bình luận đã gửi --}}
                                        @if($existingComment)
                                        <div class="mt-3 p-2 bg-white rounded border">
                                            <small class="text-muted">Bình luận của bạn:</small>
                                            <p class="mb-0 mt-1">{{ $existingComment->cmt }}</p>
                                            <small class="text-muted">{{ $existingComment->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>

                {{-- Nút huỷ đơn hàng --}}
                @if($order->status === 'processing' || $order->status === 'processing' ||$order->status === 'paid')
                    <button id="btnCancelOrder" class="btn-cancel">Huỷ đơn hàng</button>
                @elseif($order->status !== 'cancelled')
                    <div class="alert alert-info mt-3">Đơn hàng đang trong quá trình vận chuyển hoặc đã hoàn thành, không thể huỷ!</div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal huỷ đơn hàng --}}
<div id="cancelWarningModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <h2>Xác nhận huỷ đơn hàng</h2>
        <p>Vui lòng nhập lý do bạn muốn huỷ đơn hàng:</p>
        <form method="POST" id="cancelForm" action="{{ route('profile.orders.cancel', $order->id) }}">
            @csrf
            <textarea name="cancel_reason" placeholder="Ví dụ: Đã thay đổi ý định, không cần hàng nữa..." required></textarea>
            <div class="modal-buttons">
                <button type="submit" class="btn-confirm">Xác nhận huỷ</button>
                <button type="button" id="btnCloseModal" class="btn-close">Đóng</button>
            </div>
        </form>
    </div>
</div>

{{-- JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnCancel = document.getElementById('btnCancelOrder');
    const modal = document.getElementById('cancelWarningModal');
    const btnClose = document.getElementById('btnCloseModal');

    // Gán sự kiện cho nút huỷ nếu tồn tại
    if (btnCancel && modal) {
        btnCancel.addEventListener('click', function () {
            modal.style.display = 'flex';
        });
    }

    // Gán sự kiện cho nút đóng nếu tồn tại
    if (btnClose && modal) {
        btnClose.addEventListener('click', function () {
            modal.style.display = 'none';
        });
    }

    // Xử lý đánh giá sao
    document.querySelectorAll('.star-rating').forEach(star => {
        star.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const rating = parseInt(this.dataset.rating);
            const ratingInput = document.getElementById('ratingInput' + productId);
            const ratingText = document.getElementById('ratingText' + productId);
            
            // Cập nhật input
            ratingInput.value = rating;
            
            // Cập nhật hiển thị sao
            const stars = document.querySelectorAll(`[data-product-id="${productId}"].star-rating`);
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.remove('fa-star-o');
                    s.classList.add('fa-star');
                } else {
                    s.classList.remove('fa-star');
                    s.classList.add('fa-star-o');
                }
            });
            
            // Cập nhật text
            ratingText.textContent = rating + '/5';
            
            // Lấy URL từ form
            const form = document.getElementById('commentForm' + productId);
            const reviewUrl = form ? form.dataset.reviewUrl : `/shop/product/${productId}/review`;
            
            // Gửi đánh giá
            fetch(reviewUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ rating: rating })
            })
            .then(async (response) => {
                const contentType = response.headers.get('content-type') || '';
                const isJson = contentType.includes('application/json');
                const payload = isJson ? await response.json() : await response.text();

                if (!response.ok) {
                    const message = isJson
                        ? (payload && payload.message ? payload.message : 'Không thể gửi đánh giá.')
                        : 'Không thể gửi đánh giá (server trả về HTML - kiểm tra lại route).';
                    throw new Error(message);
                }

                if (!isJson) {
                    throw new Error('Không thể gửi đánh giá (server trả về HTML - kiểm tra lại route).');
                }

                return payload;
            })
            .then(data => {
                if (data.success) {
                    const messageDiv = document.getElementById('commentMessage' + productId);
                    messageDiv.innerHTML = '<div class="alert alert-success alert-dismissible fade show"><small>Đánh giá đã được lưu!</small><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
                    setTimeout(() => {
                        messageDiv.innerHTML = '';
                    }, 3000);
                }
            })
            .catch(error => {
                const messageDiv = document.getElementById('commentMessage' + productId);
                messageDiv.innerHTML = '<div class="alert alert-danger alert-dismissible fade show"><small>' + error.message + '</small><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
            });
        });
    });

    // Khởi tạo sao đã đánh giá
    document.querySelectorAll('[id^="ratingInput"]').forEach(input => {
        const productId = input.id.replace('ratingInput', '');
        const rating = parseInt(input.value);
        if (rating) {
            const stars = document.querySelectorAll(`[data-product-id="${productId}"].star-rating`);
            const ratingText = document.getElementById('ratingText' + productId);
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.remove('fa-star-o');
                    s.classList.add('fa-star');
                }
            });
            if (ratingText) {
                ratingText.textContent = rating + '/5';
            }
        }
    });

    // Xử lý form bình luận
    document.querySelectorAll('.comment-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            const commentUrl = this.dataset.commentUrl || `/shop/comment/${productId}`;
            const formData = new FormData(this);
            const messageDiv = document.getElementById('commentMessage' + productId);
            
            messageDiv.innerHTML = '<div class="alert alert-info"><small>Đang gửi...</small></div>';
            
            fetch(commentUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(async (response) => {
                const contentType = response.headers.get('content-type') || '';
                const isJson = contentType.includes('application/json');
                const payload = isJson ? await response.json() : await response.text();

                if (!response.ok) {
                    const message = isJson
                        ? (payload && payload.message ? payload.message : 'Không thể gửi bình luận.')
                        : 'Không thể gửi bình luận (server trả về HTML - kiểm tra lại route).';
                    throw new Error(message);
                }

                if (!isJson) {
                    throw new Error('Không thể gửi bình luận (server trả về HTML - kiểm tra lại route).');
                }

                return payload;
            })
            .then(data => {
                if (data.status) {
                    messageDiv.innerHTML = '<div class="alert alert-success alert-dismissible fade show"><small>' + data.message + '</small><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
                    if (data.comment) {
                        // Reload trang sau 1 giây để hiển thị bình luận mới
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        setTimeout(() => {
                            messageDiv.innerHTML = '';
                        }, 3000);
                    }
                } else {
                    messageDiv.innerHTML = '<div class="alert alert-danger alert-dismissible fade show"><small>' + data.message + '</small><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
                }
            })
            .catch(error => {
                messageDiv.innerHTML = '<div class="alert alert-danger alert-dismissible fade show"><small>' + error.message + '</small><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
            });
        });
    });
});
</script>

{{-- CSS --}}
<style>
/* Progress Bar */
.order-tracking {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0;
    margin-bottom: 30px;
}
.order-tracking .step {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 90px;
    position: relative;
}
.order-tracking .circle {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #dee2e6;
    color: #888;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-bottom: 5px;
    border: 2px solid #dee2e6;
    transition: all 0.3s;
}
.order-tracking .step.active .circle {
    background: #0d6efd;
    color: #fff;
    border-color: #0d6efd;
}
.order-tracking .step.current .circle {
    background: #ffc107;
    color: #212529;
    border-color: #ffc107;
}
.order-tracking .label {
    font-size: 13px;
    text-align: center;
    color: #555;
}
.order-tracking .bar {
    width: 40px;
    height: 4px;
    background: #dee2e6;
    margin: 0 2px;
    border-radius: 2px;
}
.order-tracking .step.active ~ .bar,
.order-tracking .step.current ~ .bar {
    background: #0d6efd;
}

/* Modal */
.modal-overlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}
.modal-content {
    background: #fff;
    border-radius: 10px;
    padding: 25px 30px;
    width: 400px;
    max-width: 90%;
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    font-family: "Segoe UI", sans-serif;
    text-align: center;
}
.modal-content h2 {
    font-size: 20px;
    margin-bottom: 10px;
}
.modal-content p {
    font-size: 14px;
    color: #333;
    margin-bottom: 15px;
}
.modal-content textarea {
    width: 100%;
    height: 100px;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    resize: none;
    font-size: 14px;
}
.modal-buttons {
    display: flex;
    justify-content: space-between;
    gap: 10px;
    margin-top: 15px;
}
.btn-confirm, .btn-close, .btn-cancel {
    padding: 10px 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
}
.btn-confirm {
    background-color: #dc3545;
    color: white;
}
.btn-close {
    background-color: #6c757d;
    color: white;
}
.btn-cancel {
    background-color: #fff;
    border: 2px solid #dc3545;
    color: #dc3545;
    transition: background-color 0.3s;
    margin-top: 15px;
}
.btn-cancel:hover {
    background-color: #dc3545;
    color: white;
}

/* Comment Section Styles */
.comment-form {
    margin-top: 15px;
}

.star-rating {
    transition: all 0.2s;
}

.star-rating:hover {
    transform: scale(1.2);
}

#ratingSection .fa-star {
    color: #ffc107;
}

#ratingSection .fa-star-o {
    color: #ddd;
}

.collapse {
    transition: all 0.3s ease;
}

.card-body.bg-light {
    border-left: 3px solid #0d6efd;
}
</style>
@endsection

@extends('client.layout.master')
@section('main')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Giỏ hàng</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ url('/') }}">Trang chủ</a>
                            <span>Giỏ hàng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="shoping__product">Sản phẩm</th>
                                    <th>Phân loại</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cartItems as $item)
                                    <tr>
                                        <td class="shoping__cart__item d-flex align-items-center">
                                            <img src="{{ asset($item->variant->product->thumbnail ?? 'img/no-image.png') }}"
                                                alt=""
                                                style="width:70px; height:70px; object-fit:cover; border-radius:8px; margin-right:12px;">
                                            <div>
                                                <h6 class="mb-1">{{ $item->variant->product->name ?? 'Sản phẩm' }}</h6>
                                                <small class="text-muted">Mã SP: {{ $item->variant->sku ?? '-' }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border">
                                                Size: {{ $item->variant->size->value ?? '-' }},
                                                Màu: {{ $item->variant->color->name ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="shoping__cart__price">
                                            {{ number_format($item->variant->price ?? 0, 0, ',', '.') }} đ
                                        </td>
                                        <td class="shoping__cart__quantity">
                                            <div class="quantity d-flex align-items-center justify-content-center gap-1">
                                                <button type="button"
                                                    class="btn btn-outline-dark btn-sm rounded-circle px-2 py-1 btn-qty"
                                                    data-type="minus" data-id="{{ $item->id }}">
                                                    -
                                                </button>

                                                <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                    min="1" max="{{ $item->variant->stock }}"
                                                    class="form-control text-center input-qty"
                                                    data-id="{{ $item->id }}" data-stock="{{ $item->variant->stock }}"
                                                    style="width: 60px; height: 32px; padding: 0; font-weight: 500;">

                                                <button type="button"
                                                    class="btn btn-outline-dark btn-sm rounded-circle px-2 py-1 btn-qty"
                                                    data-type="plus" data-id="{{ $item->id }}">
                                                    +
                                                </button>
                                            </div>
                                        </td>

                                        <td class="shoping__cart__total" data-id="{{ $item->id }}">
                                            {{ number_format(($item->variant->price ?? 0) * $item->quantity, 0, ',', '.') }}
                                            đ
                                        </td>
                                        <td class="shoping__cart__item__close">
                                            <form action="{{ route('cart.remove', $item->id) }}" method="GET"
                                                onsubmit="return confirm('Xóa sản phẩm này khỏi giỏ hàng?')">
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Giỏ hàng của bạn đang trống.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @if (count($cartItems))
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="shoping__cart__btns">
                            <a href="{{ url('/shop') }}" class="primary-btn cart-btn">Tiếp tục mua hàng</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="shoping__continue">
                            <div class="shoping__discount">
                                <h5>Mã giảm giá</h5>
                                <div class="d-flex align-items-center gap-2" id="voucherAction">
                                    <form id="voucherForm" action="{{ route('cart.applyVoucher') }}" method="POST"
                                        class="d-flex align-items-center">
                                        @csrf
                                        <input type="text" name="voucher_code" placeholder="Nhập mã giảm giá" required
                                            class="form-control" style="max-width: 180px;">
                                        <button type="submit" class="btn btn-link text-dark ms-2">Áp dụng</button>
                                    </form>
                                    @if (session('voucher'))
                                        <form id="removeVoucherForm" action="{{ route('cart.removeVoucher') }}"
                                            method="POST" style="margin-left:16px">
                                            @csrf
                                            <button type="submit" class="btn btn-link text-danger">
                                                <i class="bi bi-x-circle"></i> Hủy mã
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                <div id="voucherMessage"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="shoping__checkout">
                            <h5>Tổng giỏ hàng</h5>
                            @php
                                $subtotal = $cartItems->sum(fn($i) => ($i->variant->price ?? 0) * $i->quantity);
                                $voucher = session('voucher');
                                $discount = 0;
                                if ($voucher) {
                                    if ($voucher->discount_type == 'percent') {
                                        $discount = round(($subtotal * $voucher->discount_value) / 100);
                                        if ($voucher->max_discount && $discount > $voucher->max_discount) {
                                            $discount = $voucher->max_discount;
                                        }
                                    } else {
                                        $discount = $voucher->discount_value;
                                    }
                                    if ($discount > $subtotal) {
                                        $discount = $subtotal;
                                    }
                                }
                                $total = $subtotal - $discount;
                            @endphp
                            <div id="cartSummary">
                                @include('client.shop.cart-summary', [
                                    'subtotal' => $subtotal,
                                    'voucher' => $voucher,
                                    'discount' => $discount,
                                    'total' => $total,
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!-- Shoping Cart Section End -->

    <script>
        // --- Voucher AJAX ---
        function attachVoucherEvents() {
            // Áp dụng voucher
            let voucherForm = document.getElementById('voucherForm');
            if (voucherForm) {
                voucherForm.onsubmit = function(e) {
                    e.preventDefault();
                    let form = this;
                    let formData = new FormData(form);
                    fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': form.querySelector('[name="_token"]').value,
                                'Accept': 'application/json'
                            },
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            let msgDiv = document.getElementById('voucherMessage');
                            if (data.success) {
                                msgDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                                document.getElementById('cartSummary').innerHTML = data.cart_summary_html;
                                renderVoucherAction(true);
                            } else {
                                msgDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                            }
                        });
                }
            }
            // Hủy voucher
            let removeForm = document.getElementById('removeVoucherForm');
            if (removeForm) {
                removeForm.onsubmit = function(e) {
                    e.preventDefault();
                    if (confirm('Bạn có chắc muốn xóa mã giảm giá?')) {
                        fetch(this.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': this.querySelector('[name="_token"]').value,
                                    'Accept': 'application/json'
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                let msgDiv = document.getElementById('voucherMessage');
                                if (data.success) {
                                    msgDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                                    document.getElementById('cartSummary').innerHTML = data.cart_summary_html;
                                    renderVoucherAction(false);
                                }
                            });
                    }
                }
            }
        }

        function renderVoucherAction(hasVoucher) {
            let html = `
            <form id="voucherForm" action="{{ route('cart.applyVoucher') }}" method="POST" class="d-flex align-items-center">
                @csrf
                <input type="text" name="voucher_code" placeholder="Nhập mã giảm giá" required class="form-control" style="max-width: 180px;">
                <button type="submit" class="btn btn-link text-dark ms-2">Áp dụng</button>
            </form>
        `;
            if (hasVoucher) {
                html += `
            <form id="removeVoucherForm" action="{{ route('cart.removeVoucher') }}" method="POST" style="margin-left:16px;">
                @csrf
                <button type="submit" class="btn btn-link text-danger ">
                    <i class="bi bi-x-circle"></i> Hủy mã
                </button>
            </form>
            `;
            }
            document.getElementById('voucherAction').innerHTML = html;
            attachVoucherEvents();
        }

        // --- Cart quantity AJAX ---
        function attachCartEvents() {
            // Sự kiện thay đổi số lượng bằng input
            document.querySelectorAll('.input-qty').forEach(input => {
                input.onchange = function() {
                    let id = this.dataset.id;
                    let qty = parseInt(this.value);
                    let stock = parseInt(this.dataset.stock);
                    if (qty > stock) {
                        alert('Số lượng vượt quá số lượng tồn kho!');
                        this.value = stock;
                        qty = stock;
                    }
                    if (qty < 1) {
                        this.value = 1;
                        qty = 1;
                    }
                    fetch('{{ route('cart.updateQuantity') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                id,
                                quantity: qty
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                document.querySelector('.shoping__cart__total[data-id="' + id + '"]')
                                    .innerText = data.item_total + ' đ';
                                document.getElementById('cartSummary').innerHTML = data.cart_summary_html;
                            } else if (data.error) {
                                alert(data.error);
                                this.value = data.max_stock;
                            }
                        });
                };
            });
            // Sự kiện tăng/giảm số lượng bằng nút
            document.querySelectorAll('.btn-qty').forEach(btn => {
                btn.onclick = function() {
                    let input = document.querySelector('.input-qty[data-id="' + this.dataset.id + '"]');
                    let current = parseInt(input.value);
                    let stock = parseInt(input.dataset.stock);
                    if (this.dataset.type === 'plus') {
                        if (current < stock) {
                            input.value = current + 1;
                        } else {
                            alert('Số lượng vượt quá số lượng tồn kho!');
                            input.value = stock;
                        }
                    }
                    if (this.dataset.type === 'minus' && current > 1) input.value = current - 1;
                    input.dispatchEvent(new Event('change'));
                };
            });
        }

        // Gắn sự kiện khi trang load
        document.addEventListener('DOMContentLoaded', function() {
            attachVoucherEvents();
            attachCartEvents();
        });
    </script>
@endsection

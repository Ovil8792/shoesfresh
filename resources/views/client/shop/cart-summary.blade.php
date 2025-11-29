<ul>
    <li>Tạm tính <span>{{ number_format($subtotal, 0, ',', '.') }} đ</span></li>
    @if($voucher)
        <li>Giảm giá ({{ $voucher->code }}) <span>-{{ number_format($discount, 0, ',', '.') }} đ</span></li>
    @endif
    <li><b>Tổng cộng</b> <span>{{ number_format($total, 0, ',', '.') }} đ</span></li>
</ul>
<a href="{{ route('checkout.index') }}" class="primary-btn" style="background-color:rgb(97, 97, 255);">Thanh toán</a>

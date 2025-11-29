@extends('admin.layout.master')
@section('main')
<div class="container mt-4">
    <h3>Chi tiết mã giảm giá</h3>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td>{{ $voucher->id }}</td>
                </tr>
                <tr>
                    <th>Mã giảm giá</th>
                    <td>{{ $voucher->code }}</td>
                </tr>
                <tr>
                    <th>Mô tả</th>
                    <td>{{ $voucher->description }}</td>
                </tr>
                <tr>
                    <th>Loại giảm giá</th>
                    <td>
                        @if($voucher->discount_type == 'percent')
                            Phần trăm (%)
                        @else
                            Số tiền cố định
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Giá trị giảm</th>
                    <td>{{ $voucher->discount_value }}</td>
                </tr>
                <tr>
                    <th>Giảm tối đa</th>
                    <td>{{ $voucher->max_discount }}</td>
                </tr>
                <tr>
                    <th>Giá trị đơn tối thiểu</th>
                    <td>{{ $voucher->min_order_value }}</td>
                </tr>
                <tr>
                    <th>Số lượt sử dụng tối đa</th>
                    <td>{{ $voucher->usage_limit }}</td>
                </tr>
                <tr>
                    <th>Số lượt đã sử dụng</th>
                    <td>{{ $voucher->used_count }}</td>
                </tr>
                <tr>
                    <th>Ngày bắt đầu</th>
                    <td>{{ $voucher->valid_from }}</td>
                </tr>
                <tr>
                    <th>Ngày kết thúc</th>
                    <td>{{ $voucher->valid_to }}</td>
                </tr>
            </table>
            <a href="{{ route('voucher.index') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </div>
</div>
@endsection

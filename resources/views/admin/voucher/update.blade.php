@extends('admin.layout.master')

@section('main')
<div class="row justify-content-center mt-4">
    <div class="col-md-7">
        <div class="card shadow">
            <div class="card-header text-center bg-primary">
                <h4 class="mb-0 text-white">Sửa mã giảm giá</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('voucher.update', $voucher->id) }}" method="post">
                    @csrf
                    @method('post')
                    <input type="text" name="id" value="{{ $voucher->id }}" hidden>
                    <div class="mb-3">
                        <label class="form-label">Mã giảm giá</label>
                        <input type="text" class="form-control" name="code" value="{{ $voucher->code }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea class="form-control" name="description">{{ $voucher->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Loại giảm giá</label>
                        <select class="form-select" name="discount_type" required>
                            <option value="percent" @if($voucher->discount_type == 'percent') selected @endif>Phần trăm (%)</option>
                            <option value="fixed" @if($voucher->discount_type == 'fixed') selected @endif>Số tiền cố định</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Giá trị giảm</label>
                        <input type="number" class="form-control" name="discount_value" value="{{ $voucher->discount_value }}" required min="1">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Giảm tối đa</label>
                        <input type="number" class="form-control" name="max_discount" value="{{ $voucher->max_discount }}" min="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Giá trị đơn tối thiểu</label>
                        <input type="number" class="form-control" name="min_order_value" value="{{ $voucher->min_order_value }}" min="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Số lượt sử dụng tối đa</label>
                        <input type="number" class="form-control" name="usage_limit" value="{{ $voucher->usage_limit }}" min="1">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Số lượt đã sử dụng</label>
                        <input type="number" class="form-control" name="used_count" value="{{ $voucher->used_count ?? 0 }}" min="0" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ngày bắt đầu</label>
                        <input type="date" class="form-control" name="valid_from" value="{{ $voucher->valid_from }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ngày kết thúc</label>
                        <input type="date" class="form-control" name="valid_to" value="{{ $voucher->valid_to }}" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('voucher.index') }}" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

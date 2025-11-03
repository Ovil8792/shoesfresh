@extends('admin.layout.main')
@section("main")
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">Chi tiết hóa đơn #{{ $hoadon->id ?? '—' }}</h2>
                <p class="text-muted mb-0">Thông tin chi tiết về hóa đơn</p>
            </div>
            <div>
                <a href="{{ route('admin.hoadon') }}" class="btn btn-outline-secondary">Quay lại danh sách</a>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @php
                $statusName = null;
                foreach ($trangthaihoadons as $tthd) {
                    if ($tthd->id == $hoadon->trangthaihoadon_id) { $statusName = $tthd->name; break; }
                }
                $ptttName = null;
                foreach ($phuongthucthanhtoans as $pt) {
                    if ($pt->id == $hoadon->phuongthucthanhtoan_id) { $ptttName = $pt->name; break; }
                }
                $productName = null;
                foreach ($products as $p) {
                    if ($p->id == $hoadon->sanpham_id) { $productName = $p->name; break; }
                }
            @endphp
            <form method="POST" action="{{ route('admin.hoadon.update', $hoadon->id) }}">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Khách hàng</label>
                            <div class="form-control bg-light">{{ $hoadon->user_id == 0 ? 'UserTest' : $hoadon->user_id }}</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Sản phẩm</label>
                            <select name="sanpham_id" class="form-select">
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}" {{ $p->id == $hoadon->sanpham_id ? 'selected' : '' }}>{{ $p->name }} (#{{ $p->id }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Số lượng</label>
                            <input type="number" min="1" name="soluong" value="{{ old('soluong', $hoadon->soluong) }}" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tổng tiền</label>
                            <input type="number" step="0.01" name="tongtien" value="{{ old('tongtien', $hoadon->tongtien ?? $hoadon->thanhtien) }}" class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Trạng thái</label>
                            <select name="trangthaihoadon_id" class="form-select">
                                @foreach($trangthaihoadons as $tthd)
                                    <option value="{{ $tthd->id }}" {{ $tthd->id == $hoadon->trangthaihoadon_id ? 'selected' : '' }}>{{ $tthd->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Phương thức thanh toán</label>
                            <select name="phuongthucthanhtoan_id" class="form-select">
                                @foreach($phuongthucthanhtoans as $pt)
                                    <option value="{{ $pt->id }}" {{ $pt->id == $hoadon->phuongthucthanhtoan_id ? 'selected' : '' }}>{{ $pt->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mt-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    <a href="{{ route('admin.hoadon') }}" class="btn btn-outline-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@extends('admin.layout.index')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-white border-bottom">
                        <h3 class="mb-0" style="color: #a94442">Hoá Đơn Đã Thanh Toán</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="color: #a94442!;important;">
                                <thead class="table-light">
                                    <tr>
                                        <th>Mã Hoá Đơn</th>
                                        <th>Ngày Lập</th>
                                        <th>Trạng Thái</th>
                                        <th>Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posOrder as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->created_at }}</td>
                                            <td>
                                                @if ($order->status == 'Đã thanh toán')
                                                    <span class="badge bg-success">Đã thanh toán</span>
                                                @else
                                                    <span class="badge bg-danger">Đã huỷ</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="window.location.href='{{ route('pos.bill', $order->id) }}'">
                                                    Chi tiết
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

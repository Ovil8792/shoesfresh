@extends('admin.layout.index')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white border-bottom">
                    <h3 class="mb-0" style="color: #a94442">Hoá Đơn Chờ</h3>
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
                                @forelse ($posOrder as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="badge bg-warning text-dark">{{ $order->status }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('pos.edit', $order->id) }}" class="btn btn-primary btn-sm">+</a>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Không có hoá đơn chờ nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
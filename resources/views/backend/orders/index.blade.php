@extends('layouts.backend')
@section('content')
@section('title', 'Đơn hàng')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Đơn hàng</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID đơn hàng</th>
                            <th>Tổng tiền</th>
                            <th>Ngày đặt</th>
                            <th>Trạng thái</th>
                            <th>Mã giảm giá (Nếu có)</th>
                            <th>Hình thức thanh toán</th>
                            <th>Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->order_id }}</td>
                                <td>{{ number_format($order->price_total, 0, ',', ',') . ' VND' }}</td>
                                <td>{{ $order->created_at }}</td>
                                <td>
                                    @if ($order->order_status == 0)
                                        <a href="{{ route('admin.order.changeStatus', $order->order_id) }}"><span
                                                class="badge badge-warning">Đang chờ duyệt</span></a>
                                    @elseif ($order->order_status == 1)
                                        <a href="{{ route('admin.order.changeStatus', $order->order_id) }}"><span
                                                class="badge badge-info">Đã xác nhận</span></a>
                                    @elseif ($order->order_status == 2)
                                        <span class="badge badge-danger">Đã hủy</span>
                                    @elseif ($order->order_status == 3)
                                        <span class="badge badge-success">Đã giao hàng</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($order->order_code != null)
                                        Có
                                    @else
                                        Không có
                                    @endif
                                </td>
                                <td>{{ $order->order_type }}</td>
                                <td>
                                    <a href="{{ route('admin.order.show', $order->order_id) }}"
                                        class="btn-sm btn btn-primary">Chi tiết</a>
                                    <a href="{{ route('admin.order.destroy', $order->order_id) }}"
                                        class="btn-sm btn btn-danger"
                                        onclick="return confirm('Ban co chac muon xoa don hang nay ?')">Xóa</a>
                                    @if ($order->order_status != 2)
                                        <a href="{{ route('admin.order.print', $order->order_id) }}"
                                            class="btn-sm btn btn-warning" target="_blank">In hóa đơn</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
$success = Session::get('success');
if ($success) {
    echo "<script>alert('$success')</script>";
    Session::forget('success');
}
?>

@stop

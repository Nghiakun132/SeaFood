@extends('layouts.frontend')
@section('content')
@section('title','Don hang')
<main id="main" class="main-site left-sidebar">
    <div class="container">
        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="#" class="link">Trang chu</a></li>
                <li class="item-link"><span>Don hang</span></li>
            </ul>
        </div>
        <div class="row">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="vidu" width="100%" cellspacing="0">
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
                                <td>#{{ $order->order_id }}</td>
                                <td>{{ number_format(($order->price_total),0,',',','). ' VND'}}</td>
                                <td>{{ $order->created_at }}</td>
                                <td>
                                    @if ($order->order_status == 0)
                                        <span class="label label-warning">Đang chờ</span>
                                    @elseif ($order->order_status == 1)
                                        <span class="label label-success">Đã xác nhận</span>
                                    @elseif ($order->order_status == 2)
                                        <span class="label label-danger">Đã hủy</span>
                                    @elseif ($order->order_status == 3)
                                        <span class="label label-info">Đã giao hàng</span>
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
                                    @if ($order->order_status == 0)
                                        <a href="{{route('cancel',$order->order_id)}}" class="btn btn-danger">Huy</a>
                                    @endif
                                    <a href="{{route('order.detail',$order->order_id)}}" class="btn btn-primary">Chi tiết</a>
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
</main>
@stop

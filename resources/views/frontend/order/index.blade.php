@extends('layouts.frontend')
@section('content')
@section('title', 'Don hang')
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
                    <div class="wrap-product-detail">
                        <div class="advance-info">
                            <div class="tab-control normal">
                                <a href="#orders" class="tab-control-item active">Tat ca don hang</a>
                                <a href="#wait" class="tab-control-item">Dang cho</a>
                                <a href="#confirmed" class="tab-control-item">Da xac nhan</a>
                                <a href="#delivered" class="tab-control-item">Da giao</a>
                                <a href="#cancel" class="tab-control-item">Da huy</a>
                            </div>
                            <div class="tab-contents">
                                <div class="tab-content-item active" id="orders">
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
                                                        <td>{{ number_format($order->price_total, 0, ',', ',') . ' VND' }}
                                                        </td>
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
                                                                <a href="{{ route('cancel', $order->order_id) }}"
                                                                    class="btn btn-danger">Huy</a>
                                                            @endif
                                                            <a href="{{ route('order.detail', $order->order_id) }}"
                                                                class="btn btn-primary">Chi tiết</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-content-item " id="wait">
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
                                                @foreach ($ordersWait as $order1)
                                                    <tr>
                                                        <td>#{{ $order1->order_id }}</td>
                                                        <td>{{ number_format($order1->price_total, 0, ',', ',') . ' VND' }}
                                                        </td>
                                                        <td>{{ $order1->created_at }}</td>
                                                        <td>
                                                            @if ($order1->order_status == 0)
                                                                <span class="label label-warning">Đang chờ</span>
                                                            @elseif ($order1->order_status == 1)
                                                                <span class="label label-success">Đã xác nhận</span>
                                                            @elseif ($order1->order_status == 2)
                                                                <span class="label label-danger">Đã hủy</span>
                                                            @elseif ($order1->order_status == 3)
                                                                <span class="label label-info">Đã giao hàng</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($order1->order_code != null)
                                                                Có
                                                            @else
                                                                Không có
                                                            @endif
                                                        </td>
                                                        <td>{{ $order1->order_type }}</td>
                                                        <td>
                                                            @if ($order1->order_status == 0)
                                                                <a href="{{ route('cancel', $order1->order_id) }}"
                                                                    class="btn btn-danger">Huy</a>
                                                            @endif
                                                            <a href="{{ route('order.detail', $order1->order_id) }}"
                                                                class="btn btn-primary">Chi tiết</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-content-item " id="confirmed">
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
                                                @foreach ($ordersConfirmed as $order2)
                                                    <tr>
                                                        <td>#{{ $order2->order_id }}</td>
                                                        <td>{{ number_format($order2->price_total, 0, ',', ',') . ' VND' }}
                                                        </td>
                                                        <td>{{ $order2->created_at }}</td>
                                                        <td>
                                                            @if ($order2->order_status == 0)
                                                                <span class="label label-warning">Đang chờ</span>
                                                            @elseif ($order2->order_status == 1)
                                                                <span class="label label-success">Đã xác nhận</span>
                                                            @elseif ($order2->order_status == 2)
                                                                <span class="label label-danger">Đã hủy</span>
                                                            @elseif ($order2->order_status == 3)
                                                                <span class="label label-info">Đã giao hàng</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($order2->order_code != null)
                                                                Có
                                                            @else
                                                                Không có
                                                            @endif
                                                        </td>
                                                        <td>{{ $order2->order_type }}</td>
                                                        <td>
                                                            @if ($order2->order_status == 0)
                                                                <a href="{{ route('cancel', $order2->order_id) }}"
                                                                    class="btn btn-danger">Huy</a>
                                                            @endif
                                                            <a href="{{ route('order.detail', $order2->order_id) }}"
                                                                class="btn btn-primary">Chi tiết</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-content-item " id="delivered">
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
                                                @foreach ($ordersDelivered as $order3)
                                                    <tr>
                                                        <td>#{{ $order3->order_id }}</td>
                                                        <td>{{ number_format($order3->price_total, 0, ',', ',') . ' VND' }}
                                                        </td>
                                                        <td>{{ $order3->created_at }}</td>
                                                        <td>
                                                            @if ($order3->order_status == 0)
                                                                <span class="label label-warning">Đang chờ</span>
                                                            @elseif ($order3->order_status == 1)
                                                                <span class="label label-success">Đã xác nhận</span>
                                                            @elseif ($order3->order_status == 2)
                                                                <span class="label label-danger">Đã hủy</span>
                                                            @elseif ($order3->order_status == 3)
                                                                <span class="label label-info">Đã giao hàng</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($order3->order_code != null)
                                                                Có
                                                            @else
                                                                Không có
                                                            @endif
                                                        </td>
                                                        <td>{{ $order3->order_type }}</td>
                                                        <td>
                                                            @if ($order3->order_status == 0)
                                                                <a href="{{ route('cancel', $order3->order_id) }}"
                                                                    class="btn btn-danger">Huy</a>
                                                            @endif
                                                            <a href="{{ route('order.detail', $order3->order_id) }}"
                                                                class="btn btn-primary">Chi tiết</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-content-item " id="cancel">
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
                                                @foreach ($ordersCancel as $order4)
                                                    <tr>
                                                        <td>#{{ $order4->order_id }}</td>
                                                        <td>{{ number_format($order4->price_total, 0, ',', ',') . ' VND' }}
                                                        </td>
                                                        <td>{{ $order4->created_at }}</td>
                                                        <td>
                                                            @if ($order4->order_status == 0)
                                                                <span class="label label-warning">Đang chờ</span>
                                                            @elseif ($order4->order_status == 1)
                                                                <span class="label label-success">Đã xác nhận</span>
                                                            @elseif ($order4->order_status == 2)
                                                                <span class="label label-danger">Đã hủy</span>
                                                            @elseif ($order4->order_status == 3)
                                                                <span class="label label-info">Đã giao hàng</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($order4->order_code != null)
                                                                Có
                                                            @else
                                                                Không có
                                                            @endif
                                                        </td>
                                                        <td>{{ $order4->order_type }}</td>
                                                        <td>
                                                            @if ($order4->order_status == 0)
                                                                <a href="{{ route('cancel', $order4->order_id) }}"
                                                                    class="btn btn-danger">Huy</a>
                                                            @endif
                                                            <a href="{{ route('order.detail', $order4->order_id) }}"
                                                                class="btn btn-primary">Chi tiết</a>
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
            </div>
        </div>
    </div>
</main>
@stop

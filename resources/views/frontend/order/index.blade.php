@extends('layouts.frontend')
@section('content')
@section('title', 'Đơn hàng')
<main id="main" class="main-site left-sidebar">
    <div class="container">
        <div class="background">
            <div class="wrap-breadcrumb">
                <ul>
                    <li class="item-link"><a href="#" class="link">Trang chủ</a></li>
                    <li class="item-link"><span>Đơn hàng</span></li>
                </ul>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 sitebar">
                    <div class="AccountSidebar-avatar">
                        @if (Session::get('user')->avatar == null)
                            <img src="https://file.hstatic.net/1000030244/file/user-mobile_7a2a01b1679d4a45b894f7da50c15bfc.png"
                                alt="">
                        @else
                            @if (Session::get('user')->type == 'Google')
                                <img src="{{ Session::get('user')->avatar }}" alt="">
                            @else
                                <img src="{{ asset('uploads/avatar/' . Session::get('user')->avatar) }}" alt="">
                            @endif
                        @endif

                        <div class="info">
                            Tài khoản của <br>
                            <strong>{{ Session::get('user')->name }}</strong>
                        </div>
                    </div>
                    <div class="AccountSidebar-list">
                        <ul class="list-unstyled">
                            <li>
                                <a href="{{ route('profile') }}" class="account-link">
                                    <i class="fa-solid fa-user" style="color: blue"></i>
                                    <span>Thông tin tài khoản</span>
                                </a>
                            </li>
                            <li style="background-color: rgb(241, 19, 19); font-weight:bold;">
                                <a href="{{ route('order') }}" class="account-link" style="color:white">
                                    <i class="fa-solid fa-certificate" style="color: rgb(241, 151, 16)"></i>
                                    <span>Quản lý đơn hàng</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('address') }}" class="account-link">
                                    <i class="fa-solid fa-location-dot" style="color: red"></i>
                                    <span>Sổ địa chỉ</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('coupon') }}" class="account-link">
                                    <i class="fa-solid fa-gift" style="color: red"></i>
                                    <span>Mã giảm giá </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-10 col-md-9 col-sm-8 col-xs-12 main-content-area">
                    <div class="Account__StyleInfo account">
                        <h1>Đơn hàng của tôi</h1>
                    </div>
                    <div class="card-body">
                        <div class="wrap-product-detail">
                            <div class="advance-info khong-cach">
                                <div class="tab-control normal">
                                    <a href="#orders" class="tab-control-item active">Tất cả đơn hàng</a>
                                    <a href="#wait" class="tab-control-item">Đang chờ duyệt</a>
                                    <a href="#confirmed" class="tab-control-item">Đã xác nhận</a>
                                    <a href="#delivered" class="tab-control-item">Đã giao hàng</a>
                                    <a href="#cancel" class="tab-control-item">Đã hủy</a>
                                </div>
                                <div class="tab-contents">
                                    <div class="tab-content-item active" id="orders">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="myTable" width="100%"
                                                cellspacing="0">
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
                                                    @if (count($orders) > 0)

                                                        @foreach ($orders as $order)
                                                            <tr>
                                                                <td>#{{ $order->order_id }}</td>
                                                                <td>{{ number_format($order->price_total, 0, ',', ',') . 'đ' }}
                                                                </td>
                                                                <td>{{ $order->created_at }}</td>
                                                                <td>
                                                                    @if ($order->order_status == 0)
                                                                        <span class="label label-warning">Đang
                                                                            chờ</span>
                                                                    @elseif ($order->order_status == 1)
                                                                        <span class="label label-success">Đã xác
                                                                            nhận</span>
                                                                    @elseif ($order->order_status == 2)
                                                                        <span class="label label-danger">Đã
                                                                            hủy</span>
                                                                    @elseif ($order->order_status == 3)
                                                                        <span class="label label-info">Đã giao
                                                                            hàng</span>
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
                                                                            class="btn btn-danger btn-sm">Hủy</a>
                                                                    @endif
                                                                    <a href="{{ route('order.detail', $order->order_id) }}"
                                                                        class="btn btn-primary btn-sm">Chi tiết</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="7" style="text-align:center">Không có đơn
                                                                hàng
                                                                nào</td>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-content-item " id="wait">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="myTable" width="100%"
                                                cellspacing="0">
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
                                                    @if (count($ordersWait) > 0)
                                                        @foreach ($ordersWait as $order1)
                                                            <tr>
                                                                <td>#{{ $order1->order_id }}</td>
                                                                <td>{{ number_format($order1->price_total, 0, ',', ',') . 'đ' }}
                                                                </td>
                                                                <td>{{ $order1->created_at }}</td>
                                                                <td>
                                                                    @if ($order1->order_status == 0)
                                                                        <span class="label label-warning">Đang
                                                                            chờ</span>
                                                                    @elseif ($order1->order_status == 1)
                                                                        <span class="label label-success">Đã xác
                                                                            nhận</span>
                                                                    @elseif ($order1->order_status == 2)
                                                                        <span class="label label-danger">Đã hủy</span>
                                                                    @elseif ($order1->order_status == 3)
                                                                        <span class="label label-info">Đã giao
                                                                            hàng</span>
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
                                                                            class="btn btn-danger btn-sm">Hủy</a>
                                                                    @endif
                                                                    <a href="{{ route('order.detail', $order1->order_id) }}"
                                                                        class="btn btn-primary btn-sm">Chi tiết</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="7" style="text-align:center">Không có đơn hàng
                                                                nào</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-content-item " id="confirmed">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="myTable" width="100%"
                                                cellspacing="0">
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
                                                    @if (count($ordersConfirmed) > 0)
                                                        @foreach ($ordersConfirmed as $order2)
                                                            <tr>
                                                                <td>#{{ $order2->order_id }}</td>
                                                                <td>{{ number_format($order2->price_total, 0, ',', ',') . 'đ' }}
                                                                </td>
                                                                <td>{{ $order2->created_at }}</td>
                                                                <td>
                                                                    @if ($order2->order_status == 0)
                                                                        <span class="label label-warning">Đang
                                                                            chờ</span>
                                                                    @elseif ($order2->order_status == 1)
                                                                        <span class="label label-success">Đã xác
                                                                            nhận</span>
                                                                    @elseif ($order2->order_status == 2)
                                                                        <span class="label label-danger">Đã hủy</span>
                                                                    @elseif ($order2->order_status == 3)
                                                                        <span class="label label-info">Đã giao
                                                                            hàng</span>
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
                                                                            class="btn btn-danger btn-sm">Hủy</a>
                                                                    @endif
                                                                    <a href="{{ route('order.detail', $order2->order_id) }}"
                                                                        class="btn btn-primary btn-sm">Chi tiết</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="7" style="text-align:center">Không có đơn hàng
                                                                nào</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-content-item " id="delivered">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="myTable" width="100%"
                                                cellspacing="0">
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
                                                    @if (count($ordersDelivered) > 0)
                                                        @foreach ($ordersDelivered as $order3)
                                                            <tr>
                                                                <td>#{{ $order3->order_id }}</td>
                                                                <td>{{ number_format($order3->price_total, 0, ',', ',') . 'đ' }}
                                                                </td>
                                                                <td>{{ $order3->created_at }}</td>
                                                                <td>
                                                                    @if ($order3->order_status == 0)
                                                                        <span class="label label-warning">Đang
                                                                            chờ</span>
                                                                    @elseif ($order3->order_status == 1)
                                                                        <span class="label label-success">Đã xác
                                                                            nhận</span>
                                                                    @elseif ($order3->order_status == 2)
                                                                        <span class="label label-danger">Đã hủy</span>
                                                                    @elseif ($order3->order_status == 3)
                                                                        <span class="label label-info">Đã giao
                                                                            hàng</span>
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
                                                                            class="btn btn-danger btn-sm">Hủy</a>
                                                                    @endif
                                                                    <a href="{{ route('order.detail', $order3->order_id) }}"
                                                                        class="btn btn-primary btn-sm">Chi tiết</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="7" style="text-align:center">Không có đơn hàng
                                                                nào</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-content-item " id="cancel">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="myTable" width="100%"
                                                cellspacing="0">
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
                                                    @if (count($ordersCancel) > 0)

                                                        @foreach ($ordersCancel as $order4)
                                                            <tr>
                                                                <td>#{{ $order4->order_id }}</td>
                                                                <td>{{ number_format($order4->price_total, 0, ',', ',') . 'đ' }}
                                                                </td>
                                                                <td>{{ $order4->created_at }}</td>
                                                                <td>
                                                                    @if ($order4->order_status == 0)
                                                                        <span class="label label-warning">Đang
                                                                            chờ</span>
                                                                    @elseif ($order4->order_status == 1)
                                                                        <span class="label label-success">Đã xác
                                                                            nhận</span>
                                                                    @elseif ($order4->order_status == 2)
                                                                        <span class="label label-danger">Đã hủy</span>
                                                                    @elseif ($order4->order_status == 3)
                                                                        <span class="label label-info">Đã giao
                                                                            hàng</span>
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
                                                                            class="btn btn-danger btn-sm">Hủy</a>
                                                                    @endif
                                                                    <a href="{{ route('order.detail', $order4->order_id) }}"
                                                                        class="btn btn-primary btn-sm">Chi tiết</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="7" style="text-align:center">Không có đơn hàng
                                                                nào</td>
                                                        </tr>
                                                    @endif
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
    </div>
</main>
<style>
    @media screen and (min-width: 501px) and (max-width:991px) {
        .tab-control-item {
            width: 100% !important;
            text-align: center !important;
            margin: 4px !important;
            border-radius: 4px !important;
        }
    }

</style>
<?php
$success = Session::get('success');
$error = Session::get('error');
if ($success) {
    echo '<script>alert("' . $success . '")</script>';
    Session::forget('success');
}
if ($error) {
    echo '<script>alert("' . $error . '")</script>';
    Session::forget('error');
}
?>
@stop

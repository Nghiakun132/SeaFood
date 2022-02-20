@extends('layouts.frontend')
@section('content')
@section('title', 'Tài khoản')
<main id="main" class="main-site left-sidebar">
    <div class="container">
        <div class="background">
            <div class="wrap-breadcrumb">
                <ul>
                    <li class="item-link"><a href="#" class="link">Trang chủ</a></li>
                    <li class="item-link"><span>Tài khoản của tôi</span></li>
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
                            <li >
                                <a href="{{ route('profile') }}" class="account-link">
                                    <i class="fa-solid fa-user" style="color: blue"></i>
                                    <span>Thông tin tài khoản</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('order') }}" class="account-link">
                                    <i class="fa-solid fa-certificate" style="color: rgb(241, 151, 16)"></i>
                                    <span>Quản lý đơn hàng</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('address')}}" class="account-link">
                                    <i class="fa-solid fa-location-dot" style="color: red"></i>
                                    <span>Sổ địa chỉ</span>
                                </a>
                            </li>
                            <li style="background-color: #ccc">
                                <a href="{{route('coupon')}}" class="account-link">
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
                                    <a href="#orders" class="tab-control-item active">Tất cả mã giảm giá</a>
                                </div>
                                <div class="tab-contents">
                                    <div class="tab-content-item active" id="orders">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="vidu" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>STT</th>
                                                        <th>Mã</th>
                                                        <th>Giảm</th>
                                                        <th>Ngày hết hạn</th>
                                                        {{-- <th>Trạng thái</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1; ?>
                                                    @foreach ($vc as $vc)
                                                        <tr>
                                                            <td>{{$i++ }}</td>
                                                            <td>{{$vc->cou_value * 100 . '%' }}</td>
                                                            <td>{{ $vc->cou_code }}</td>
                                                            <td>{{ $vc->cou_expired_date }}</td>
                                                            {{-- <td>
                                                                {{ $vc->cou_status == 1 ? 'Đã sử dụng' : 'Chưa sử dụng' }}
                                                            </td> --}}
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
    </div>
</main>
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

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
                <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 main-content-area">
                    <div class="Account__StyleInfo account">
                        <h1>Tài khoản của tôi</h1>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="account-manger">
                                <form action="">
                                    <div class="form-group">
                                        <label for="">
                                            <strong>Tên đăng nhập</strong>
                                        </label>
                                        <input type="text" class="form-control" value="{{ $user->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="">
                                            <strong>Email</strong>
                                        </label>
                                        <input type="text" class="form-control" value="{{ $user->email }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="">
                                            <strong>Số điện thoại</strong>
                                        </label>
                                        <input type="text" class="form-control" value="{{ $user->phone }}">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 sitebar">
                    <div class="AccountSidebar-avatar">
                        @if ($user->avatar == null)
                            <img src="https://file.hstatic.net/1000030244/file/user-mobile_7a2a01b1679d4a45b894f7da50c15bfc.png"
                                alt="">
                        @else
                            @if ($user->type == 'Google')
                                <img src="{{ $user->avatar }}" alt="">
                            @else
                                <img src="{{ asset('uploads/avatar/' . $user->avatar) }}" alt="">
                            @endif
                        @endif

                        <div class="info">
                            Tài khoản của <br>
                            <strong>{{ $user->name }}</strong>
                        </div>
                    </div>
                    <div class="AccountSidebar-list">
                        <ul class="list-unstyled">
                            <li style="background-color: #ccc">
                                <a href="" class="account-link">
                                    <i class="fa-solid fa-user"></i>
                                    <span>Thông tin tài khoản</span>
                                </a>
                            </li>
                            <li>
                                <a href="" class="account-link">
                                    <i class="fa-solid fa-certificate"></i>
                                    <span>Quản lý đơn hàng</span>
                                </a>
                            </li>
                            <li>
                                <a href="" class="account-link">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <span>Sổ địa chỉ</span>
                                </a>
                            </li>
                            <li>
                                <a href="" class="account-link">
                                    <i class="fa-solid fa-gift"></i>
                                    <span>Mã giảm giá </span>
                                </a>
                            </li>
                        </ul>
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

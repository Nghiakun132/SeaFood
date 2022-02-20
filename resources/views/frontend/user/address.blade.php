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
                            <li>
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
                            <li style="background-color: #ccc">
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
                        <h1>Tài khoản của tôi</h1>
                    </div>
                    <div>
                        @foreach ($user as $ad)
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="account-manger">
                                        <div class="item address-item">
                                            <div class="view_address">
                                                <div class="info_address">
                                                    <div class="name">
                                                        {{ $ad->name }}
                                                        @if ($ad->isDefault == 1)
                                                            <span class="default-address">
                                                                <i class="fa-solid fa-check-circle"
                                                                    style="color:rgb(255, 15, 135)"></i>
                                                                <span>Địa chỉ mặc định</span>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="address">
                                                        <span>
                                                            Địa chỉ: {{ $ad->address }}
                                                        </span>

                                                    </div>
                                                </div>
                                                <div class="action-address">
                                                    @if ($ad->isDefault == 0)
                                                        <a href="{{ route('setDefault', $ad->id) }}"
                                                            class="btn btn-primary">Đặt là mặc định</a>
                                                        <a href="{{ route('deleteAddress', $ad->id) }}"
                                                            class="btn btn-danger">Xóa</a>
                                                    @else
                                                    @endif
                                                    <a href="{{route('editAddress', $ad->id) }}" class="btn btn-success myBtn2" >Chỉnh sửa</a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="new_address">
                            <a href="#" class="add-address" id="myBtn">Thêm địa chỉ</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>


<div class="container2">
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close"><i class="fa-solid fa-circle-xmark"></i></span>
            <form action="{{ route('addAddress') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="">
                        <strong>Địa chỉ</strong>
                    </label>
                    <input type="text" name="address" class="form-control" placeholder="Nhập địa chỉ">
                </div>
                @if ($errors->has('address'))
                    <div class="alert alert-danger">
                        <strong>{{ $errors->first('address') }}</strong>
                    </div>
                @endif
                <button class="btn btn-primary" type="submit">Thêm địa chỉ</button>
            </form>
        </div>
    </div>
</div>

<script>
    var modal = document.getElementById('myModal');
    var btn = document.getElementById("myBtn");
    var span = document.getElementsByClassName("close")[0];
    btn.onclick = function() {
        modal.style.display = "block";
    }
    span.onclick = function() {
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

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

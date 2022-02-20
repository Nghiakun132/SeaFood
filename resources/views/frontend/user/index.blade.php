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
                            <li style="background-color: #ccc">
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
                            <li>
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
                        <h1>Tài khoản của tôi</h1>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="account-manger">
                                <form action="{{route('postProfile')}}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="">
                                            <strong>Họ tên</strong>
                                        </label>
                                        <input type="text" class="form-control"  name="name" value="{{ $user->name }}">
                                    </div>
                                    @if ($errors->has('name'))
                                    <div class="alert alert-danger">
                                        <strong>{{$errors->first('name')}}</strong>
                                      </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="">
                                            <strong>Email</strong>
                                        </label>
                                        <input type="text" class="form-control" name="email" value="{{ $user->email }}">
                                    </div>
                                    @if ($errors->has('email'))
                                    <div class="alert alert-danger">
                                        <strong>{{$errors->first('email')}}</strong>
                                      </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="">
                                            <strong>Số điện thoại</strong>
                                        </label>
                                        <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
                                    </div>
                                    @if ($errors->has('phone'))
                                    <div class="alert alert-danger">
                                        <strong>{{$errors->first('phone')}}</strong>
                                      </div>
                                    @endif
                                    <button class="btn btn-primary" type="submit">Cập nhật</button>
                                    <a href="#" class="btn btn-danger" id="myBtn">Đổi
                                        mật khẩu</a>
                                </form>

                            </div>
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
            <form action="{{route('changePassword')}}" method="post">
                @csrf
                <div class ="form-group">
                    <label for="">
                        <strong>Mật khẩu cũ</strong>
                    </label>
                    <input type="password" name="old" class="form-control" placeholder="Mật khẩu cũ">
                </div>
                @if ($errors->has('old'))
                <div class="alert alert-danger">
                    <strong>{{$errors->first('old')}}</strong>
                  </div>
                @endif
                <div class ="form-group">
                    <label for="">
                        <strong>Mật khẩu mới</strong>
                    </label>
                    <input type="password" name="new" class="form-control" placeholder="Mật khẩu mới">
                </div>
                @if ($errors->has('new'))
                <div class="alert alert-danger">
                    <strong>{{$errors->first('new')}}</strong>
                  </div>
                @endif
                <div class ="form-group">
                    <label for="">
                        <strong>Nhập lại mật khẩu</strong>
                    </label>
                    <input type="password" name="new_re" class="form-control" placeholder="Nhập lại mật khẩu mới">
                </div>
                @if ($errors->has('new_re'))
                <div class="alert alert-danger">
                    <strong>{{$errors->first('new_re')}}</strong>
                  </div>
                @endif
                <button class="btn btn-primary" type="submit">Đổi mật khẩu</button>
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

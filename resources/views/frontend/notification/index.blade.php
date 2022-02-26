@extends('layouts.frontend')
@section('content')
@section('title', 'Thông báo')
<main id="main" class="main-site left-sidebar">
    <div class="container">
        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="#" class="link">Trang chủ</a></li>
                <li class="item-link"><span>Thông báo</span></li>
            </ul>
        </div>
        <div class="row">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="wrap-product-detail">
                        <div class="advance-info khong-cach">
                            <div class="tab-control normal">
                                <a href="#orders" class="tab-control-item active">Tất cả thông báo</a>
                            </div>
                            <div class="tab-contents">
                                <div class="tab-content-item active" id="orders">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="vidu" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Loại</th>
                                                    <th>Thông báo</th>
                                                    <th>Ngày nhận</th>
                                                    <th>Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($notifications as $notifications)
                                                    <tr>
                                                        <td>{{ $i++ }}</td>
                                                        <td>{{ $notifications->type }}</td>
                                                        <td>{{ $notifications->notification }}</td>
                                                        <td>{{ $notifications->created_at }}</td>
                                                        <td>
                                                            <a href="{{route('deleteNotifications',$notifications->id)}}" class="btn btn-danger">Xóa</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <a href="{{route('deleteAllNotifications')}}"><button class="btn btn-danger">Xóa tất cả</button></a>
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
    echo '<script type="text/javascript">alert("' . $success . '")</script>';
}
if ($error) {
    echo '<script type="text/javascript">alert("' . $error . '")</script>';
}
?>
@stop

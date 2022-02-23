@extends('layouts.backend')
@section('content')
@section('title', 'Chi tiết nhập hàng')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Chi tiết nhập hàng</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $import->ipd_id }}</td>
                            <td>{{ $import->pro_name }}</td>
                            <td>{{ $import->ipd_quantity }}</td>
                            <td>{{ number_format(($import->ipd_price),0,',',','). ' VND'}}</td>
                            <td>{{ number_format(($import->ipd_price * $import->ipd_quantity),0,',',','). ' VND'}}</td>
                        </tr>
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

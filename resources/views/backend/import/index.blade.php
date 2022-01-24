@extends('layouts.backend')
@section('content')
@section('title', 'Sản phẩm')
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Sản phẩm</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Admin</th>
                            <th>Ten sp</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($import as $value)
                        <tr>
                            <td>{{$value->ip_id}}</td>
                            <td>{{$value->ip_admin_id}}</td>
                            <td>{{$value->ip_product_name}}</td>
                            <td>{{$value->ip_price}}</td>
                            <td>{{$value->ip_qty}}</td>
                            <td>{{$value->ip_status}}</td>
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

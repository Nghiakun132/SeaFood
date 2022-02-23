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
                            <th>Người nhập</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Ngày nhập</th>
                            <th>Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($import as $value)
                        <tr>
                            <td>{{$value->ip_id}}</td>
                            <td>{{$value->name}}</td>
                            <td>{{number_format(($value->ip_total),0,',',','). ' VND'}}</td>
                            <td>{{$value->ip_status}}</td>
                            <td>{{$value->created_at}}</td>
                            <td>
                                <a href="{{route('admin.import.detail',$value->ip_id)}}" class="btn btn-primary">Chi tiết</a>
                            </td>
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

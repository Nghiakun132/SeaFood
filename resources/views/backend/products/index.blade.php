@extends('layouts.backend')
@section('content')
@section('title', 'Sản phẩm')
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Sản phẩm</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><a href="{{ route('admin.product.create') }}"
                    class="btn btn-primary">Thêm</a></h6>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Danh mục</th>
                            <th>Avatar</th>
                            <th>Giá</th>
                            <th>Khuyến mãi</th>
                            <th>Số lượng</th>
                            <th>Lượt xem</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $value)
                            <tr>
                                <td>{{ $value->pro_id }}</td>
                                <td>{{ $value->pro_name }}</td>
                                <td>{{ $value->c_name }}</td>
                                <td><img src="{{ asset('./uploads/products/' . $value->pro_avatar) }}" width="100px"
                                        height="100px"></td>
                                <td>{{ number_format($value->pro_price, 0, '.', '.') . 'VND' }}</td>
                                <td>{{ $value->pro_sale * 100 . '%' }}</td>
                                <td>{{ $value->pro_qty }}</td>
                                <td>{{ $value->pro_view }}</td>
                                <td>
                                    @if ($value->pro_status == 0)
                                        <a href="{{ route('admin.product.changeStatus', $value->pro_id) }}"><span
                                                class="badge badge-success">Dang hien thi</span></a>
                                    @else
                                        <a href="{{ route('admin.product.changeStatus', $value->pro_id) }}"><span
                                                class="badge badge-danger">Khong hien thi</span></a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.product.edit', $value->pro_id) }}"
                                        class="btn btn-primary">Sửa</a>
                                    <a href="{{ route('admin.product.destroy', $value->pro_id) }}"
                                        class="btn btn-danger">Xóa</a>

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

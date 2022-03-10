@extends('layouts.backend')
@section('content')
@section('title', 'Giảm giá sản phẩm')
<div class="container-fluid">
    {{-- tao 2 cai nut quay lai --}}
    <div class="row">
    </div>
    <h1 class="h3 mb-2 text-gray-800">Giảm giá sản phẩm</h1>
    <div class="card shadow mb-4">
        {{-- <a href="{{ route('admin.sales.add_product', $id) }}" class="btn btn-primary mb-4">Thêm mới</a> --}}
        {{-- <a href="{{ route('admin.sales.add_product', $id) }}" class="btn btn-primary mb-4">Quay lai</a> --}}
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Tên sản phẩm</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $product->pro_name }}</td>
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
$error = Session::get('error');
if ($success) {
    echo "<script>alert('$success')</script>";
    Session::forget('success');
} elseif ($error) {
    echo "<script>alert('$error')</script>";
    Session::forget('error');
}
?>
@stop

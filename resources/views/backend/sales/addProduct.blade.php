@extends('layouts.backend')
@section('content')
@section('title', 'Giảm giá sản phẩm')
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Giảm giá sản phẩm</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.sales.add_product_post', $id) }}" method="post">
                @csrf
                <div class="table-responsive">
                    <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Tên sản phẩm</td>
                                <td>Hành động</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->pro_id }}</td>
                                    <td>{{ $product->pro_name }}</td>
                                    <td>
                                        <input class="form-control" type="checkbox" name="check[]" value="{{ $product->pro_id }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <button class="btn btn-primary">Them</button>
            </form>
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

@extends('layouts.backend')
@section('content')
@section('title', 'Giảm giá sản phẩm')
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Giảm giá sản phẩm</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            @if ($countSales > 0)
                <h6 class="m-0 font-weight-bold text-primary"><button class="btn btn-primary"
                        onclick="return alert('Sự kiện giảm giá đang diễn ra')">Thêm</button>
                    </button>
                    <a href="{{ route('admin.sales.check') }}"> <button class="btn btn-primary">Check</button></a>
                </h6>
            @else
                <h6 class="m-0 font-weight-bold text-primary"><button class="btn btn-primary" data-toggle="modal"
                        data-target="#exampleModal">Thêm</h6>
            @endif


        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Ngày bắt đầu</td>
                            <td>Ngày kết thúc</td>
                            <td>Giảm giá</td>
                            <td>Trạng thái</td>
                            <td>Hành động</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $sale)
                            <tr>
                                <td>{{ $sale->id }}</td>
                                <td>{{ $sale->time_start }}</td>
                                <td>{{ $sale->time_end }}</td>
                                <td>{{ $sale->sale_percent * 100 . '%' }}</td>
                                <td>
                                    @if ($sale->sale_status == 1)
                                        <a href="{{ route('admin.sales.changeStatus', $sale->id) }}"><span
                                                class="badge badge-success">Đang hoạt động</span></a>
                                    @else
                                        <span class="badge badge-danger">Đã kết thúc</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.sales.destroy', $sale->id) }}"><span
                                            class="badge badge-danger">Xóa</span></a>
                                    @if ($sale->sale_status == 1)
                                        <a href="{{ route('admin.sales.add_product', $sale->id) }}"><span
                                                class="badge badge-success">Thêm sản phẩm</span></a>
                                        <a href="#" data-toggle="modal" data-target="#exampleModal2"><span
                                                class="badge badge-info">Xem sản phẩm</span></a>
                                    @endif
                                </td>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Giảm giá</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.sales.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Ngày bắt đầu</label>
                        <input type="datetime-local" class="form-control" name="time_start" id="exampleInputEmail1"
                            aria-describedby="emailHelp" placeholder="Nhập ngày bắt đầu">
                    </div>
                    @if ($errors->has('time_start'))
                        <div class="alert alert-danger">
                            {{ $errors->first('time_start') }}
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="exampleInputEmail1">Ngày kết thúc</label>
                        <input type="datetime-local" class="form-control" name="time_end" id="exampleInputEmail1"
                            aria-describedby="emailHelp" placeholder="Nhập ngày kết thúc">
                    </div>
                    @if ($errors->has('time_end'))
                        <div class="alert alert-danger">
                            {{ $errors->first('time_end') }}
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="exampleInputEmail1">Giảm giá</label>
                        <input type="text" class="form-control" name="sale_percent" id="exampleInputEmail1"
                            aria-describedby="emailHelp" placeholder="Nhập giảm giá">
                    </div>
                    @if ($errors->has('sale_percent'))
                        <div class="alert alert-danger">
                            {{ $errors->first('sale_percent') }}
                        </div>
                    @endif
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Giảm giá</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
                            @foreach ($productsV2 as $productsV2)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $productsV2->pro_name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

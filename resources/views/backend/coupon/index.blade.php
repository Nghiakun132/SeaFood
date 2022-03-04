@extends('layouts.backend')
@section('content')
@section('title', 'Ma giam gia')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Ma giam gia</h1>
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#myModal">
        Them ma giam gia
    </button>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mã giảm giá</th>
                            <th>Số lượng</th>
                            <th>Giảm ?%</th>
                            <th>Trạng thái</th>
                            <th>Ngày hết hạn</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cp as $cp)
                            <tr>
                                <td>{{ $cp->cou_id }}</td>
                                <td>{{ $cp->cou_code }}</td>
                                <td>{{ $cp->cou_number }}</td>
                                <td>{{ $cp->cou_value * 100 . '%' }}</td>
                                <td>
                                    @if ($cp->cou_status == 0)
                                        <a href="{{ route('admin.coupon.changeStatus', $cp->cou_id) }}"><span
                                                class="badge badge-success">Cho phép sử dụng</span></a>
                                    @else
                                        <a href="{{ route('admin.coupon.changeStatus', $cp->cou_id) }}"><span
                                                class="badge badge-danger">
                                                Không cho phép sử dụng</span></a>
                                    @endif
                                </td>
                                <td>{{ $cp->cou_expired_date }}</td>
                                <td>{{ \Carbon\Carbon::parse($cp->created_at)->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('admin.coupon.destroy', $cp->cou_id) }}"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa không?')"
                                        class="btn btn-danger btn-sm">Xoá</a>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modal Heading</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">So lan</label>
                        <input type="number" class="form-control" name="cou_number">
                    </div>
                    <div class="form-group">
                        <label for="">Ngay het han</label>
                        <input type="date" class="form-control" name="cou_date">
                    </div>
                    <div class="form-group">
                        <label for="">Giam ? %</label>
                        <input type="text" class="form-control" name="cou_value">
                    </div>
                    <button type="submit" class="btn btn-primary">Tao</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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

@extends('layouts.backend')
@section('content')
@section('title', 'Sản phẩm')
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Sản phẩm</h1>
    <a class="btn btn-primary mb-3" href="{{route('admin.notification.destroyAll')}}">Xóa tất cả</a>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Loại</th>
                            <th>Nội dung</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notis as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->type }}</td>
                                <td>{{ $item->notification }}</td>
                                <td>
                                    @if ($item->read == 1)
                                        <span class="badge badge-success">Đã đọc</span>
                                    @else
                                       <a href="{{route('admin.notification.read',$item->id)}}"> <span class="badge badge-danger">Chưa đọc</span></a>
                                    @endif
                                </td>
                                <td>
                                    <a onclick="return confirm('Chắc chưa ??????')" href="{{ route('admin.notification.destroy', $item->id) }}" class="btn btn-danger">Xóa</a>
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
$error = Session::get('error');
if ($success) {
    echo "<script>alert('$success')</script>";
    Session::forget('success');
}
if ($error) {
    echo "<script>alert('$error')</script>";
    Session::forget('error');
}
?>
@stop

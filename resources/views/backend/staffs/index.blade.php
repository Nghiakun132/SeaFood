@extends('layouts.backend')
@section('content')
@section('title', 'Danh sách nhân viên')
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Danh sách nhân viên</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><a href="#" data-toggle="modal" data-target="#myModal"
                    class="btn btn-primary">Thêm</a></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Avatar</th>
                            <th>Chức vụ</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($staff as $staff)
                            <tr>
                                <td>{{ $staff->id }}</td>
                                <td>{{ $staff->name }}</td>
                                <td>{{ $staff->email }}</td>
                                <td>{{ $staff->phone }}</td>
                                <td>
                                    @if ($staff->avatar)
                                        <img src="{{ asset('./uploads/avatar/' . $staff->avatar) }}" alt=""
                                            width="100px">
                                    @else
                                        <img src="{{ asset('./uploads/avatar/default.png') }}" alt="" width="100px">
                                    @endif
                                </td>
                                <td>
                                    @if ($staff->role == 2)
                                        <span class="badge badge-success">Admin</span>
                                    @elseif ($staff->role == 1)
                                        <a href="{{ route('admin.staff.uplevel', $staff->id) }}"
                                            onclick="return confirm('Giáng chức ??')"><span
                                                class="badge badge-success">Quản lý</span></a>
                                    @else
                                        <a href="{{ route('admin.staff.uplevel', $staff->id) }}"
                                            onclick="return confirm('Thăng chức ??')"><span
                                                class="badge badge-primary">Nhân viên</span></a>
                                    @endif
                                </td>
                                <td>{{ $staff->created_at }}</td>
                                <td>
                                    @if ($staff->role != 2)
                                        <a href="{{ route('admin.staff.destroy', $staff->id) }}"
                                            class="btn btn-danger">Xóa</a>
                                    @endif
                                </td>
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
                <h4 class="modal-title">Thêm danh mục</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Tên</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    @if ($errors->has('name'))
                        <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                    @endif
                    <div class="form-group">
                        <label for="">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    @if ($errors->has('phone'))
                        <div class="alert alert-danger">{{ $errors->first('phone') }}</div>
                    @endif
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" name="email" class="form-control">
                    </div>
                    @if ($errors->has('email'))
                        <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                    @endif
                    <button class="btn btn-primary">Thêm</button>
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

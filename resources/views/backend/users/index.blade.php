@extends('layouts.backend')
@section('content')
@section('title', 'Danh sách khách hàng')
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Danh sách khách hàng</h1>
    <div class="card shadow mb-4">
        {{-- <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><a href="#" data-toggle="modal" data-target="#myModal"
                    class="btn btn-primary">Thêm</a></h6>
        </div> --}}
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Trạng thái</th>
                            <th>Đang</th>
                            <th>Loại đăng nhập</th>
                            <th>Avatar</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    {{ $user->id }}
                                </td>
                                <td>
                                    {{ $user->name }}
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    {{ $user->phone }}
                                </td>
                                <td>
                                    @if ($user->block == 0)
                                        <a href="{{route('admin.user.block',$user->id)}}" onclick="return confirm('Khóa tài khoản này ??')">
                                            <span class="badge badge-success">Đang hoạt động</span>
                                        </a>
                                    @else
                                        <a href="{{route('admin.user.block',$user->id)}}" onclick="return confirm('Mở khóa tài khoản này ??')">
                                            <span class="badge badge-danger">Đã bị khóa</span>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->status == 1)
                                        <span class="badge badge-danger">Offline</span>
                                    @else
                                        <span class="badge badge-success">{{ $user->status }}</span>
                                    @endif
                                <td>
                                    {{ $user->type }}
                                </td>
                                <td>
                                    @if ($user->type == 'Google')
                                        <img src="{{ $user->avatar }}" alt="" width="80" height="80">
                                    @else
                                        @if ($user->avatar == null)
                                            <img src="{{ asset('uploads/avatar/default.png') }}" alt="" width="80"
                                                height="80">
                                        @else
                                            <img src="{{ asset('uploads/avatar/' . $user->avatar) }}" alt=""
                                                width="80" height="80">
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.user.destroy', $user->id) }}"
                                        onclick="return confirm('Bạn chắc đã muốn xóa không ??')"
                                        class="btn btn-danger">Xóa</a>
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

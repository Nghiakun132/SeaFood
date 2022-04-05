@extends('layouts.backend')
@section('title', 'Admin')
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-xl-8 col-md-8 mb-4">
                    @csrf
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $admin->name }}">
                    </div>
                    @if ($errors->has('name'))
                        <div class="alert alert-danger">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" class="form-control" name="email" value="{{ $admin->email }}">
                    </div>
                    @if ($errors->has('email'))
                        <div class="alert alert-danger">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="">Phone</label>
                        <input type="text" class="form-control" name="phone" value="{{ $admin->phone }}">
                    </div>
                    <div class="form-group">
                        <label for="">Address</label>
                        <input type="text" class="form-control" name="address" value="{{ $admin->address }}">
                    </div>
                    @if ($admin->birthday != null)
                        <div class="form-group">
                            <label for="">Age</label>
                            <input type="text" class="form-control" placeholder="{{ $age }} tuổi" disabled>
                        </div>
                    @else
                        <div class="form-group">
                            <label for="">Ngay sinh</label>
                            <input type="text" placeholder="vidu: 2000-12-10" class="form-control" name="birthday">
                        </div>
                    @endif
                </div>
                <div class="col-xl-4 col-md-4 mb-4 ">
                    @if ($admin->avatar != null)
                        <div class="card">
                            <div class="card-header bg-success">
                                <div class="role">Chuc vu:
                                    @if ($admin->role == 2)
                                        CEO
                                    @elseif ($admin->role == 1)
                                        Quan ly
                                    @else
                                        Nhan vien
                                    @endif

                                </div>
                            </div>
                            <div class="card-body text-center bg-gradient-light">
                                <img src="{{ '../../uploads/avatar/' . $admin->avatar }}" width="400px"
                                    class="img-thumbnail rounded-circle">
                            </div>
                            <div class="card-footer">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupFileAddon01">Cập nhật ảnh đại
                                            diện</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="avatar" id="inputGroupFile01"
                                            aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label" for="inputGroupFile01">Chọn ảnh</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card">
                            <div class="card-body text-center">
                                <img src="{{ '../../uploads/avatar/default.png' }}" width="400px"
                                    class="img-thumbnail rounded-circle">
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control" name="avatar">
                            </div>
                        </div>
                    @endif
                    <a class="btn btn-primary mt-4" data-toggle="modal" data-target="#myModal">Đổi mật khẩu</a>
                </div>
            </div>
            <button class="btn btn-primary">Cập nhật</button>
        </form>
    </div>


    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Đổi mật khẩu</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.changePassword') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Mật khẩu cũ</label>
                            <input type="password" class="form-control" name="old_password">
                        </div>
                        @if ($errors->has('old_password'))
                            <div class="alert alert-danger">
                                {{ $errors->first('old_password') }}
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="">Mật khẩu mới</label>
                            <input type="password" class="form-control" name="new_password">
                        </div>
                        @if ($errors->has('new_password'))
                            <div class="alert alert-danger">
                                {{ $errors->first('new_password') }}
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="">Nhập lại mật khẩu mới</label>
                            <input type="password" class="form-control" name="re_password">
                        </div>
                        @if ($errors->has('re_password'))
                            <div class="alert alert-danger">
                                {{ $errors->first('re_password') }}
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    $error = Session::get('error');
    $success = Session::get('success');
    if ($error) {
        echo "<script>alert('$error')</script>";
        Session::forget('error');
    }
    if ($success) {
        echo "<script>alert('$success')</script>";
        Session::forget('success');
    }

    ?>
@stop

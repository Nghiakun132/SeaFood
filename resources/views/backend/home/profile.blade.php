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
                    @if ($admin->birthday != NULL)
                        <div class="form-group">
                            <label for="">Age</label>
                            <input type="text" class="form-control"
                                value="{{ \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->year - \Carbon\Carbon::parse($admin->birthday)->year . ' tuoi' }}"
                                name="birthday" disabled>
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
                                        <span class="input-group-text" id="inputGroupFileAddon01">Cap nhat Anh dai
                                            dien</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="avatar" id="inputGroupFile01"
                                            aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label" for="inputGroupFile01">Chon anh</label>
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
                </div>
            </div>
            <button class="btn btn-primary">Cap nhat</button>
        </form>
    </div>
@stop

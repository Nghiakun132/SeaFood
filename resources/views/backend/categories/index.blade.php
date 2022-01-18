@extends('layouts.backend')
@section('content')
@section('title', 'Danh mục')
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Danh mục sản phẩm</h1>
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
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Ngày cập nhật</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->c_id }}</td>
                                <td>{{ $category->c_name }}</td>
                                <td>
                                    @if ($category->c_status == 1)
                                        <a href="{{route('admin.categories.changeStatus', $category->c_id)}}"><span class="badge badge-success">Hiển thị</span></a>
                                    @else
                                        <a href="{{route('admin.categories.changeStatus', $category->c_id)}}"><span class="badge badge-danger">Ẩn</span></a>
                                    @endif
                                <td>{{ $category->created_at }}</td>
                                <td>{{ $category->updated_at }}</td>
                                <td>
                                    <a href="{{ route('admin.categories.edit', $category->c_id) }}"
                                        class="btn btn-primary">Sửa</a>
                                    <a href="{{ route('admin.categories.destroy', $category->c_id) }}"
                                        class="btn btn-danger">Xóa</a>
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
                <form action="{{ route('admin.categories.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Tên</label>
                        <input type="text" name="c_name" class="form-control">
                    </div>
                    @if ($errors->has('c_name'))
                        <div class="alert alert-danger">{{ $errors->first('c_name') }}</div>
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
$success = Session::get('cate_success');
if ($success) {
    echo "<script>alert('$success')</script>";
    Session::forget('cate_success');
}
?>
@stop

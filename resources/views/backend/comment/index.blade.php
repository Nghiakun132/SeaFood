@extends('layouts.backend')
@section('content')
@section('title', 'Quản lý bình luận')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Quản lý bình luận</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Bình luận</th>
                            <th>Sản phẩm</th>
                            <th>Sao đánh giá</th>
                            <th>Ngày tạo</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comments as $comment)
                            <tr>
                                <td>{{ $comment->cm_id }}</td>
                                <td>{{ $comment->name }}</td>
                                <td>{{ $comment->cm_content }}</td>
                                <td><img src="../uploads/products/{{ $comment->pro_avatar }}" alt="" width="80"
                                        height="80"></td>
                                <td>{{ $comment->cm_star }}</td>
                                <td>{{ $comment->created_at }}</td>
                                <td>
                                    @if ($comment->cm_status == 0)
                                       <a href="{{route('admin.comment.changeStatus',$comment->cm_id)}}"> <span class="badge badge-success">Đang hiện thị</span></a>
                                    @else
                                    <a href="{{route('admin.comment.changeStatus',$comment->cm_id)}}"><span class="badge badge-danger">Đang ẩn</span></a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.comment.destroy', $comment->cm_id) }}"
                                        class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </a>
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

@extends('layouts.backend')
@section('content')
@section('title', 'Sửa danh mục')
<div class="container-fluid">

            <h1 class="h3 mb-2 text-gray-800">Danh mục sản phẩm</h1>
            <div class="card shadow mb-4">
                {{-- <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><a href="#" data-toggle="modal" data-target="#myModal"
                            class="btn btn-primary">Thêm</a></h6>
                </div> --}}
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                          <label for="">Tên danh mục</label>
                          <input type="text" name="c_name" value="{{$categories->c_name}}" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label for="">Banner</label>
                            <input type="file" name="c_banner" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Danh mục cha</label>
                            <select name="parent" id="" class="form-control">
                                <option value="0">Danh mục gốc</option>
                                @foreach ($parent as $category)
                                    <option value="{{ $category->c_id }}"
                                        @if ($categories->parent == $category->c_id)
                                            selected
                                        @endif
                                    >{{ $category->c_name }}</option>
                                @endforeach
                            </select>
                        <button class="btn btn-primary mt-4">Sửa</button>
                    </form>
                </div>
            </div>
        </div>
@stop

@extends('layouts.backend')
@section('content')
@section('title', 'Sản phẩm')
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Sản phẩm</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="">Ten</label>
                    <input type="text" name="pro_name" value="{{ $product->pro_name }}" class="form-control">
                </div>
                @if ($errors->has('pro_name'))
                    <div class="alert alert-danger">
                        {{ $errors->first('pro_name') }}
                    </div>
                @endif
                <div class="form-group">
                    <label for="">Danh mục</label>
                    <Select class="form-control" name="pro_category_id">
                        <option value="">Chọn danh mục</option>
                        @foreach ($categories as $categories)
                            <option value="{{ $categories->c_id }}">{{ $categories->c_name }}</option>
                        @endforeach
                    </Select>
                </div>
                @if ($errors->has('pro_category_id'))
                    <div class="alert alert-danger">
                        {{ $errors->first('pro_category_id') }}
                    </div>
                @endif

                <div class="form-group">
                    <label for="">Gia</label>
                    <input type="number" name="pro_price" value="{{ $product->pro_price }}" class="form-control">
                </div>
                @if ($errors->has('pro_price'))
                    <div class="alert alert-danger">
                        {{ $errors->first('pro_price') }}
                    </div>
                @endif
                <div class="form-group">
                    <label for="">Giam gia</label>
                    <input type="text" name="pro_sale" value="{{ $product->pro_sale * 100 }}" class="form-control">
                </div>
                @if ($errors->has('pro_sale'))
                    <div class="alert alert-danger">
                        {{ $errors->first('pro_sale') }}
                    </div>
                @endif
                <div class="form-group">
                    <label for="">So luong</label>
                    <input type="text" name="pro_qty" value="{{ $product->pro_qty }}" class="form-control">
                </div>
                @if ($errors->has('pro_qty'))
                    <div class="alert alert-danger">
                        {{ $errors->first('pro_qty') }}
                    </div>
                @endif
                <div class="form-group">
                    <label for="">Đơn vị tính</label>
                    <input type="text" name="pro_unit" value="{{ $product->pro_unit }}"class="form-control">
                </div>
                @if ($errors->has('pro_unit'))
                    <div class="alert alert-danger">
                        {{ $errors->first('pro_unit') }}
                    </div>
                @endif
                <div class="form-group">
                    <label for="">Mo ta</label>
                    <textarea name="pro_description" id="editor4" cols="30"
                        rows="10">{{ $product->pro_description }}</textarea>
                </div>
                @if ($errors->has('pro_description'))
                    <div class="alert alert-danger">
                        {{ $errors->first('pro_description') }}
                    </div>
                @endif
                <div class="form-group">
                    <label for="">Mô tả ngắn</label>
                    <textarea name="pro_content" id="editor3" cols="30" rows="10">{{$product->pro_content}}</textarea>
                </div>
                @if ($errors->has('pro_content'))
                    <div class="alert alert-danger">
                        {{ $errors->first('pro_content') }}
                    </div>
                @endif
                <div class="form-group">
                    <label for="">Hinh anh</label>
                    <input type="file" name="pro_avatar[]" multiple class="form-control">
                </div>
                @if ($errors->has('pro_avatar'))
                    <div class="alert alert-danger">
                        {{ $errors->first('pro_avatar') }}
                    </div>
                @endif
                <button type="submit" class="btn btn-primary">Them</button>
            </form>
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

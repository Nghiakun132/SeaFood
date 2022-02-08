@extends('layouts.frontend')
@section('content')
@section('title', 'Don hang')
<main id="main" class="main-site left-sidebar">
    <div class="container">
        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="#" class="link">Trang chu</a></li>
                <li class="item-link"><span>Don hang</span></li>
            </ul>
        </div>
        <div class="row">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="vidu" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Giá</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php $i = 1;?>
                                @foreach ($order_detail as $od)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$od->product_name}}</td>
                                    <td>{{$od->product_quantity}}</td>
                                    <td>{{number_format(($od->product_price),0,',',','). ' VND'}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@stop

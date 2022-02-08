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
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="" method="post">
                            @csrf
                            <input type="text" class="form-control " placeholder="Nhap ly do huy" name="reason">
                            <input type="hidden" class="form-control " value="{{$order->order_id}}" name="order_id">
                            <button type="submit" class="btn btn-danger">Huy don hang</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="cart-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>
                                        <p>Tong tien</p>
                                    </th>
                                    <td>
                                        <p>{{$order->price_total}}</p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@stop

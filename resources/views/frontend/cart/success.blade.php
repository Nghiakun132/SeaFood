@extends('layouts.frontend')
@section('content')
    <main id="main" class="main-site">
        <div class="container">
            <div class="wrap-breadcrumb">
                <ul>
                    <li class="item-link"><a href="#" class="link">Trang chủ</a></li>
                    <li class="item-link"><span>Cảm ơn</span></li>
                </ul>
            </div>
        </div>
        <div class="container pb-60">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2>Cảm ơn bạn đã đặt hàng</h2>
                    <p>Chúng tôi sẽ giao hàng cho bạn sớm nhất có thể!!!!!!</p>
                    <a href="{{route('home')}}" class="btn btn-submit btn-submitx">Tiếp tục mua hàng</a>
                </div>
            </div>
        </div>
    </main>

@stop

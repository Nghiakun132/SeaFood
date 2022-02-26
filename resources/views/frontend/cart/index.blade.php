@extends('layouts.frontend')
@section('content')
@section('title', 'Giỏ hàng')

<main id="main" class="main-site">
    <div class="container">
        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="{{route('home')}}" class="link">Trang chủ</a></li>
                <li class="item-link"><span>Giỏ hàng</span></li>
            </ul>
        </div>
        <div class=" main-content-area">
            <div class="wrap-iten-in-cart">
                <h3 class="box-title">Tên</h3>
                <ul class="products-cart">
                    @foreach ($cart as $cart)
                        <form action="{{ route('updateCart', $cart->cart_id) }}" method="post">
                            @csrf
                            <li class="pr-cart-item">
                                <div class="product-image">
                                    <figure><img src="./uploads/products/{{ $cart->cart_product_image }}" alt="">
                                    </figure>
                                </div>
                                <div class="product-name">
                                    <a class="link-to-product"
                                        href="{{ route('detail', Str::slug($cart->pro_name)) }}">{{ $cart->pro_name }}</a>
                                </div>
                                <div class="price-field produtc-price">
                                    <p class="price">
                                        {{ number_format($cart->cart_product_price, 0, ',', ',') . ' VND' }}</p>
                                </div>
                                <div class="quantity">
                                    <div class="quantity-input">
                                        <input type="text" name="product_quatity"
                                            value="{{ $cart->cart_product_quantity }}" data-max="{{$cart->pro_qty + $cart->cart_product_quantity}}"
                                            pattern="[0-9]*">
                                        <a class="btn btn-increase" href="#"></a>
                                        <a class="btn btn-reduce" href="#"></a>
                                    </div>
                                </div>
                                <input type="hidden" value="{{ $cart->cart_id }}" name="cart_id">
                                <div class="price-field sub-total">
                                    <p class="price">
                                        {{ number_format($cart->cart_product_total, 0, ',', ',') . ' VND' }}
                                </div>

                                <div class="delete">
                                    <button class="btn btn-delete2" title="">
                                        <span>Cập nhật</span>
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </div>

                                <div class="delete">
                                    <a href="{{ Route('deleteCart', $cart->cart_id) }}" class="btn btn-delete2"
                                        title="">
                                        <span>Xóa</span>
                                        <i class="fa fa-times-circle" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </li>
                        </form>
                    @endforeach
                </ul>
            </div>
            <div class="summary">
                <div class="order-summary">
                    <h4 class="title-box">Đơn hàng</h4>
                    <p class="summary-info"><span class="title">Tạm tính</span><b
                            class="index">{{ number_format($total, 0, ',', ',') . ' VND' }}</b></p>
                    <p class="summary-info"><span class="title">Phí vận chuyển</span><b class="index">Miễn phí</b></p>
                    <p class="summary-info total-info "><span class="title">Thành tiền</span><b
                            class="index">{{ number_format($total, 0, ',', ',') . ' VND' }}</b></p>
                </div>
                <div class="checkout-info">
                    @if ($countCart > 0)
                    <a class="btn btn-checkout" href="{{ route('checkout') }}">Check out</a>
                    @else
                    <a class="btn btn-checkout" id="disabled_btn" disabled href="#" onclick="return alert('Giỏ hàng đang rỗng, Hãy thêm gì đó vào giỏ hang !!!')">Check out</a>
                    @endif
                </div>
                <div class="update-clear">
                    <a class="btn btn-clear" href="{{ route('home') }}" >Tiếp tục mua hàng<i
                            class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
                    <a class="btn btn-clear"  href="{{ route('clearCart') }}">Xóa tất cả <i class="fa fa-trash-o" aria-hidden="true"></i></a>
                </div>
            </div>

            <div class="wrap-show-advance-info-box style-1 box-in-site">
                <h3 class="title-box">Sản phẩm nhiều lượt xem nhất</h3>
                <div class="wrap-products">
                    <div class="products slide-carousel owl-carousel style-nav-1 equal-container" data-items="5"
                        data-loop="false" data-nav="true" data-dots="false"
                        data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"3"},"1200":{"items":"5"}}'>
                        @foreach ($mostView as $mostView)
                        <div class="product product-style-2 equal-elem ">
                            <div class="product-thumnail">
                                <a href="{{route('detail',$mostView->pro_slug)}}" title="{{$mostView->pro_name}}">
                                    <figure><img src="uploads/products/{{$mostView->pro_avatar}}" width="214" height="214"
                                            alt="{{$mostView->pro_name}}">
                                    </figure>
                                </a>
                                <div class="group-flash">
                                    <span class="flash-item new-label" style="background-color: red">hot</span>
                                </div>
                                <div class="wrap-btn">
                                    <a href="{{route('detail',$mostView->pro_slug)}}" class="function-link">quick view</a>
                                </div>
                            </div>
                            <div class="product-info">
                                <a href="{{route('detail',$mostView->pro_slug)}}" class="product-name"><span>{{$mostView->pro_name}}</span></a>
                                <div class="wrap-price"><span class="product-price">{{number_format($mostView->pro_price- ($mostView->pro_price*$mostView->pro_sale), 0, ',', ',') . ' VND' }}</span></div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
$success = Session::get('success');
$error = Session::get('error');
if ($success) {
    echo '<script>alert("' . $success . '")</script>';
    Session::forget('success');
} elseif ($error) {
    echo '<script>alert("' . $error . '")</script>';
    Session::forget('error');
}
?>

@stop

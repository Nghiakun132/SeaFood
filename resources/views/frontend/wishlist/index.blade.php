@extends('layouts.frontend')
@section('title', 'Danh sách sản phẩm yêu thích')
@section('content')
<style>
    .add-to-cart{
        border-radius: 25px !important;
    }
</style>
    <main id="main" class="main-site left-sidebar">
        <div class="container">
            <div class="wrap-breadcrumb">
                <ul>
                    <li class="item-link"><a href="{{route('home')}}" class="link">Trang chủ</a></li>
                    <li class="item-link"><span>Danh sách sản phẩm yêu thích</span></li>
                </ul>
            </div>
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 main-content-area">
                    <div class="banner-shop">
                        <a href="#" class="banner-link">
                            <figure><img src="../frontend/images/shop-banner.jpg" alt=""></figure>
                        </a>
                    </div>
                    <div class="wrap-shop-control">
                        <h1 class="shop-title">Danh sách sản phẩm yêu thích</h1>
                        <div class="wrap-right">
                            <div class="change-display-mode">
                                <a href="{{route('deleteAllWishlist')}}" class="grid-mode display-mode active">Xóa tất cả</a>
                                {{-- <a href="#" class="grid-mode display-mode active"><i class="fa fa-th"></i>Grid</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <ul class="product-list grid-products equal-container">
                            @foreach ($products as $value)
                                <li class="col-lg-4 col-md-6 col-sm-6 col-xs-6 ">
                                    <div class="product product-style-3 equal-elem ">
                                        <div class="product-thumnail">
                                            <a href="{{ route('detail', $value->pro_slug) }}"
                                                title="">
                                                <figure><img src="{{ asset('./uploads/products/' . $value->pro_avatar) }}"
                                                        alt="{{ $value->pro_name }}"></figure>
                                            </a>
                                        </div>
                                        <div class="product-info">
                                            <a href="{{ route('detail', $value->pro_slug) }}"
                                                class="product-name"><span>{{ $value->pro_name }}</span></a>
                                            <div class="wrap-price"><span
                                                    class="product-price">{{ number_format(($value->pro_price - ($value->pro_price * $value->pro_sale)),0,',',','). ' VND'}}</span></div>
                                            @if ($value->pro_qty > 0)
                                            <a href="{{ route('quickAddCart', $value->pro_slug) }}"
                                                class="btn add-to-cart">Thêm vào giỏ hàng</a>
                                            @else
                                            <a href="#"
                                                class="btn add-to-cart" disabled="disabled">Hết hàng</a>
                                            @endif

                                                <a href="{{route('deleteWishlist', $value->pro_id)}}"
                                                    class="btn add-to-cart">Xóa</a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="wrap-pagination-info">
                        {{ $products->links() }}
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 sitebar">
                    <div class="widget mercado-widget categories-widget">
                        <h2 class="widget-title">Danh mục</h2>
                        <div class="widget-content">
                            <ul class="list-category">
                                @foreach ($categoryGlobal as $cate)
                                <li class="category-item">
                                    <a href="#" class="cate-link">{{$cate->c_name}}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    {{-- <div class="widget mercado-widget widget-product">
                        <h2 class="widget-title">Popular Products</h2>
                        <div class="widget-content">
                            <ul class="products">
                                <li class="product-item">
                                    <div class="product product-widget-style">
                                        <div class="thumbnnail">
                                            <a href="detail.html"
                                                title="Radiant-360 R6 Wireless Omnidirectional Speaker [White]">
                                                <figure><img src="assets/images/products/digital_01.jpg" alt=""></figure>
                                            </a>
                                        </div>
                                        <div class="product-info">
                                            <a href="#" class="product-name"><span>Radiant-360 R6 Wireless
                                                    Omnidirectional Speaker...</span></a>
                                            <div class="wrap-price"><span class="product-price">$168.00</span></div>
                                        </div>
                                    </div>
                                </li>

                                <li class="product-item">
                                    <div class="product product-widget-style">
                                        <div class="thumbnnail">
                                            <a href="detail.html"
                                                title="Radiant-360 R6 Wireless Omnidirectional Speaker [White]">
                                                <figure><img src="assets/images/products/digital_17.jpg" alt=""></figure>
                                            </a>
                                        </div>
                                        <div class="product-info">
                                            <a href="#" class="product-name"><span>Radiant-360 R6 Wireless
                                                    Omnidirectional Speaker...</span></a>
                                            <div class="wrap-price"><span class="product-price">$168.00</span></div>
                                        </div>
                                    </div>
                                </li>

                                <li class="product-item">
                                    <div class="product product-widget-style">
                                        <div class="thumbnnail">
                                            <a href="detail.html"
                                                title="Radiant-360 R6 Wireless Omnidirectional Speaker [White]">
                                                <figure><img src="assets/images/products/digital_18.jpg" alt=""></figure>
                                            </a>
                                        </div>
                                        <div class="product-info">
                                            <a href="#" class="product-name"><span>Radiant-360 R6 Wireless
                                                    Omnidirectional Speaker...</span></a>
                                            <div class="wrap-price"><span class="product-price">$168.00</span></div>
                                        </div>
                                    </div>
                                </li>

                                <li class="product-item">
                                    <div class="product product-widget-style">
                                        <div class="thumbnnail">
                                            <a href="detail.html"
                                                title="Radiant-360 R6 Wireless Omnidirectional Speaker [White]">
                                                <figure><img src="assets/images/products/digital_20.jpg" alt=""></figure>
                                            </a>
                                        </div>
                                        <div class="product-info">
                                            <a href="#" class="product-name"><span>Radiant-360 R6 Wireless
                                                    Omnidirectional Speaker...</span></a>
                                            <div class="wrap-price"><span class="product-price">$168.00</span></div>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div> --}}

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
    }
    if ($error) {
        echo '<script>alert("' . $error . '")</script>';
        Session::forget('error');
    }
    ?>
@stop

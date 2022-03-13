@extends('layouts.frontend')
@section('content')
@section('title', 'Trang chủ')
<style>
    .style-nav-1 .owl-nav button i{
        font-family: 'FontAwesome' !important;
    }
    .style-nav-1 .owl-nav button:hover{
        background-color: red !important;
    }
</style>
<main id="main">
    <div class="container">
        <div class="wrap-main-slide">
            <div class="slide-carousel owl-carousel style-nav-1" data-items="1" data-loop="1" data-nav="true"
                data-dots="false">
                <div class="item-slide">
                    <img src="{{ asset('frontend/images/slide_4.jpg') }}" alt="" class="img-slide">
                    {{-- <div class="slide-info slide-1">
                        <h2 class="f-title">Kid Smart <b>Watches</b></h2>
                        <span class="subtitle">Compra todos tus productos Smart por internet.</span>
                        <p class="sale-info">Only price: <span class="price">$59.99</span></p>
                        <a href="#" class="btn-link">Shop Now</a>
                    </div> --}}
                </div>
                <div class="item-slide">
                    <img src="{{ asset('frontend/images/slide_5.jpg') }}" alt="" class="img-slide">
                    {{-- <div class="slide-info slide-2">
                        <h2 class="f-title">Extra 25% Off</h2>
                        <span class="f-subtitle">On online payments</span>
                        <p class="discount-code">Use Code: #FA6868</p>
                        <h4 class="s-title">Get Free</h4>
                        <p class="s-subtitle">TRansparent Bra Straps</p>
                    </div> --}}
                </div>
                <div class="item-slide">
                    <img src="{{ asset('frontend/images/slide_3.jpg') }}" alt="" class="img-slide">
                    {{-- <div class="slide-info slide-3">
                        <h2 class="f-title">Great Range of <b>Exclusive Furniture Packages</b></h2>
                        <span class="f-subtitle">Exclusive Furniture Packages to Suit every need.</span>
                        <p class="sale-info">Stating at: <b class="price">$225.00</b></p>
                        <a href="#" class="btn-link">Shop Now</a>
                    </div> --}}
                </div>
            </div>
        </div>

        <!--BANNER-->
        <div class="wrap-banner style-twin-default">
            <div class="banner-item">
                <a href="#" class="link-banner banner-effect-1">
                    <figure><img src="{{ asset('frontend/images/banner_1.jpg') }}" alt="" width="580" height="190">
                    </figure>
                </a>
            </div>
            <div class="banner-item">
                <a href="#" class="link-banner banner-effect-1">
                    <figure><img src="{{ asset('frontend/images/banner_2.jpg') }}" alt="" width="580" height="190">
                    </figure>
                </a>
            </div>
        </div>

        <!--On Sale-->
        @if ($timestamp != null)
            <div class="wrap-show-advance-info-box style-1 has-countdown">
                <h3 class="title-box">On Sale</h3>
                <div class="wrap-countdown mercado-countdown" data-expire="{{ $timestamp }}"></div>
                <div class="wrap-products slide-carousel owl-carousel style-nav-1 equal-container " data-items="5"
                    data-loop="false" data-nav="true" data-dots="false"
                    data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"4"},"1200":{"items":"5"}}'>
                    @foreach ($sales as $productDiscount)
                        <div class="product product-style-2 equal-elem ">
                            <div class="product-thumnail">
                                <a href="{{ route('detail', $productDiscount->pro_slug) }}"
                                    title="{{ $productDiscount->pro_name }}">
                                    <figure><img src="{{ getImageProduct($productDiscount->pro_avatar) }}" width="800"
                                            height="800" alt="{{ $productDiscount->pro_name }}"></figure>
                                </a>
                                <div class="group-flash">
                                    <span
                                        class="flash-item sale-label">{{ $productDiscount->sale_percent * 100 . '%' }}</span>
                                </div>
                                <div class="wrap-btn">
                                    <a href="{{ route('detail', $productDiscount->pro_slug) }}"
                                        class="function-link">quick view</a>
                                </div>
                            </div>
                            <div class="product-info">
                                <a href="{{ route('detail', $productDiscount->pro_slug) }}"
                                    class="product-name"><span>{{ $productDiscount->pro_name }}</span></a>
                                <div class="wrap-price"><span
                                        class="product-price">{{ number_format($productDiscount->pro_price - $productDiscount->pro_price * $productDiscount->sale_percent,0,',','.') .'/ ' .$productDiscount->pro_unit }}</span>
                                </div>
                                @if ($productDiscount->pro_sale > 0)
                                    <div class="wrap-price"><span class="product-price"
                                            style="text-decoration:line-through !important;color:red">{{ number_format($productDiscount->pro_price) . ' VND' }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        @endif


        <!--Latest Products-->
        <div class="wrap-show-advance-info-box style-1">
            <h3 class="title-box">Sản phẩm mới nhất</h3>
            <div class="wrap-products">
                <div class="wrap-product-tab tab-style-1">
                    <div class="tab-contents">
                        <div class="tab-content-item active" id="digital_1a">
                            <div class="wrap-products slide-carousel owl-carousel style-nav-1 equal-container"
                                data-items="5" data-loop="false" data-nav="true" data-dots="false"
                                data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"4"},"1200":{"items":"5"}}'>
                                @foreach ($productsLatest as $value)
                                    <div class="product product-style-2 equal-elem ">
                                        <div class="product-thumnail">
                                            <a href="{{ route('detail', $value->pro_slug) }}"
                                                title="{{ $value->pro_name }}">
                                                <figure><img
                                                        src="{{ asset('uploads/products/' . $value->pro_avatar) }}"
                                                        width="220px" height="220px" alt="{{ $value->pro_name }}">
                                                </figure>
                                            </a>
                                            <div class="group-flash">
                                                <span class="flash-item new-label new_animation">new</span>
                                            </div>
                                            {{-- @if ($value->pro_sale > 0)
                                                <div class="group-flash">
                                                    <span
                                                        class="flash-item sale-label" style="float: right;">{{ $value->pro_sale * 100 . '%' }}</span>
                                                </div>
                                            @endif --}}

                                            <div class="wrap-btn">
                                                <a href="{{ route('detail', $value->pro_slug) }}"
                                                    class="function-link">quick view</a>
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <a href="{{ route('detail', $value->pro_slug) }}"
                                                class="product-name"><span>{{ $value->pro_name }}</span></a>
                                            <div class="wrap-price"><span
                                                    class="product-price">{{ number_format($value->pro_price - $value->pro_price * $value->pro_sale, 0, ',', '.') .' VND' .'/ ' .$value->pro_unit }}</span>
                                            </div>
                                            @if ($value->pro_sale > 0)
                                                <div class="wrap-price"><span class="product-price"
                                                        style="text-decoration:line-through !important;color:red">{{ number_format($value->pro_price) . ' VND' }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wrap-show-advance-info-box style-1">
            <h3 class="title-box">Bán chạy nhất</h3>
            {{-- <div class="wrap-top-banner">
                <a href="#" class="link-banner banner-effect-2">
                    <figure><img src="{{ asset('frontend/images/digital-electronic-banner.jpg') }}" width="1170"
                            height="240" alt=""></figure>
                </a>
            </div> --}}
            <div class="wrap-products">
                <div class="wrap-product-tab tab-style-1">
                    <div class="tab-contents">
                        <div class="tab-content-item active" id="digital_1a">
                            <div class="wrap-products slide-carousel owl-carousel style-nav-1 equal-container"
                                data-items="5" data-loop="false" data-nav="true" data-dots="false"
                                data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"4"},"1200":{"items":"5"}}'>
                                @foreach ($pro_sale_arr as $arr)
                                    <div class="product product-style-2 equal-elem ">
                                        <div class="product-thumnail">
                                            <a href="{{ route('detail', $arr['pro_slug']) }}"
                                                title="{{ $arr['pro_name'] }}">
                                                <figure><img
                                                        src="{{ asset('uploads/products/' . $arr['pro_avatar']) }}"
                                                        width="800" height="800" alt="{{ $arr['pro_name'] }}">
                                                </figure>
                                            </a>
                                            @if ($arr['pro_sale'] > 0)
                                                <div class="group-flash">
                                                    <span class="flash-item new-label"
                                                        style="background-color:red">{{ $arr['pro_sale'] * 100 . '%' }}</span>
                                                </div>
                                            @endif

                                            <div class="wrap-btn">
                                                <a href="{{ route('detail', $arr['pro_slug']) }}"
                                                    class="function-link">quick view</a>
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <a href="{{ route('detail', $arr['pro_slug']) }}"
                                                class="product-name"><span>{{ $arr['pro_name'] }}</span></a>
                                            <div class="wrap-price"><span
                                                    class="product-price">{{ number_format($arr['pro_price'] - $arr['pro_price'] * $arr['pro_sale'], 0, ',', ',') .' VND' .'/ ' .$arr['pro_unit'] }}</span>
                                            </div>
                                            @if ($arr['pro_sale'] > 0)
                                                <div class="wrap-price"><span class="product-price"
                                                        style="text-decoration:line-through !important;color:red">{{ number_format($arr['pro_price']) . ' VND' }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="wrap-show-advance-info-box style-1">
            <h3 class="title-box">Đang giảm giá</h3>
            <div class="wrap-products">
                <div class="wrap-product-tab tab-style-1">
                    <div class="tab-contents">
                        <div class="tab-content-item active" id="digital_1a">
                            <div class="wrap-products slide-carousel owl-carousel style-nav-1 equal-container"
                                data-items="5" data-loop="false" data-nav="true" data-dots="false"
                                data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"4"},"1200":{"items":"5"}}'>
                                @foreach ($productsDiscount as $productsDiscount)
                                    <div class="product product-style-2 equal-elem ">
                                        <div class="product-thumnail">
                                            <a href="{{ route('detail', $productsDiscount->pro_slug) }}"
                                                title="{{ $productsDiscount->pro_name }}">
                                                <figure><img
                                                        src="{{ asset('uploads/products/' . $productsDiscount->pro_avatar) }}"
                                                        width="800" height="800"
                                                        alt="{{ $productsDiscount->pro_name }}"></figure>
                                            </a>
                                            @if ($productsDiscount->pro_sale > 0)
                                                <div class="group-flash">
                                                    <span
                                                        class="flash-item sale-label">{{ $productsDiscount->pro_sale * 100 . '%' }}</span>
                                                </div>
                                            @endif
                                            <div class="wrap-btn">
                                                <a href="#" class="function-link">quick view</a>
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <a href="#"
                                                class="product-name"><span>{{ $productsDiscount->pro_name }}</span></a>
                                            <div class="wrap-price"><span
                                                    class="product-price">{{ number_format($productsDiscount->pro_price - $productsDiscount->pro_price * $productsDiscount->pro_sale, 0, ',', '.') . ' VND' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="wrap-show-advance-info-box style-1">
            <h3 class="title-box">Nhiều lượt xem nhất</h3>
            {{-- <div class="wrap-top-banner">
                <a href="#" class="link-banner banner-effect-2">
                    <figure><img src="{{ asset('frontend/images/digital-electronic-banner.jpg') }}" width="1170"
                            height="240" alt=""></figure>
                </a>
            </div> --}}
            <div class="wrap-products">
                <div class="wrap-product-tab tab-style-1">
                    <div class="tab-contents">
                        <div class="tab-content-item active" id="digital_1a">
                            <div class="wrap-products slide-carousel owl-carousel style-nav-1 equal-container"
                                data-items="5" data-loop="false" data-nav="true" data-dots="false"
                                data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"4"},"1200":{"items":"5"}}'>
                                @foreach ($productsView as $productsView)
                                    <div class="product product-style-2 equal-elem ">
                                        <div class="product-thumnail">
                                            <a href="{{ route('detail', $productsView->pro_slug) }}"
                                                title="{{ $productsView->pro_name }}">
                                                <figure><img
                                                        src="{{ asset('uploads/products/' . $productsView->pro_avatar) }}"
                                                        width="800" height="800" alt="{{ $productsView->pro_name }}">
                                                </figure>
                                            </a>
                                            @if ($productsView->pro_sale > 0)
                                                <div class="group-flash">
                                                    <span
                                                        class="flash-item sale-label">{{ $productsView->pro_sale * 100 . '%' }}</span>
                                                </div>
                                            @endif
                                            <div class="wrap-btn">
                                                <a href="#" class="function-link">quick view</a>
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <a href="#"
                                                class="product-name"><span>{{ $productsView->pro_name }}</span></a>
                                            <div class="wrap-price"><span
                                                    class="product-price">{{ number_format($productsView->pro_price - $productsView->pro_price * $productsView->pro_sale, 0, ',', '.') .' VND' .'/ ' .$productsView->pro_unit }}</span>
                                            </div>
                                            @if ($productsView->pro_sale > 0)
                                                <div class="wrap-price"><span class="product-price"
                                                        style="text-decoration:line-through !important;color:red">{{ number_format($productsView->pro_price) . ' VND' }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
</main>
<?php
$error = Session::get('error');
if ($error) {
    echo "<script>alert('$error')</script>";
    Session::forget('error');
}
?>
<style>
    @keyframes fadeIn {
        from {
            transform: rotate(0deg);
            background-color: rgb(141, 36, 36);
        }

        to {
            transform: rotate(360deg);
            background-color: red;
        }
    }

    .new_animation {
        animation: fadeIn 1s ease infinite;
    }

    .product-name:hover span {
        font-weight: bold;
        color: green !important;
    }

</style>

@stop

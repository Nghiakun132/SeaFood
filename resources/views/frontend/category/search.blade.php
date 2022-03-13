@extends('layouts.frontend')
@section('title', 'Tìm kiếm')
@section('content')
    <main id="main" class="main-site left-sidebar">
        <div class="container">
            <div class="wrap-breadcrumb ">
                <ul>
                    <li class="item-link"><a href="{{ route('home') }}" class="link">Trang chủ</a></li>
                    <li class="item-link"><span>Tìm kiếm</span></li>
                </ul>
            </div>
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-xs-12 main-content-area">
                    <div class="wrap-shop-control">
                        <h1 class="shop-title">Tim kiem</h1>
                    </div>
                    <div class="row">
                        <ul class="product-list grid-products equal-container">
                            @if (count($products) > 0)
                                @foreach ($products as $value)
                                    <li class="col-lg-4 col-md-6 col-sm-6 col-xs-6 ">
                                        <div class="product product-style-3 equal-elem ">
                                            <div class="product-thumnail">
                                                <a href="{{ route('detail', $value->pro_slug) }}"
                                                    title="T-Shirt Raw Hem Organic Boro Constrast Denim">
                                                    <figure><img
                                                            src="{{ asset('./uploads/products/' . $value->pro_avatar) }}"
                                                            alt=""></figure>
                                                </a>
                                            </div>
                                            <div class="product-info">
                                                <a href="{{ route('detail', $value->pro_slug) }}"
                                                    class="product-name"><span>{{ $value->pro_name }}</span></a>
                                                <div class="wrap-price"><span
                                                        class="product-price">{{ number_format($value->pro_price - $value->pro_price * $value->pro_sale, 0, ',', ',') . ' VND' }}</span>
                                                    @if ($value->pro_sale > 0)
                                                        <span class="product-price"
                                                            style="color:red;text-decoration:line-through">{{ number_format($value->pro_price, 0, ',', ',') . ' VND' }}</span>
                                                    @endif
                                                </div>
                                                @if ($value->pro_qty > 0)
                                                    <a href="{{ route('quickAddCart', $value->pro_slug) }}"
                                                        class="btn add-to-cart">Thêm
                                                        vào giỏ hàng</a>
                                                @else
                                                    <a href="#" class="btn add-to-cart">Hết hàng</a>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <div class="alert alert-danger">Không tìm thấy sản phẩm nào</div>
                            @endif
                        </ul>
                    </div>
                    <div class="wrap-pagination-info">
                        {{ $products->links() }}
                    </div>
                </div>

                {{-- <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 sitebar">
                    <div class="widget mercado-widget filter-widget brand-widget">
                        <h2 class="widget-title">Brand</h2>
                        <div class="widget-content">
                            <ul class="list-style vertical-list list-limited" data-show="6">
                                <li class="list-item"><a class="filter-link active" href="#">Fashion Clothings</a>
                                </li>
                                <li class="list-item"><a class="filter-link " href="#">Laptop Batteries</a></li>
                                <li class="list-item"><a class="filter-link " href="#">Printer & Ink</a></li>
                                <li class="list-item"><a class="filter-link " href="#">CPUs & Prosecsors</a></li>
                                <li class="list-item"><a class="filter-link " href="#">Sound & Speaker</a></li>
                                <li class="list-item"><a class="filter-link " href="#">Shop Smartphone &
                                        Tablets</a></li>
                                <li class="list-item default-hiden"><a class="filter-link " href="#">Printer & Ink</a>
                                </li>
                                <li class="list-item default-hiden"><a class="filter-link " href="#">CPUs &
                                        Prosecsors</a></li>
                                <li class="list-item default-hiden"><a class="filter-link " href="#">Sound & Speaker</a>
                                </li>
                                <li class="list-item default-hiden"><a class="filter-link " href="#">Shop Smartphone &
                                        Tablets</a></li>
                                <li class="list-item"><a
                                        data-label='Show less<i class="fa fa-angle-up" aria-hidden="true"></i>'
                                        class="btn-control control-show-more" href="#">Show more<i class="fa fa-angle-down"
                                            aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div><!-- brand widget-->

                    <div class="widget mercado-widget filter-widget price-filter">
                        <h2 class="widget-title">Price</h2>
                        <form action="#" method="get">
                        <div class="widget-content">
                            <div id="slider-range"></div>
                            <p>
                                <label for="amount">Giá: </label>
                                <input type="text" id="amount" readonly name="price">
                                <button class="filter-submit" type="submit">Filter</button>
                            </p>
                        </div>
                    </form>
                    </div><!-- Price-->

                    <div class="widget mercado-widget filter-widget">
                        <h2 class="widget-title">Color</h2>
                        <div class="widget-content">
                            <ul class="list-style vertical-list has-count-index">
                                <li class="list-item"><a class="filter-link " href="#">Red <span>(217)</span></a>
                                </li>
                                <li class="list-item"><a class="filter-link " href="#">Yellow
                                        <span>(179)</span></a></li>
                                <li class="list-item"><a class="filter-link " href="#">Black <span>(79)</span></a>
                                </li>
                                <li class="list-item"><a class="filter-link " href="#">Blue <span>(283)</span></a>
                                </li>
                                <li class="list-item"><a class="filter-link " href="#">Grey <span>(116)</span></a>
                                </li>
                                <li class="list-item"><a class="filter-link " href="#">Pink <span>(29)</span></a>
                                </li>
                            </ul>
                        </div>
                    </div><!-- Color -->

                    <div class="widget mercado-widget filter-widget">
                        <h2 class="widget-title">Size</h2>
                        <div class="widget-content">
                            <ul class="list-style inline-round ">
                                <li class="list-item"><a class="filter-link active" href="#">s</a></li>
                                <li class="list-item"><a class="filter-link " href="#">M</a></li>
                                <li class="list-item"><a class="filter-link " href="#">l</a></li>
                                <li class="list-item"><a class="filter-link " href="#">xl</a></li>
                            </ul>
                            <div class="widget-banner">
                                <figure><img src="assets/images/size-banner-widget.jpg" width="270" height="331" alt="">
                                </figure>
                            </div>
                        </div>
                    </div><!-- Size -->

                    <div class="widget mercado-widget widget-product">
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
                    </div>

                </div> --}}
            </div>
        </div>
    </main>
    <script>
        $(document).ready(function() {
            $('#sort_by').change(function() {
                var sort_by = $(this).val();
                window.location.href += '?sort_by=' + sort_by;
            })
        });
    </script>
@stop

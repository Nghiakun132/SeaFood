@extends('layouts.frontend')
@section('content')
    <main id="main" class="main-site left-sidebar">
        <div class="container">
            <div class="wrap-breadcrumb">
                <ul>
                    <li class="item-link"><a href="#" class="link">Trang chu</a></li>
                    {{-- <li class="item-link"><span>{{ $cate->c_name }}</span></li> --}}
                </ul>
            </div>
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 main-content-area">
                    <div class="banner-shop">
                        <a href="#" class="banner-link">
                            <figure><img src="./frontend/images/shop-banner.jpg" alt=""></figure>
                        </a>
                    </div>
                    <div class="wrap-shop-control">
                        <h1 class="shop-title">Tim kiem</h1>
                        <div class="wrap-right">
                            <div class="sort-item orderby">
                                <a href="{{ Request::URL() }}" style="margin:8px"><label>Mac
                                        dinh</label></a>
                                <a href="{{ Request::URL() }}?sort_by=gia-giam-dan"
                                    style="margin:8px"><label>Gia giam dan</label></a>
                                <a href="{{ Request::URL() }}?sort_by=gia-tang-dan"
                                    style="margin:8px"><label>Gia tang dan</label></a>
                                <a href="{{ Request::URL() }}?sort_by=moi-nhat"
                                    style="margin:8px"><label>Moi nhat</label></a>
                            </div>
                            <div class="change-display-mode">
                                <a href="#" class="grid-mode display-mode active"><i class="fa fa-th"></i>Grid</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <ul class="product-list grid-products equal-container">
                            @foreach ($products as $value)
                                <li class="col-lg-4 col-md-6 col-sm-6 col-xs-6 ">
                                    <div class="product product-style-3 equal-elem ">
                                        <div class="product-thumnail">
                                            <a href="{{route('detail',$value->pro_slug)}}" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
                                                <figure><img src="{{ asset('./uploads/products/' . $value->pro_avatar) }}"
                                                        alt=""></figure>
                                            </a>
                                        </div>
                                        <div class="product-info">
                                            <a href="{{route('detail',$value->pro_slug)}}" class="product-name"><span>{{ $value->pro_name }}</span></a>
                                            <div class="wrap-price"><span
                                                    class="product-price">{{ $value->pro_price }}</span></div>
                                            <a href="{{ route('quickAddCart', $value->pro_slug) }}"
                                                class="btn add-to-cart">Add
                                                To Cart</a>
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

                {{-- <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 sitebar">
                    <div class="widget mercado-widget categories-widget">
                        <h2 class="widget-title">All Categories</h2>
                        <div class="widget-content">
                            <ul class="list-category">
                                <li class="category-item has-child-cate">
                                    <a href="#" class="cate-link">Fashion & Accessories</a>
                                    <span class="toggle-control">+</span>
                                    <ul class="sub-cate">
                                        <li class="category-item"><a href="#" class="cate-link">Batteries (22)</a>
                                        </li>
                                        <li class="category-item"><a href="#" class="cate-link">Headsets (16)</a>
                                        </li>
                                        <li class="category-item"><a href="#" class="cate-link">Screen (28)</a></li>
                                    </ul>
                                </li>
                                <li class="category-item has-child-cate">
                                    <a href="#" class="cate-link">Furnitures & Home Decors</a>
                                    <span class="toggle-control">+</span>
                                    <ul class="sub-cate">
                                        <li class="category-item"><a href="#" class="cate-link">Batteries (22)</a>
                                        </li>
                                        <li class="category-item"><a href="#" class="cate-link">Headsets (16)</a>
                                        </li>
                                        <li class="category-item"><a href="#" class="cate-link">Screen (28)</a></li>
                                    </ul>
                                </li>
                                <li class="category-item has-child-cate">
                                    <a href="#" class="cate-link">Digital & Electronics</a>
                                    <span class="toggle-control">+</span>
                                    <ul class="sub-cate">
                                        <li class="category-item"><a href="#" class="cate-link">Batteries (22)</a>
                                        </li>
                                        <li class="category-item"><a href="#" class="cate-link">Headsets (16)</a>
                                        </li>
                                        <li class="category-item"><a href="#" class="cate-link">Screen (28)</a></li>
                                    </ul>
                                </li>
                                <li class="category-item">
                                    <a href="#" class="cate-link">Tools & Equipments</a>
                                </li>
                                <li class="category-item">
                                    <a href="#" class="cate-link">Kid’s Toys</a>
                                </li>
                                <li class="category-item">
                                    <a href="#" class="cate-link">Organics & Spa</a>
                                </li>
                            </ul>
                        </div>
                    </div>
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
                                        class="btn-control control-show-more" href="#">Show more<i
                                            class="fa fa-angle-down" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div><!-- brand widget-->

                    <div class="widget mercado-widget filter-widget price-filter">
                        <h2 class="widget-title">Price</h2>
                        <div class="widget-content">
                            <div id="slider-range"></div>
                            <p>
                                <label for="amount">Price:</label>
                                <input type="text" id="amount" readonly>
                                <button class="filter-submit">Filter</button>
                            </p>
                        </div>
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
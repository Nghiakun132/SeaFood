@extends('layouts.frontend')
@section('title', 'Danh muc' . ' ' . $cate->c_name)
@section('content')
    <style>
        .add-to-cart {
            border-radius: 10px !important;
        }

        @media (min-width: 992px) and (max-width: 1199px) {
            .col-md-4 {
                width: 32% !important;
            }
        }

        @media (max-width:991px) and (min-width: 768px) {
            .col-sm-4 {
                width: 31.8% !important;
            }
        }

        @media (min-width: 1200px) {
            .col-lg-3 {
                width: 24% !important;
            }
        }

    </style>
    <main id="main" class="main-site left-sidebar">
        <div class="container">
            <div class="wrap-breadcrumb">
                <ul>
                    <li class="item-link"><a href="#" class="link">Trang chu</a></li>
                    <li class="item-link"><span>{{ $cate->c_name }}</span></li>
                </ul>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main-content-area">
                    <div class="banner-shop">
                        <a href="#" class="banner-link">
                            <figure><img src="{{ '../uploads/banner/' . $cate->c_banner }}" alt=""></figure>
                        </a>
                    </div>
                    <div class="wrap-shop-control">
                        <h1 class="shop-title">{{ $cate->c_name }}</h1>
                        <div class="wrap-right">
                            <div class="sort-item orderby">
                                <a href="{{ Request::URL() }}" style="margin:8px" class="sort_by"><label>Mặc
                                        định</label></a>
                                <a href="{{ Request::URL() }}?sort_by=gia-giam-dan" style="margin:8px"
                                    class="sort_by"><label>Giá giảm dần</label></a>
                                <a href="{{ Request::URL() }}?sort_by=gia-tang-dan" style="margin:8px"
                                    class="sort_by"><label>Giá tăng dần</label></a>
                                <a href="{{ Request::URL() }}?sort_by=moi-nhat" style="margin:8px"
                                    class="sort_by"><label>Mới nhất</label></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <ul class="product-list grid-products equal-container">
                            @if (count($products) > 0)
                                @foreach ($products as $value)
                                    <li class="col-lg-3 col-md-4 col-sm-4 col-xs-5 ">
                                        <div class="product product-style-3 equal-elem ">
                                            <div class="product-thumnail">
                                                <a href="{{ route('detail', $value->pro_slug) }}"
                                                    title="{{$value->pro_name}}">
                                                    <figure><img
                                                            src="{{ asset('./uploads/products/' . $value->pro_avatar) }}"
                                                            alt=""></figure>
                                                </a>
                                            </div>
                                            <div class="product-info">
                                                <a href="{{ route('detail', $value->pro_slug) }}"
                                                    class="product-name"><span>{{ $value->pro_name }}</span></a>
                                                <div class="wrap-price">
                                                    <span
                                                        class="product-price">{{ number_format($value->pro_price - $value->pro_price * $value->pro_sale, 0, ',', ',') . ' VND' }}
                                                    </span>
                                                </div>
                                                @if ($value->pro_qty > 0)
                                                    <a href="{{ route('quickAddCart', $value->pro_slug) }}"
                                                        class="btn add-to-cart">Thêm vào giỏ hàng</a>
                                                    <a href="{{ route('addWishlist', $value->pro_id) }}"
                                                        class="btn add-to-cart">Thêm vào wishlist</a>
                                                @else
                                                    <a href="#" class="btn add-to-cart" disabled>Hết hàng</a>
                                                @endif

                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <div class="alert alert-danger text-center">
                                    <h2>Không tìm thấy sản phẩm nào</h2>
                                </div>
                            @endif
                        </ul>
                    </div>
                    <div class="wrap-pagination-info">
                        {{ $products->links() }}
                    </div>
                </div>

                {{-- <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 sitebar">
                    <div class="widget mercado-widget widget-product">
                        <h2 class="widget-title">Sản phẩm phổ biến</h2>
                        <div class="widget-content">
                            <ul class="products">
                                @foreach ($popularProducts as $popularProducts)
                                    <li class="product-item">
                                        <div class="product product-widget-style">
                                            <div class="thumbnnail">
                                                <a href="{{ route('detail', $popularProducts->pro_slug) }}"
                                                    title="Radiant-360 R6 Wireless Omnidirectional Speaker [White]">
                                                    <figure><img
                                                            src="{{ '../uploads/products/' . $popularProducts->pro_avatar }}"
                                                            alt=""></figure>
                                                </a>
                                            </div>
                                            <div class="product-info">
                                                <a href="{{ route('detail', $popularProducts->pro_slug) }}"
                                                    class="product-name"><span>{{ $popularProducts->pro_name }}</span></a>
                                                <div class="wrap-price"><span
                                                        class="product-price">{{ number_format($popularProducts->pro_price - $popularProducts->pro_price * $popularProducts->pro_sale,0,',',',') . ' VND' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
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
    <?php
    $success = Session::get('success');
    $error = Session::get('error');
    if ($success) {
        echo '<script>
                                                   alert("' .
            $success .
            '");
                                                </script>';
    } elseif ($error) {
        echo '<script>
                                                   alert("' .
            $error .
            '");
                                                </script>';
    }
    ?>
@stop

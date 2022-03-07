<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('backend/img/2.png') }}">
    <link
        href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,700,700italic,900,900italic&amp;subset=latin,latin-ext"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Open%20Sans:300,400,400italic,600,600italic,700,700italic&amp;subset=latin,latin-ext"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/chosen.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/flexslider.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/test.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/color-01.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
    .list_hover:hover {
        background-color: #2e9ed5;
        color: rgb(241, 226, 226) !important;
        font-weight: 400 !important;
        cursor: pointer;
    }

    .topbar-menu-area a {
        color: #fff;
    }

    .list_hover:hover a {
        background-color: #2e9ed5;
        color: rgb(241, 226, 226) !important;
        font-weight: 400 !important;
        cursor: pointer;
    }

    .list_hover a:hover {
        color: rgb(241, 226, 226) !important;
        font-weight: 400 !important;
    }

    .container_bg {
        background-color: #2e9ed5;
    }

    .search_input {
        border-radius: 12px;
    }

    .topbar-menu-area {
        background: rgb(130, 214, 231)
    }

    .alert {
        margin-bottom: 0;
    }

</style>

<body class="home-page home-01 ">
    <!-- mobile menu -->
    <div class="mercado-clone-wrap">
        <div class="mercado-panels-actions-wrap">
            <a class="mercado-close-btn mercado-close-panels" href="#">x</a>
        </div>
        <div class="mercado-panels"></div>
    </div>
    <header id="header" class="header header-style-1">
        <div class="container-fluid">
            <div class="row">
                <div class="topbar-menu-area">
                    <div class="container">
                        <div class="topbar-menu left-menu">
                            <ul>
                                <li class="menu-item">
                                    <a title="Hotline: (+84) 776585055" href="tel:0776585055"><span
                                            class="icon label-before fa fa-mobile"></span>Hotline: (+84) 776585055</a>
                                </li>
                            </ul>
                        </div>
                        <div class="topbar-menu right-menu">
                            <ul>
                                @if (Session::get('user') == null)
                                    <li class="menu-item"><a title="Register or Login"
                                            href="{{ route('login') }}">Đăng nhập</a></li>
                                    <li class="menu-item"><a title="Register or Login"
                                            href="{{ route('register') }}">Đăng ký</a></li>
                                @else
                                    <li class="menu-item">Chào : {{ Session::get('user')->name }}</li>
                                    <li class="menu-item menu-item-has-children parent">
                                        <a title="Tài khoản" href="#">Tài khoản<i class="fa fa-angle-down"
                                                aria-hidden="true"></i></a>
                                        <ul class="submenu curency">
                                            <li class="menu-item list_hover">
                                                <a title="Tài khoản của tôi" href="{{ route('profile') }}">Tài khoản
                                                    của tôi</a>
                                            </li>
                                            <li class="menu-item list_hover">
                                                <a title="Đơn hàng" href="{{ route('order') }}">Đơn hàng</a>
                                            </li>
                                            <li class="menu-item list_hover">
                                                <a title="Danh sách yêu thích" href="{{ route('wishlist') }}">Danh sách
                                                    yêu thích</a>
                                            </li>
                                            <li class="menu-item list_hover">
                                                <a title="Mã giảm giá" href="{{ route('coupon') }}">Mã giảm giá</a>
                                            </li>
                                            <li class="menu-item list_hover">
                                                <a title="Danh sách địa chỉ" href="{{ route('address') }}">Danh sách
                                                    địa chỉ</a>
                                            </li>

                                            <li class="menu-item list_hover">
                                                <a href="{{ route('logout') }}">Đăng xuất</a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="container_bg">
                    <div class="container">
                        <div class="mid-section main-info-area">
                            <div class="wrap-logo-top left-section">
                                <a href="{{ route('home') }}" class="link-to-home"><img
                                        src="{{ asset('backend/img/2.png') }}" alt="mercado"></a>
                            </div>
                            <div class="wrap-search center-section">
                                <div class="wrap-search-form" style="border-color:#2e9ed5">
                                    <form action="{{ route('search') }}" method="GET">
                                        @csrf
                                        <input type="text" name="search" class="search_input"
                                            placeholder="Search here...">
                                        <button type="submit" style="background:rgb(241, 13, 5)"><i
                                                class="fa fa-search" aria-hidden="true"></i></button>
                                    </form>
                                </div>
                            </div>
                            <div class="wrap-icon right-section">

                                <div class="wrap-icon-section minicart">
                                    <a href="{{ route('cart') }}" class="link-direction">
                                        <i class="fa fa-shopping-basket" aria-hidden="true"
                                            style="color:rgb(18, 238, 18)"></i>
                                        <div class="left-info">
                                            <span class="index">{{ $count }} item</span>
                                            <span class="title" style="color:rgb(247, 247, 247)">GIỎ
                                                Hàng</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="wrap-icon-section minicart dropdown">
                                    <a href="#" class="link-direction dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa-solid fa-bell" style="color:yellow"></i>
                                        <div class="left-info">
                                            <span class="index">{{ $countNotification }} mới</span>
                                            <span class="title" style="color:rgb(247, 247, 247)">Thông
                                                báo</span>
                                        </div>
                                        <ul class="dropdown-menu">
                                            @if ($countNotification > 3)
                                                @foreach ($notification as $notification)
                                                    <li>
                                                        @if ($notification->read == 0)
                                                            <a class=""
                                                                href="{{ route('readNotifications', $notification->id) }}">
                                                                <div class="alert alert-danger">
                                                                    <strong>{{ $notification->notification }}</strong>
                                                                    <p>{{ $notification->created_at }}</p>
                                                                </div>
                                                            </a>
                                                        @else
                                                            <a class=""
                                                                href="{{ route('notifications') }}">
                                                                <div class="alert alert-default">
                                                                    <strong>{{ $notification->notification }}</strong>
                                                                    <p>{{ $notification->created_at }}</p>
                                                                </div>
                                                            </a>
                                                        @endif
                                                    </li>
                                                @endforeach
                                                <div class="readAll" style="text-align: center">
                                                    <a href="">Xem tất cả</a>
                                                </div>
                                            @else
                                                @foreach ($notification as $notification)
                                                    <li>
                                                        @if ($notification->read == 0)
                                                            <a class=""
                                                                href="{{ route('readNotifications', $notification->id) }}">
                                                                <div class="alert alert-danger">
                                                                    <strong>{{ $notification->notification }}</strong>
                                                                    <p>{{ $notification->created_at }}</p>
                                                                </div>
                                                            </a>
                                                        @else
                                                            <a class=""
                                                                href="{{ route('notifications') }}">
                                                                <div class="alert alert-default">
                                                                    <strong>{{ $notification->notification }}</strong>
                                                                    <p>{{ $notification->created_at }}</p>
                                                                </div>
                                                            </a>
                                                        @endif
                                    </a>
                                    </li>
                                    @endforeach
                                    @endif
                                    </ul>
                                    </a>
                                </div>
                                <div class="wrap-icon-section show-up-after-1024">
                                    <a href="#" class="mobile-navigation">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="nav-section header-sticky">
                    <div class="header-nav-section">
                        <div class="container">
                            <ul class="nav menu-nav clone-main-menu" id="mercado_haead_menu" data-menuname="Sale Info">
                                <li class="menu-item"><a href="#" class="link-term">Weekly
                                        Featured</a><span class="nav-label hot-label">hot</span></li>
                                <li class="menu-item"><a href="#" class="link-term">Hot Sale
                                        items</a><span class="nav-label hot-label">hot</span></li>
                                <li class="menu-item"><a href="#" class="link-term">Top new items</a><span
                                        class="nav-label hot-label">hot</span></li>
                                <li class="menu-item"><a href="#" class="link-term">Top Selling</a><span
                                        class="nav-label hot-label">hot</span></li>
                                <li class="menu-item"><a href="#" class="link-term">Top rated
                                        items</a><span class="nav-label hot-label">hot</span></li>
                            </ul>
                        </div>
                    </div>
                </div> --}}
                <div class="primary-nav-section">
                    <div class="container">
                        <ul class="nav primary clone-main-menu" id="mercado_main" data-menuname="Main menu">
                            <li class="menu-item home-icon">
                                <a href="{{ route('home') }}" class="link-term mercado-item-title"><i
                                        class="fa fa-home" aria-hidden="true"></i></a>
                            </li>
                            @foreach ($categoryGlobal as $value)
                                <li class="menu-item">
                                    <a href="{{ route('category', $value->c_slug) }}"
                                        class="link-term mercado-item-title">{{ $value->c_name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    @yield('content')
    <footer id="footer">
        <div class="wrap-footer-content footer-style-1">
            <div class="wrap-function-info">
                <div class="container">
                    <ul>
                        <li class="fc-info-item">
                            <i class="fa fa-truck" aria-hidden="true"></i>
                            <div class="wrap-left-info">
                                <h4 class="fc-name">Miễn phí vận chuyển</h4>
                                <p class="fc-desc">Cho toàn bộ đơn hàng</p>
                            </div>

                        </li>
                        <li class="fc-info-item">
                            <i class="fa fa-recycle" aria-hidden="true"></i>
                            <div class="wrap-left-info">
                                <h4 class="fc-name">Đổi trả</h4>
                                <p class="fc-desc">Nếu hàng không đúng mô tả</p>
                            </div>

                        </li>
                        <li class="fc-info-item">
                            <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
                            <div class="wrap-left-info">
                                <h4 class="fc-name">Thanh toán</h4>
                                <p class="fc-desc">Nhiều hình thức thanh toán</p>
                            </div>

                        </li>
                        <li class="fc-info-item">
                            <i class="fa fa-life-ring" aria-hidden="true"></i>
                            <div class="wrap-left-info">
                                <h4 class="fc-name">Hỗ trợ online</h4>
                                <p class="fc-desc">Chúng tôi hỗ trợ 24/7</p>
                            </div>

                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-footer-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                            <div class="wrap-footer-item">
                                <h3 class="item-header">Liên hệ</h3>
                                <div class="item-content">
                                    <div class="wrap-contact-detail">
                                        <ul>
                                            <li>
                                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                <p class="contact-txt">Hưng Lợi, Tân Hưng, Bình Tân, Vĩnh Long</p>
                                            </li>
                                            <li>
                                                <i class="fa fa-phone" aria-hidden="true"></i>
                                                <p class="contact-txt">0776585055</p>
                                            </li>
                                            <li>
                                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                                <p class="contact-txt">Nghiab1809377@student.ctu.edu.vn</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">

                            <div class="wrap-footer-item">
                                <h3 class="item-header">Hot Line</h3>
                                <div class="item-content">
                                    <div class="wrap-hotline-footer">
                                        <span class="desc">Gọi cho tôi</span>
                                        <b class="phone-number">0776585055</b>
                                    </div>
                                </div>
                            </div>

                            <div class="wrap-footer-item footer-item-second">
                                <h3 class="item-header">Đăng ký nhận khuyến mãi</h3>
                                <div class="item-content">
                                    <div class="wrap-newletter-footer">
                                        <form action="#" class="frm-newletter" id="frm-newletter">
                                            <input type="email" class="input-email" name="email" value=""
                                                placeholder="Nhập email của bạn">
                                            <button class="btn-submit">Đăng ký</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12 box-twin-content ">
                            <div class="row">
                                <div class="wrap-footer-item twin-item">
                                    <h3 class="item-header">Tài khoản</h3>
                                    <div class="item-content">
                                        <div class="wrap-vertical-nav">
                                            <ul>
                                                <li class="menu-item"><a href="#" class="link-term">Tài
                                                        khoản của tôi</a></li>
                                                <li class="menu-item"><a href="#" class="link-term">Giỏ
                                                        hàng</a></li>
                                                <li class="menu-item"><a href="#" class="link-term">Mã giảm
                                                        giá hiện có</a></li>
                                                <li class="menu-item"><a href="#" class="link-term">Thông
                                                        báo</a></li>
                                                <li class="menu-item"><a href="#" class="link-term">Danh
                                                        sách yêu thích</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="wrap-footer-item twin-item">
                                    <h3 class="item-header">Thông tin </h3>
                                    <div class="item-content">
                                        <div class="wrap-vertical-nav">
                                            <ul>
                                                <li class="menu-item"><a href="#" class="link-term">Liên hệ
                                                        chúng tôi</a></li>
                                                <li class="menu-item"><a href="#"
                                                        class="link-term">Returns</a></li>
                                                <li class="menu-item"><a href="#" class="link-term">Bản
                                                        đồ</a></li>
                                                <li class="menu-item"><a href="#"
                                                        class="link-term">Specials</a></li>
                                                <li class="menu-item"><a href="#" class="link-term">Lịch sử
                                                        mua hàng</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                            <div class="wrap-footer-item">
                                <h3 class="item-header">We Using Safe Payments:</h3>
                                <div class="item-content">
                                    <div class="wrap-list-item wrap-gallery">
                                        <img src="{{ asset('frontend/images/payment.png') }}"
                                            style="max-width: 260px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                            <div class="wrap-footer-item">
                                <h3 class="item-header">Social network</h3>
                                <div class="item-content">
                                    <div class="wrap-list-item social-network">
                                        <ul>
                                            <li><a href="#" class="link-to-item" title="twitter"><i
                                                        class="fa-brands fa-twitter"></i></a></li>
                                            <li><a href="https://facebook.com/nghiakun132" target="_blank"
                                                    class="link-to-item" title="facebook"><i
                                                        class="fa-brands fa-facebook"></i></a></li>
                                            <li><a href="#" class="link-to-item" title="pinterest"><i
                                                        class="fa-brands fa-pinterest"></i></a></li>
                                            <li><a href="#" class="link-to-item" title="instagram"><i
                                                        class="fa-brands fa-instagram"></i></a></li>
                                            <li><a href="#" class="link-to-item" title="vimeo"><i
                                                        class="fa-brands fa-vimeo"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                            <div class="wrap-footer-item">
                                <h3 class="item-header">Dowload App</h3>
                                <div class="item-content">
                                    <div class="wrap-list-item apps-list">
                                        <ul>
                                            <li><a href="#" class="link-to-item"
                                                    title="our application on apple store">
                                                    <figure><img
                                                            src="{{ asset('frontend/images/brands/apple-store.png') }}"
                                                            alt="apple store" width="128" height="36"></figure>
                                                </a></li>
                                            <li><a href="#" class="link-to-item"
                                                    title="our application on google play store">
                                                    <figure><img
                                                            src="{{ asset('frontend/images/brands/google-play-store.png') }}"
                                                            alt="google play store" width="128" height="36"></figure>
                                                </a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="coppy-right-box">
                <div class="container">
                    <div class="coppy-right-item item-left">
                        <p class="coppy-right-text">Copyright © 2020 Surfside Media. All rights reserved</p>
                    </div>
                    <div class="coppy-right-item item-right">
                        <div class="wrap-nav horizontal-nav">
                            <ul>
                                <li class="menu-item"><a href="about-us.html" class="link-term">About us</a>
                                </li>
                                <li class="menu-item"><a href="privacy-policy.html"
                                        class="link-term">Privacy Policy</a></li>
                                <li class="menu-item"><a href="terms-conditions.html"
                                        class="link-term">Terms & Conditions</a></li>
                                <li class="menu-item"><a href="return-policy.html" class="link-term">Return
                                        Policy</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </footer>
    <script src="{{ asset('frontend/js/jquery-1.12.4.minb8ff.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery-ui-1.12.4.minb8ff.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.flexslider.js') }}"></script>
    <script src="{{ asset('frontend/js/chosen.jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.sticky.js') }}"></script>
    <script src="{{ asset('frontend/js/functions.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</body>

</html>

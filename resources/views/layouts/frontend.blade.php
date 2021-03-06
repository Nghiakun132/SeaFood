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

    .search-speech {
        background: #fff !important;
        color: #000000 !important;
        border-radius: 50% !important;
        border: 1px solid;
        position: absolute !important;
        top: 0px !important;
        right: 72px !important;
        cursor: pointer !important;
        font-size: 23px;
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
                                            href="{{ route('login') }}">????ng nh???p</a></li>
                                    <li class="menu-item"><a title="Register or Login"
                                            href="{{ route('register') }}">????ng k??</a></li>
                                @else
                                    <li class="menu-item">Ch??o : {{ Session::get('user')->name }}</li>
                                    <li class="menu-item menu-item-has-children parent">
                                        <a title="T??i kho???n" href="#">T??i kho???n<i class="fa fa-angle-down"
                                                aria-hidden="true"></i></a>
                                        <ul class="submenu curency">
                                            <li class="menu-item list_hover">
                                                <a title="T??i kho???n c???a t??i" href="{{ route('profile') }}">T??i kho???n
                                                    c???a t??i</a>
                                            </li>
                                            <li class="menu-item list_hover">
                                                <a title="????n h??ng" href="{{ route('order') }}">????n h??ng</a>
                                            </li>
                                            <li class="menu-item list_hover">
                                                <a title="Danh s??ch y??u th??ch" href="{{ route('wishlist') }}">Danh
                                                    s??ch
                                                    y??u th??ch</a>
                                            </li>
                                            <li class="menu-item list_hover">
                                                <a title="M?? gi???m gi??" href="{{ route('coupon') }}">M?? gi???m gi??</a>
                                            </li>
                                            <li class="menu-item list_hover">
                                                <a title="Danh s??ch ?????a ch???" href="{{ route('address') }}">Danh s??ch
                                                    ?????a ch???</a>
                                            </li>

                                            <li class="menu-item list_hover">
                                                <a href="{{ route('logout') }}">????ng xu???t</a>
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
                                        <input type="text" name="search" class="search_input" id="output"
                                            placeholder="T??m ki???m ..." title="T??m ki???m b???ng v??n b???n">
                                        <button type="submit" style="background:rgb(241, 13, 5)"><i
                                                class="fa fa-search" aria-hidden="true" title="T??m"></i></button>
                                        <a href="#" class="search-speech" onclick="runSpeechRecognition()" title="T??m ki???m b???ng gi???ng n??i">
                                            <i class="fa fa-microphone-slash" aria-hidden="true"></i>
                                        </a>
                                    </form>
                                </div>

                            </div>

                            <div class="wrap-icon right-section">

                                <div class="wrap-icon-section minicart">
                                    <a href="{{ route('cart') }}" class="link-direction" title="Gi??? h??ng">
                                        <i class="fa fa-shopping-basket" aria-hidden="true"
                                            style="color:rgb(18, 238, 18)"></i>
                                        <div class="left-info">
                                            <span class="index">{{ $count }} item</span>
                                            <span class="title" style="color:rgb(247, 247, 247)">GI???
                                                H??ng</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="wrap-icon-section minicart dropdown">
                                    <a href="#" class="link-direction dropdown-toggle" data-toggle="dropdown" title="Th??ng b??o">
                                        <i class="fa-solid fa-bell" style="color:yellow"></i>
                                        <div class="left-info">
                                            <span class="index">{{ $countNotification }} m???i</span>
                                            <span class="title" style="color:rgb(247, 247, 247)">Th??ng
                                                b??o</span>
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
                                                    <a href="">Xem t???t c???</a>
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
                        <ul class="nav primary clone-main-menu" id="mercado_main" data-menuname="Danh m???c">
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
                                <h4 class="fc-name">Mi???n ph?? v???n chuy???n</h4>
                                <p class="fc-desc">Cho to??n b??? ????n h??ng</p>
                            </div>

                        </li>
                        <li class="fc-info-item">
                            <i class="fa fa-recycle" aria-hidden="true"></i>
                            <div class="wrap-left-info">
                                <h4 class="fc-name">?????i tr???</h4>
                                <p class="fc-desc">N???u h??ng kh??ng ????ng m?? t???</p>
                            </div>

                        </li>
                        <li class="fc-info-item">
                            <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
                            <div class="wrap-left-info">
                                <h4 class="fc-name">Thanh to??n</h4>
                                <p class="fc-desc">Nhi???u h??nh th???c thanh to??n</p>
                            </div>

                        </li>
                        <li class="fc-info-item">
                            <i class="fa fa-life-ring" aria-hidden="true"></i>
                            <div class="wrap-left-info">
                                <h4 class="fc-name">H??? tr??? online</h4>
                                <p class="fc-desc">Ch??ng t??i h??? tr??? 24/7</p>
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
                                <h3 class="item-header">Li??n h???</h3>
                                <div class="item-content">
                                    <div class="wrap-contact-detail">
                                        <ul>
                                            <li>
                                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                <p class="contact-txt">H??ng L???i, T??n H??ng, B??nh T??n, V??nh Long</p>
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
                                        <span class="desc">G???i cho t??i</span>
                                        <b class="phone-number">0776585055</b>
                                    </div>
                                </div>
                            </div>

                            <div class="wrap-footer-item footer-item-second">
                                <h3 class="item-header">????ng k?? nh???n khuy???n m??i</h3>
                                <div class="item-content">
                                    <div class="wrap-newletter-footer">
                                        <form action="#" class="frm-newletter" id="frm-newletter">
                                            <input type="email" class="input-email" name="email" value=""
                                                placeholder="Nh???p email c???a b???n">
                                            <button class="btn-submit">????ng k??</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12 box-twin-content mb-3">
                            <div class="row">
                                <div class="wrap-footer-item twin-item">
                                    <h3 class="item-header">T??i kho???n</h3>
                                    <div class="item-content">
                                        <div class="wrap-vertical-nav">
                                            <ul>
                                                <li class="menu-item"><a href="#" class="link-term">T??i
                                                        kho???n c???a t??i</a></li>
                                                <li class="menu-item"><a href="#" class="link-term">Gi???
                                                        h??ng</a></li>
                                                <li class="menu-item"><a href="#" class="link-term">M?? gi???m
                                                        gi?? hi???n c??</a></li>
                                                <li class="menu-item"><a href="#" class="link-term">Th??ng
                                                        b??o</a></li>
                                                <li class="menu-item"><a href="#" class="link-term">Danh
                                                        s??ch y??u th??ch</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="wrap-footer-item twin-item">
                                    <h3 class="item-header">Th??ng tin </h3>
                                    <div class="item-content">
                                        <div class="wrap-vertical-nav">
                                            <ul>
                                                <li class="menu-item"><a href="#" class="link-term">Li??n h???
                                                        ch??ng t??i</a></li>
                                                <li class="menu-item"><a href="#"
                                                        class="link-term">Returns</a></li>
                                                <li class="menu-item"><a href="#" class="link-term">B???n
                                                        ?????</a></li>
                                                <li class="menu-item"><a href="#"
                                                        class="link-term">Specials</a></li>
                                                <li class="menu-item"><a href="#" class="link-term">L???ch s???
                                                        mua h??ng</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div style="margin-bottom:10px"></div>
                </div>
            </div>
        </div>
    </footer>

    {{-- plugin Facebook Messages --}}
    {{-- <div id="fb-root"></div>
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>
    <script>
        var chatbox = document.getElementById('fb-customer-chat');
        chatbox.setAttribute("page_id", "101249449220577");
        chatbox.setAttribute("attribution", "biz_inbox");
    </script>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                xfbml: true,
                version: 'v13.0'
            });
        };
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script> --}}
    {{-- End plugin Facebook Messages --}}

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
    <script>
        function runSpeechRecognition() {
            var output = document.getElementById("output");
            var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition;
            var recognition = new SpeechRecognition();
            recognition.lang = 'vi-VN';
            recognition.onstart = function() {
                output.setAttribute('value', '??ang nh???n d???ng...');
            };
            recognition.onspeechend = function() {
                output.setAttribute('value', 'Ng???ng nh???n d???ng');
                recognition.stop();
            }
            recognition.onresult = function(event) {
                var transcript = event.results[0][0].transcript;
                output.setAttribute('value', transcript);
            };
            recognition.start();
        }
    </script>
</body>

</html>

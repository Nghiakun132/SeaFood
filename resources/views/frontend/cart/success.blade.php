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
                    <h4 class="count-down"></h4>
                    <a href="{{ route('home') }}" class="btn btn-submit btn-submitx">Tiếp tục mua hàng</a>
                </div>
            </div>
        </div>
    </main>
    <script>
        var countDownDate = new Date().getTime()+ 12000;
        var x = setInterval(function() {
            var now = new Date().getTime();
            var distance = countDownDate - now;
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            document.querySelector('.count-down').innerHTML ="Quay về trang chủ sau " + seconds + "s " +'<i class="fa fa-refresh fa-spin"></i>';
              if (distance <=0) {
                clearInterval(x);
                window.location.href = "{{ route('home') }}";
            }
        }, 1000);
    </script>
@stop

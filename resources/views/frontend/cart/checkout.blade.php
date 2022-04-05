@extends('layouts.frontend')
@section('content')
@section('title', 'Thanh toán')
<main id="main" class="main-site">
    <div class="container">
        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="{{ route('home') }}" class="link">Trang chủ</a></li>
                <li class="item-link"><span>Thanh toán</span></li>
            </ul>
        </div>
        <div class=" main-content-area">
            <div class="wrap-iten-in-cart">
                <h3 class="box-title">Tên sản phẩm</h3>
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
                                            value="{{ $cart->cart_product_quantity }}" disabled>
                                        {{-- <a class="btn btn-increase" href="#"></a> --}}
                                        {{-- <a class="btn btn-reduce" href="#"></a> --}}
                                    </div>
                                </div>
                                <input type="hidden" value="{{ $cart->cart_id }}" name="cart_id">
                                <div class="price-field sub-total">
                                    <p class="price">
                                        {{ number_format($cart->cart_product_total, 0, ',', ',') . ' VND' }}
                                </div>

                                {{-- <div class="delete">
                                    <button class="btn btn-delete2" title="">
                                        <span>Update</span>
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </div> --}}
                                {{-- <div class="delete">
                                    <a href="{{Route('deleteCart',$cart->cart_id)}}" class="btn btn-delete2" title="">
                                        <span>Delete from your cart</span>
                                        <i class="fa fa-times-circle" aria-hidden="true"></i>
                                    </a>
                                </div> --}}
                            </li>
                        </form>
                    @endforeach
                </ul>
            </div>
            <div class="summary summary-checkout">
                <form action="{{ route('postCheckout') }}" method="post">
                    @csrf
                    <div class="summary-item payment-method">
                        <h4 class="title-box">Phương thức thanh toán</h4>
                        <div class="choose-payment-methods">
                            <label class="payment-method">
                                <input name="payment_method" id="payment-method-bank" value="VnPay" type="radio"
                                    required>
                                <span>Thanh toán qua VnPay</span>
                            </label>
                            <label class="payment-method">
                                <input name="payment_method" id="payment-method-visa" value="COD" type="radio" required>
                                <span>Thanh toán khi nhận hàng</span>
                            </label>
                            <label class="payment-method">
                                <input name="payment_method" id="payment-method-paypal" value="MOMO" type="radio"
                                    required>
                                <span>Thanh toán qua MOMO</span>
                            </label>
                            <label class="payment-method">
                                <input name="payment_method" id="payment-method-paypal" value="Paypal" type="radio"
                                    required>
                                <span>Thanh toán qua Paypal</span>
                            </label>
                        </div>
                        <p class="summary-info grand-total"><span>Giảm giá</span> <span
                            class="grand-total-price">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            @if (Session::get('cou_value'))
                            {{ number_format($total2 * Session::get('cou_value'), 0, ',', ',') . ' VND' }}
                            @else
                            0 VND
                            @endif
                        </span>
                    </p>
                        <p class="summary-info grand-total"><span>Thành tiền</span> <span
                                class="grand-total-price">{{ number_format($total, 0, ',', ',') . ' VND' }}</span>
                        </p>
                        @if ($countCart > 0)
                            <button class="btn btn-medium" name="redirect">Đặt hàng ngay</button>
                        @else
                            <button class="btn btn-medium" disabled
                                onclick="return alert('Thêm gì đó vào giỏ hàng đi!!!!!!!')">Đặt hàng ngay</button>
                        @endif
                    </div>
                    <div class="summary-item shipping-method">
                        <h4 class="title-box f-title">Thông tin người nhận</h4>
                        <table class="table table-striped">
                            <tr>
                                <th>
                                    Họ tên :
                                </th>
                                <td>
                                    <b>{{ Session::get('user')->name }}</b>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Địa chỉ :
                                </th>
                                <td>
                                    <Select class="form-control select_add" name="address_user">
                                        @foreach ($address as $address)
                                            <option value="{{ $address->address }}">{{ $address->address }}
                                            </option>
                                        @endforeach
                                    </Select>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    SĐT :
                                </th>
                                <td>
                                    <b>{{ Session::get('user')->phone }}</b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="#" id="myBtn" class="btn btn-info">Thêm địa chỉ</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
                <br>
                <div class="summary-item shipping-method">
                    <h4 class="title-box">Mã giảm giá</h4>
                    <form action="{{ route('postCoupon') }}" method="post">
                        @csrf
                        <p class="row-in-form">
                            <label for="coupon-code">Nhập mã giảm giá:</label>
                            @if (Session::get('cou_code'))
                                <input id="coupon-code" type="text" name="coupon_code"
                                    placeholder="{{ Session::get('cou_code') }} " disabled>
                            @else
                                <input id="coupon-code" type="text" name="coupon_code" placeholder="Nhap ma giam gia ">
                            @endif

                            <button type="submit" class="btn btn-small">Áp mã</button>
                        </p>
                        <a href="{{ route('deleteCoupon') }}" class="btn btn-small">Hủy</a>
                    </form>
                </div>
            </div>
            {{-- <div class="wrap-show-advance-info-box style-1 box-in-site">
                <h3 class="title-box">Most Viewed Products</h3>
                <div class="wrap-products">
                    <div class="products slide-carousel owl-carousel style-nav-1 equal-container" data-items="5"
                        data-loop="false" data-nav="true" data-dots="false"
                        data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"3"},"1200":{"items":"5"}}'>

                        <div class="product product-style-2 equal-elem ">
                            <div class="product-thumnail">
                                <a href="#" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
                                    <figure><img src="assets/images/products/digital_04.jpg" width="214" height="214"
                                            alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
                                </a>
                                <div class="group-flash">
                                    <span class="flash-item new-label">new</span>
                                </div>
                                <div class="wrap-btn">
                                    <a href="#" class="function-link">quick view</a>
                                </div>
                            </div>
                            <div class="product-info">
                                <a href="#" class="product-name"><span>Radiant-360 R6 Wireless Omnidirectional Speaker
                                        [White]</span></a>
                                <div class="wrap-price"><span class="product-price">$250.00</span></div>
                            </div>
                        </div>

                        <div class="product product-style-2 equal-elem ">
                            <div class="product-thumnail">
                                <a href="#" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
                                    <figure><img src="assets/images/products/digital_17.jpg" width="214" height="214"
                                            alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
                                </a>
                                <div class="group-flash">
                                    <span class="flash-item sale-label">sale</span>
                                </div>
                                <div class="wrap-btn">
                                    <a href="#" class="function-link">quick view</a>
                                </div>
                            </div>
                            <div class="product-info">
                                <a href="#" class="product-name"><span>Radiant-360 R6 Wireless Omnidirectional Speaker
                                        [White]</span></a>
                                <div class="wrap-price"><ins>
                                        <p class="product-price">$168.00</p>
                                    </ins> <del>
                                        <p class="product-price">$250.00</p>
                                    </del></div>
                            </div>
                        </div>

                        <div class="product product-style-2 equal-elem ">
                            <div class="product-thumnail">
                                <a href="#" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
                                    <figure><img src="assets/images/products/digital_15.jpg" width="214" height="214"
                                            alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
                                </a>
                                <div class="group-flash">
                                    <span class="flash-item new-label">new</span>
                                    <span class="flash-item sale-label">sale</span>
                                </div>
                                <div class="wrap-btn">
                                    <a href="#" class="function-link">quick view</a>
                                </div>
                            </div>
                            <div class="product-info">
                                <a href="#" class="product-name"><span>Radiant-360 R6 Wireless Omnidirectional Speaker
                                        [White]</span></a>
                                <div class="wrap-price"><ins>
                                        <p class="product-price">$168.00</p>
                                    </ins> <del>
                                        <p class="product-price">$250.00</p>
                                    </del></div>
                            </div>
                        </div>

                        <div class="product product-style-2 equal-elem ">
                            <div class="product-thumnail">
                                <a href="#" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
                                    <figure><img src="assets/images/products/digital_01.jpg" width="214" height="214"
                                            alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
                                </a>
                                <div class="group-flash">
                                    <span class="flash-item bestseller-label">Bestseller</span>
                                </div>
                                <div class="wrap-btn">
                                    <a href="#" class="function-link">quick view</a>
                                </div>
                            </div>
                            <div class="product-info">
                                <a href="#" class="product-name"><span>Radiant-360 R6 Wireless Omnidirectional Speaker
                                        [White]</span></a>
                                <div class="wrap-price"><span class="product-price">$250.00</span></div>
                            </div>
                        </div>

                        <div class="product product-style-2 equal-elem ">
                            <div class="product-thumnail">
                                <a href="#" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
                                    <figure><img src="assets/images/products/digital_21.jpg" width="214" height="214"
                                            alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
                                </a>
                                <div class="wrap-btn">
                                    <a href="#" class="function-link">quick view</a>
                                </div>
                            </div>
                            <div class="product-info">
                                <a href="#" class="product-name"><span>Radiant-360 R6 Wireless Omnidirectional
                                        Speaker
                                        [White]</span></a>
                                <div class="wrap-price"><span class="product-price">$250.00</span></div>
                            </div>
                        </div>

                        <div class="product product-style-2 equal-elem ">
                            <div class="product-thumnail">
                                <a href="#" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
                                    <figure><img src="assets/images/products/digital_03.jpg" width="214" height="214"
                                            alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
                                </a>
                                <div class="group-flash">
                                    <span class="flash-item sale-label">sale</span>
                                </div>
                                <div class="wrap-btn">
                                    <a href="#" class="function-link">quick view</a>
                                </div>
                            </div>
                            <div class="product-info">
                                <a href="#" class="product-name"><span>Radiant-360 R6 Wireless Omnidirectional
                                        Speaker [White]</span></a>
                                <div class="wrap-price"><ins>
                                        <p class="product-price">$168.00</p>
                                    </ins> <del>
                                        <p class="product-price">$250.00</p>
                                    </del></div>
                            </div>
                        </div>

                        <div class="product product-style-2 equal-elem ">
                            <div class="product-thumnail">
                                <a href="#" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
                                    <figure><img src="assets/images/products/digital_04.jpg" width="214" height="214"
                                            alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
                                </a>
                                <div class="group-flash">
                                    <span class="flash-item new-label">new</span>
                                </div>
                                <div class="wrap-btn">
                                    <a href="#" class="function-link">quick view</a>
                                </div>
                            </div>
                            <div class="product-info">
                                <a href="#" class="product-name"><span>Radiant-360 R6 Wireless Omnidirectional
                                        Speaker [White]</span></a>
                                <div class="wrap-price"><span class="product-price">$250.00</span></div>
                            </div>
                        </div>

                        <div class="product product-style-2 equal-elem ">
                            <div class="product-thumnail">
                                <a href="#" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
                                    <figure><img src="assets/images/products/digital_05.jpg" width="214" height="214"
                                            alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
                                </a>
                                <div class="group-flash">
                                    <span class="flash-item bestseller-label">Bestseller</span>
                                </div>
                                <div class="wrap-btn">
                                    <a href="#" class="function-link">quick view</a>
                                </div>
                            </div>
                            <div class="product-info">
                                <a href="#" class="product-name"><span>Radiant-360 R6 Wireless Omnidirectional
                                        Speaker [White]</span></a>
                                <div class="wrap-price"><span class="product-price">$250.00</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</main>
<div class="container2">
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close"><i class="fa-solid fa-circle-xmark"></i></span>
            <form action="{{ route('addAddress') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="">
                        <strong>Địa chỉ</strong>
                    </label>
                    <input type="text" name="address" class="form-control" placeholder="Nhập địa chỉ">
                </div>
                <div class="form-group">
                    <label for="">Đặt là mặc định</label>
                    <input type="checkbox" name="default" value="1">
                </div>
                @if ($errors->has('address'))
                    <div class="alert alert-danger">
                        <strong>{{ $errors->first('address') }}</strong>
                    </div>
                @endif
                <button class="btn btn-primary" type="submit">Thêm địa chỉ</button>
            </form>
        </div>
    </div>
</div>
<script>
    var modal = document.getElementById('myModal');
    var btn = document.getElementById("myBtn");
    var span = document.getElementsByClassName("close")[0];
    btn.onclick = function() {
        modal.style.display = "block";
    }
    span.onclick = function() {
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
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

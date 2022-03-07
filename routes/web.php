<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'frontend'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    //đăng ký
    Route::get('/dang-ky', 'UserController@register')->name('register');
    Route::post('/dang-ky', 'UserController@postRegister')->name('postRegister');
    //đăng nhập
    Route::get('/dang-nhap', 'UserController@login')->name('login');
    Route::post('/dang-nhap', 'UserController@postLogin')->name('postLogin');
    //đăng xuất
    Route::get('/dang-xuat', 'UserController@logout')->name('logout');
    //quên mật khẩu

    Route::get('/quen-mat-khau', 'UserController@forgotPassword')->name('forgotPassword');
    Route::post('/quen-mat-khau', 'UserController@postForgotPassword')->name('postForgotPassword');
    //thay đổi mật khẩu
    Route::get('/thay-doi-mat-khau/{token}', 'UserController@resetPassword')->name('resetPassword');
    Route::post('/thay-doi-mat-khau{token}', 'UserController@postResetPassword')->name('postResetPassword');

    //login google
    Route::get('dang-nhap/google', 'UserController@loginGG')->name('login.google');
    Route::get('dang-nhap/google/callback', 'UserController@loginGGCallback')->name('login.google.callback');
    //danh mục
    Route::get('/danh-muc/{slug}', 'CategoryController@index')->name('category');
    // tìm kiếm
    Route::get('/tim-kiem', 'CategoryController@search')->name('search');


    //chi tiết sản phẩm
    Route::group(['prefix' => 'chi-tiet-san-pham'], function () {
        Route::get('/{slug}', 'ProductController@index')->name('detail');
    });
    //don hang
    Route::group(['prefix' => 'don-hang'], function () {
        Route::get('/', 'OrderController@index')->name('order');
        Route::get('/{id}', 'OrderController@detail')->name('order.detail');
        Route::get('/huy-don-hang/{id}', 'OrderController@cancel')->name('cancel');
        Route::post('/huy-don-hang/{id}', 'OrderController@postCancel');
    });

    Route::group(['prefix' => 'gio-hang'], function () {
        Route::get('/', 'CartController@index')->name('cart');
        Route::post('/them-gio-hang', 'CartController@addCart')->name('addCart');
        Route::get('/them-gio-hang/{pro_id}', 'CartController@quickAddCart')->name('quickAddCart');
        Route::post('/cap-nhat/{id}', 'CartController@updateCart')->name('updateCart');
        Route::get('/xoa/{id}', 'CartController@deleteCart')->name('deleteCart');
        Route::get('/xoa-gio-hang', 'CartController@clearCart')->name('clearCart');
    });


    Route::get('/thanh-toan', 'CartController@checkout')->name('checkout');
    Route::post('/thanh-toan', 'CartController@postCheckout')->name('postCheckout');
    Route::get('/cam-on', 'CartController@success')->name('success');
    //paypal
    Route::get('/huy-paypal', 'CartController@cancelTransaction')->name('cancelTransaction');
    Route::get('/hoan-thanh-paypal', 'CartController@successTransaction')->name('successTransaction');
    //thanh toan vnpay
    Route::get('/thanh-toan-vnpay', 'CartController@vnpay')->name('vnpay');
    //thanh toan momo
    Route::get('/thanh-toan-momo', 'CartController@momo')->name('momo');


    Route::post('/ma-giam-gia', 'CartController@postCoupon')->name('postCoupon');
    Route::get('/xoa-ma-giam-gia', 'CartController@deleteCoupon')->name('deleteCoupon');
    Route::get('/test', 'HomeController@test')->name('test');
    Route::get('/danh-sach-yeu-thich', 'ProductController@wishlist')->name('wishlist');
    Route::get('/them-san-pham-yeu-thich/{id}', 'ProductController@addWishlist')->name('addWishlist');
    Route::get('/xoa-san-pham-yeu-thich/{id}', 'ProductController@deleteWishlist')->name('deleteWishlist');
    Route::get('/xoa-tat-ca-san-pham-yeu-thich', 'ProductController@deleteAllWishlist')->name('deleteAllWishlist');
    Route::get('/thong-bao', 'UserController@notifications')->name('notifications');
    Route::get('/doc-thong-bao/{id}', 'UserController@readNotifications')->name('readNotifications');
    Route::get('/xoa-thong-bao/{id}', 'UserController@deleteNotifications')->name('deleteNotifications');
    Route::get('/xoa-tat-ca-thong-bao', 'UserController@deleteAllNotifications')->name('deleteAllNotifications');
    Route::get('/thong-tin-ca-nhan', 'UserController@profile')->name('profile');
    Route::post('/thong-tin-ca-nhan', 'UserController@postProfile')->name('postProfile');
    Route::post('/doi-mat-khau', 'UserController@changePassword')->name('changePassword');
    Route::get('/dia-chi', 'UserController@address')->name('address');
    Route::post('/dia-chi', 'UserController@addAddress')->name('addAddress');
    Route::get('/xoa-dia-chi/{id}', 'UserController@deleteAddress')->name('deleteAddress');
    Route::get('/dia-chi-mac-dinh/{id}', 'UserController@setDefault')->name('setDefault');
    Route::get('sua-dia-chi/{id}', 'UserController@editAddress')->name('editAddress');
    Route::post('/sua-dia-chi/{id}', 'UserController@updateAddress')->name('updateAddress');
    Route::get('/ma-giam-gia-hien-co', 'UserController@coupon')->name('coupon');
    Route::post('/nhan-xet/{id}', 'ProductController@comments')->name('comments');
});


include('admin.php');

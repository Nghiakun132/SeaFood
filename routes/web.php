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
    Route::get('/thay-doi-mat-khau/{token}', 'UserController@resetPassword')->name('resetPassword')->middleware('check.users');
    Route::post('/thay-doi-mat-khau{token}', 'UserController@postResetPassword')->name('postResetPassword')->middleware('check.users');

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
        Route::get('/', 'OrderController@index')->name('order')->middleware('check.users');
        Route::get('/{id}', 'OrderController@detail')->name('order.detail')->middleware('check.users');
        Route::get('/huy-don-hang/{id}', 'OrderController@cancel')->name('cancel')->middleware('check.users');
        Route::post('/huy-don-hang/{id}', 'OrderController@postCancel')->middleware('check.users');
    });
    //gio hang
    Route::group(['prefix' => 'gio-hang'], function () {
        Route::get('/', 'CartController@index')->name('cart')->middleware('check.users');
        Route::post('/them-gio-hang', 'CartController@addCart')->name('addCart')->middleware('check.users');
        Route::get('/them-gio-hang/{pro_id}', 'CartController@quickAddCart')->name('quickAddCart')->middleware('check.users');
        Route::post('/cap-nhat/{id}', 'CartController@updateCart')->name('updateCart')->middleware('check.users');
        Route::get('/xoa/{id}', 'CartController@deleteCart')->name('deleteCart')->middleware('check.users');
        Route::get('/xoa-gio-hang', 'CartController@clearCart')->name('clearCart')->middleware('check.users');
    });

    //thanh toán
    Route::get('/thanh-toan', 'CartController@checkout')->name('checkout')->middleware('check.users');
    Route::post('/thanh-toan', 'CartController@postCheckout')->name('postCheckout')->middleware('check.users');
    //Cam on
    Route::get('/cam-on', 'CartController@success')->name('success')->middleware('check.users');
    //paypal
    Route::get('/huy-paypal', 'CartController@cancelTransaction')->name('cancelTransaction')->middleware('check.users');
    Route::get('/hoan-thanh-paypal', 'CartController@successTransaction')->name('successTransaction')->middleware('check.users');
    //thanh toan vnpay
    Route::get('/thanh-toan-vnpay', 'CartController@vnpay')->name('vnpay')->middleware('check.users');
    //thanh toan momo
    Route::get('/thanh-toan-momo', 'CartController@momo')->name('momo')->middleware('check.users');

    //ma giam gia
    Route::post('/ma-giam-gia', 'CartController@postCoupon')->name('postCoupon')->middleware('check.users');
    Route::get('/xoa-ma-giam-gia', 'CartController@deleteCoupon')->name('deleteCoupon')->middleware('check.users');
    Route::get('/test', 'HomeController@test')->name('test');

    //danh sach yeu thich
    Route::get('/danh-sach-yeu-thich', 'ProductController@wishlist')->name('wishlist')->middleware('check.users');
    Route::get('/them-san-pham-yeu-thich/{id}', 'ProductController@addWishlist')->name('addWishlist')->middleware('check.users');
    Route::get('/xoa-san-pham-yeu-thich/{id}', 'ProductController@deleteWishlist')->name('deleteWishlist')->middleware('check.users');
    Route::get('/xoa-tat-ca-san-pham-yeu-thich', 'ProductController@deleteAllWishlist')->name('deleteAllWishlist')->middleware('check.users');
    Route::get('/thong-bao', 'UserController@notifications')->name('notifications')->middleware('check.users');
    Route::get('/doc-thong-bao/{id}', 'UserController@readNotifications')->name('readNotifications')->middleware('check.users');
    Route::get('/xoa-thong-bao/{id}', 'UserController@deleteNotifications')->name('deleteNotifications')->middleware('check.users');
    Route::get('/xoa-tat-ca-thong-bao', 'UserController@deleteAllNotifications')->name('deleteAllNotifications')->middleware('check.users');
    Route::get('/thong-tin-ca-nhan', 'UserController@profile')->name('profile')->middleware('check.users');
    Route::post('/thong-tin-ca-nhan', 'UserController@postProfile')->name('postProfile')->middleware('check.users');
    Route::post('/doi-mat-khau', 'UserController@changePassword')->name('changePassword')->middleware('check.users');
    Route::get('/dia-chi', 'UserController@address')->name('address')->middleware('check.users');
    Route::post('/dia-chi', 'UserController@addAddress')->name('addAddress')->middleware('check.users');
    Route::get('/xoa-dia-chi/{id}', 'UserController@deleteAddress')->name('deleteAddress')->middleware('check.users');
    Route::get('/dia-chi-mac-dinh/{id}', 'UserController@setDefault')->name('setDefault')->middleware('check.users');
    Route::get('sua-dia-chi/{id}', 'UserController@editAddress')->name('editAddress')->middleware('check.users');
    Route::post('/sua-dia-chi/{id}', 'UserController@updateAddress')->name('updateAddress')->middleware('check.users');
    Route::get('/ma-giam-gia-hien-co', 'UserController@coupon')->name('coupon')->middleware('check.users');
    Route::post('/nhan-xet/{id}', 'ProductController@comments')->name('comments')->middleware('check.users');
});


include('admin.php');

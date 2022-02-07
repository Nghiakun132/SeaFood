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

Route::group(['namespace'=>'frontend'],function(){
    Route::get('/','HomeController@index')->name('home');

    Route::get('/dang-ky','UserController@register')->name('register');
    Route::post('/dang-ky','UserController@postRegister')->name('postRegister');
    Route::get('/dang-nhap','UserController@login')->name('login');
    Route::post('/dang-nhap','UserController@postLogin')->name('postLogin');
    Route::get('/dang-xuat','UserController@logout')->name('logout');
    //login google
    Route::get('dang-nhap/google','UserController@loginGG')->name('login.google');
    Route::get('dang-nhap/google/callback','UserController@loginGGCallback')->name('login.google.callback');
    //danh mục
    Route::get('/danh-muc/{slug}','CategoryController@index')->name('category');
    Route::get('/tim','CategoryController@search')->name('search');
    Route::group(['prefix' =>'chi-tiet-san-pham'], function(){
        Route::get('/{slug}','ProductController@index')->name('detail');
    });

    Route::group(['prefix' =>'gio-hang'],function(){
        Route::get('/','CartController@index')->name('cart');
        Route::post('/them-gio-hang','CartController@addCart')->name('addCart');
        Route::post('/cap-nhat/{id}','CartController@updateCart')->name('updateCart');
        Route::get('/xoa/{id}','CartController@deleteCart')->name('deleteCart');
        Route::get('/xoa-gio-hang','CartController@clearCart')->name('clearCart');
    });
    Route::get('/thanh-toan','CartController@checkout')->name('checkout');
    Route::post('/thanh-toan','CartController@postCheckout')->name('postCheckout');
    Route::post('/ma-giam-gia','CartController@postCoupon')->name('postCoupon');
    Route::get('/xoa-ma-giam-gia','CartController@deleteCoupon')->name('deleteCoupon');
});


include('admin.php');

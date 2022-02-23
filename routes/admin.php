<?php


Route::group(['namespace' => 'backend', 'prefix' => 'admin'], function () {
    //home page
    Route::get('/', 'HomeController@index')->name('admin.home');
    //login page
    Route::get('/dang-nhap', 'HomeController@Login')->name('admin.login');
    Route::post('/dang-nhap', 'HomeController@postLogin')->name('admin.postLogin');
    //logout
    Route::get('/dang-xuat', 'HomeController@Logout')->name('admin.logout');
    //change profile
    Route::get('/thay-doi-thong-tin/{id}', 'HomeController@change_profile')->name('admin.change_profile');
    Route::post('/thay-doi-thong-tin/{id}', 'HomeController@post_change_profile')->name('admin.post_change_profile');

    //categories
    Route::group(['prefix' => 'danh-muc'], function () {
        Route::get('/', 'CategoriesController@index')->name('admin.categories');
        Route::post('/', 'CategoriesController@store')->name('admin.categories.store');
        Route::get('/sua/{id}', 'CategoriesController@edit')->name('admin.categories.edit');
        Route::post('/sua/{id}', 'CategoriesController@update')->name('admin.categories.update');
        Route::get('/xoa/{id}', 'CategoriesController@destroy')->name('admin.categories.destroy');
        Route::get('/thay-doi-trang-thai/{id}', 'CategoriesController@changeStatus')->name('admin.categories.changeStatus');
    });

    Route::group(['prefix' => 'nhan-vien'], function () {
        Route::get('/', 'AdminController@index')->name('admin.staff');
        Route::post('/', 'AdminController@store')->name('admin.staff.store');
        Route::get('/xoa/{id}', 'AdminController@destroy')->name('admin.staff.destroy');
        Route::get('/thay-doi-trang-thai/{id}', 'AdminController@changeStatus')->name('admin.staff.changeStatus');
        Route::get('/len-cap/{id}', 'AdminController@up_level')->name('admin.staff.uplevel');
    });
    Route::group(['prefix' => 'san-pham'], function () {
        Route::get('/', 'ProductController@index')->name('admin.product');
        Route::get('/them-moi', 'ProductController@create')->name('admin.product.create');
        Route::post('/them-moi', 'ProductController@store')->name('admin.product.store');
        Route::get('/sua/{id}', 'ProductController@edit')->name('admin.product.edit');
        Route::post('/sua/{id}', 'ProductController@update')->name('admin.product.update');
        Route::get('/xoa/{id}', 'ProductController@destroy')->name('admin.product.destroy');
        Route::get('/thay-doi-trang-thai/{id}', 'ProductController@changeStatus')->name('admin.product.changeStatus');
    });
    Route::group(['prefix' => 'nhap-hang'], function () {
        Route::get('/', 'ProductController@import')->name('admin.import');
        Route::get('/chi-tiet/{id}', 'ProductController@import_detail')->name('admin.import.detail');
    });
    Route::group(['prefix' => 'don-hang'], function () {
        Route::get('/', 'OrderController@index')->name('admin.order');
        Route::get('/xem-chi-tiet/{id}', 'OrderController@show')->name('admin.order.show');
        Route::get('/xoa/{id}', 'OrderController@destroy')->name('admin.order.destroy');
        Route::get('/thay-doi-trang-thai/{id}', 'OrderController@changeStatus')->name('admin.order.changeStatus');
    });
    Route::group(['prefix' => 'thong-bao'], function () {
        Route::get('/', 'AdminController@Notification')->name('admin.notification');
        Route::get('/xoa/{id}', 'AdminController@destroyNotification')->name('admin.notification.destroy');
        Route::get('/doc/{id}', 'AdminController@readNotification')->name('admin.notification.read');
    });
    Route::group(['prefix' => 'ma-giam-gia'],function(){
        Route::get('/', 'CouponController@index')->name('admin.coupon');
        Route::post('/', 'CouponController@store')->name('admin.coupon.store');
        Route::post('/sua/{id}', 'CouponController@update')->name('admin.coupon.update');
        Route::get('/xoa/{id}', 'CouponController@destroy')->name('admin.coupon.destroy');
        Route::get('/thay-doi-trang-thai/{id}', 'CouponController@changeStatus')->name('admin.coupon.changeStatus');
    });
    Route::group(['prefix' => 'khach-hang'], function () {
        Route::get('/', 'UserController@index')->name('admin.user');
    });
    Route::group(['prefix' =>'thong-ke'],function(){
        Route::get('/', 'AdminController@statistic')->name('admin.statistic');
    });
});

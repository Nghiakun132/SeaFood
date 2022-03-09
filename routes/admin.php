<?php


Route::group(['namespace' => 'backend', 'prefix' => 'cpanel'], function () {
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
    Route::get('/kiem-tra-gio-hang', 'HomeController@checkCart')->name('admin.checkCart');
    Route::get('/test', 'HomeController@test')->name('admin.test');

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
        Route::get('/len-cap/{id}', 'AdminController@promoteStaff')->name('admin.staff.uplevel');
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
        Route::get('/in-hoa-don/{id}', 'OrderController@print')->name('admin.order.print');
    });
    Route::group(['prefix' => 'thong-bao'], function () {
        Route::get('/', 'AdminController@getNotifications')->name('admin.notification');
        Route::get('/xoa/{id}', 'AdminController@destroyNotification')->name('admin.notification.destroy');
        Route::get('/doc/{id}', 'AdminController@readNotification')->name('admin.notification.read');
    });
    Route::group(['prefix' => 'ma-giam-gia'], function () {
        Route::get('/', 'CouponController@index')->name('admin.coupon');
        Route::post('/', 'CouponController@store')->name('admin.coupon.store');
        Route::post('/sua/{id}', 'CouponController@update')->name('admin.coupon.update');
        Route::get('/xoa/{id}', 'CouponController@destroy')->name('admin.coupon.destroy');
        Route::get('/thay-doi-trang-thai/{id}', 'CouponController@changeStatus')->name('admin.coupon.changeStatus');
    });
    Route::group(['prefix' => 'khach-hang'], function () {
        Route::get('/', 'UserController@index')->name('admin.user');
        Route::get('/xoa/{id}', 'UserController@destroy')->name('admin.user.destroy');
        Route::get('/thay-doi-trang-thai/{id}', 'UserController@changeStatus')->name('admin.user.changeStatus');
        Route::get('/khoa/{id}', 'UserController@block')->name('admin.user.block');
    });
    Route::group(['prefix' => 'thong-ke'], function () {
        Route::get('/', 'AdminController@statistics')->name('admin.statistic');
    });
    Route::group(['prefix' => 'binh-luan'], function () {
        Route::get('/', 'CommentController@index')->name('admin.comment');
        Route::get('/xoa/{id}', 'CommentController@destroy')->name('admin.comment.destroy');
    });
    Route::group(['prefix' => 'giam-gia'],function(){
        Route::get('/','ProductController@sales')->name('admin.sales');
        Route::post('/','ProductController@store_sales')->name('admin.sales.store');
        Route::get('/xoa/{id}','ProductController@destroy_sales')->name('admin.sales.destroy');
        //change status
        Route::get('/thay-doi-trang-thai/{id}','ProductController@changeStatus_sales')->name('admin.sales.changeStatus');
        Route::get('/them-san-pham/{id}','ProductController@add_product')->name('admin.sales.add_product');
    });
});

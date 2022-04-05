<?php


Route::group(['namespace' => 'backend', 'prefix' => 'cpanel'], function () {
    //home page
    Route::get('/', 'HomeController@index')->name('admin.home')->middleware('check.admin');
    //login page
    Route::get('/dang-nhap', 'HomeController@Login')->name('admin.login');
    Route::post('/dang-nhap', 'HomeController@postLogin')->name('admin.postLogin');
    //logout
    Route::get('/dang-xuat', 'HomeController@Logout')->name('admin.logout');
    //change profile
    Route::get('/thay-doi-thong-tin/{id}', 'HomeController@change_profile')->name('admin.change_profile')->middleware('check.admin');
    Route::post('/thay-doi-thong-tin/{id}', 'HomeController@post_change_profile')->name('admin.post_change_profile')->middleware('check.admin');
    //change password
    Route::post('/doi-mat-khau', 'HomeController@changePassword')->name('admin.changePassword')->middleware('check.admin');
    Route::get('/kiem-tra-gio-hang', 'HomeController@checkCart')->name('admin.checkCart')->middleware('check.admin');
    Route::get('/test', 'HomeController@test')->name('admin.test');

    //categories
    Route::group(['prefix' => 'danh-muc'], function () {
        Route::get('/', 'CategoriesController@index')->name('admin.categories')->middleware('check.admin');
        Route::post('/', 'CategoriesController@store')->name('admin.categories.store')->middleware('check.admin');
        Route::get('/sua/{id}', 'CategoriesController@edit')->name('admin.categories.edit')->middleware('check.admin');
        Route::post('/sua/{id}', 'CategoriesController@update')->name('admin.categories.update')->middleware('check.admin');
        Route::get('/xoa/{id}', 'CategoriesController@destroy')->name('admin.categories.destroy')->middleware('check.admin');
        Route::get('/thay-doi-trang-thai/{id}', 'CategoriesController@changeStatus')->name('admin.categories.changeStatus')->middleware('check.admin');
    });

    Route::group(['prefix' => 'nhan-vien'], function () {
        Route::get('/', 'AdminController@index')->name('admin.staff')->middleware('check.admin');
        Route::post('/', 'AdminController@store')->name('admin.staff.store')->middleware('check.admin');
        Route::get('/xoa/{id}', 'AdminController@destroy')->name('admin.staff.destroy')->middleware('check.admin');
        Route::get('/thay-doi-trang-thai/{id}', 'AdminController@changeStatus')->name('admin.staff.changeStatus')->middleware('check.admin');
        Route::get('/len-cap/{id}', 'AdminController@promoteStaff')->name('admin.staff.uplevel')->middleware('check.admin');
    });
    Route::group(['prefix' => 'san-pham'], function () {
        Route::get('/', 'ProductController@index')->name('admin.product')->middleware('check.admin');
        Route::get('/them-moi', 'ProductController@create')->name('admin.product.create')->middleware('check.admin');
        Route::post('/them-moi', 'ProductController@store')->name('admin.product.store')->middleware('check.admin');
        Route::get('/sua/{id}', 'ProductController@edit')->name('admin.product.edit')->middleware('check.admin');
        Route::post('/sua/{id}', 'ProductController@update')->name('admin.product.update')->middleware('check.admin');
        Route::get('/xoa/{id}', 'ProductController@destroy')->name('admin.product.destroy')->middleware('check.admin');
        Route::get('/thay-doi-trang-thai/{id}', 'ProductController@changeStatus')->name('admin.product.changeStatus')->middleware('check.admin');
    });
    Route::group(['prefix' => 'nhap-hang'], function () {
        Route::get('/', 'ProductController@import')->name('admin.import')->middleware('check.admin');
        Route::get('/chi-tiet/{id}', 'ProductController@import_detail')->name('admin.import.detail')->middleware('check.admin');
    });
    Route::group(['prefix' => 'don-hang'], function () {
        Route::get('/', 'OrderController@index')->name('admin.order')->middleware('check.admin');
        Route::get('/xem-chi-tiet/{id}', 'OrderController@show')->name('admin.order.show')->middleware('check.admin');
        Route::get('/xoa/{id}', 'OrderController@destroy')->name('admin.order.destroy')->middleware('check.admin');
        Route::get('/thay-doi-trang-thai/{id}', 'OrderController@changeStatus')->name('admin.order.changeStatus')->middleware('check.admin');
        Route::get('/in-hoa-don/{id}', 'OrderController@print')->name('admin.order.print')->middleware('check.admin');
    });
    Route::group(['prefix' => 'thong-bao'], function () {
        Route::get('/', 'AdminController@getNotifications')->name('admin.notification')->middleware('check.admin');
        Route::get('/xoa/{id}', 'AdminController@destroyNotification')->name('admin.notification.destroy')->middleware('check.admin');
        Route::get('/doc/{id}', 'AdminController@readNotification')->name('admin.notification.read')->middleware('check.admin');
        //xoa tat ca
        Route::get('/xoa-tat-ca', 'AdminController@destroyAllNotification')->name('admin.notification.destroyAll')->middleware('check.admin');
    });
    Route::group(['prefix' => 'ma-giam-gia'], function () {
        Route::get('/', 'CouponController@index')->name('admin.coupon')->middleware('check.admin');
        Route::post('/', 'CouponController@store')->name('admin.coupon.store')->middleware('check.admin');
        Route::post('/sua/{id}', 'CouponController@update')->name('admin.coupon.update')->middleware('check.admin');
        Route::get('/xoa/{id}', 'CouponController@destroy')->name('admin.coupon.destroy')->middleware('check.admin');
        Route::get('/thay-doi-trang-thai/{id}', 'CouponController@changeStatus')->name('admin.coupon.changeStatus')->middleware('check.admin');
    });
    Route::group(['prefix' => 'khach-hang'], function () {
        Route::get('/', 'UserController@index')->name('admin.user')->middleware('check.admin');
        Route::get('/xoa/{id}', 'UserController@destroy')->name('admin.user.destroy')->middleware('check.admin');
        Route::get('/thay-doi-trang-thai/{id}', 'UserController@changeStatus')->name('admin.user.changeStatus')->middleware('check.admin');
        Route::get('/khoa/{id}', 'UserController@block')->name('admin.user.block')->middleware('check.admin');
    });
    Route::group(['prefix' => 'thong-ke'], function () {
        Route::get('/', 'AdminController@statistics')->name('admin.statistic')->middleware('check.admin');
    });
    Route::group(['prefix' => 'binh-luan'], function () {
        Route::get('/', 'CommentController@index')->name('admin.comment')->middleware('check.admin');
        Route::get('/xoa/{id}', 'CommentController@destroy')->name('admin.comment.destroy')->middleware('check.admin');
        Route::get('/thay-doi-trang-thai/{id}', 'CommentController@changeStatus')->name('admin.comment.changeStatus')->middleware('check.admin');
    });
    Route::group(['prefix' => 'giam-gia'], function () {
        Route::get('/', 'ProductController@sales')->name('admin.sales')->middleware('check.admin');
        Route::post('/', 'ProductController@store_sales')->name('admin.sales.store')->middleware('check.admin');
        Route::get('/xoa/{id}', 'ProductController@destroy_sales')->name('admin.sales.destroy')->middleware('check.admin');
        //change status
        Route::get('/thay-doi-trang-thai/{id}', 'ProductController@changeStatus_sales')->name('admin.sales.changeStatus')->middleware('check.admin');
        Route::get('/them-san-pham/{id}', 'ProductController@addProduct')->name('admin.sales.add_product')->middleware('check.admin');
        Route::post('/them-san-pham/{id}', 'ProductController@add_product_post')->name('admin.sales.add_product_post')->middleware('check.admin');
        Route::get('/kiem-tra', 'ProductController@checkExpired')->name('admin.sales.check')->middleware('check.admin');
    });
});

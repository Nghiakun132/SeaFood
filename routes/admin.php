<?php


Route::group(['namespace' => 'backend', 'prefix' => 'admin'], function () {
    //home page
    Route::get('/', 'HomeController@index')->name('admin.home');
    //login page
    Route::get('/dang-nhap', 'HomeController@Login')->name('admin.login');
    Route::post('/dang-nhap', 'HomeController@postLogin')->name('admin.postLogin');
    //logout
    Route::get('/dang-xuat', 'HomeController@Logout')->name('admin.logout');

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
        Route::post('/', 'ProductController@store')->name('admin.product.store');
        Route::get('/sua/{id}', 'ProductController@edit')->name('admin.product.edit');
        Route::post('/sua/{id}', 'ProductController@update')->name('admin.product.update');
        Route::get('/xoa/{id}', 'ProductController@destroy')->name('admin.product.destroy');
        Route::get('/thay-doi-trang-thai/{id}', 'ProductController@changeStatus')->name('admin.product.changeStatus');
        Route::get('/test', 'ProductController@test')->name('admin.product.test');
        Route::post('/test', 'ProductController@test1')->name('admin.product.test');
    });
});

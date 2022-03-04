<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'api'], function () {
    Route::group(['prefix' => 'doanh-thu'], function () {
        Route::get('/', "TestController@index");
        Route::get('/thang-gan-nhat', "TestController@thang");
        Route::get('/7-ngay-gan-nhat', "TestController@ngay7");
        Route::get('/nam', "TestController@hientai");
    });
    Route::group(['prefix' => 'don-hang'], function () {
        Route::get('/', "OrderController@index");
    });
    Route::group(['prefix' => 'san-pham'], function () {
        Route::get('/', "ProductController@index");
        Route::get('/ngay-gan-nhat', "ProductController@getQuantity");
    });
});

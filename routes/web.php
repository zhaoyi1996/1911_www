<?php

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('info',function(){
   phpinfo();
});
Route::get('/wx/gettoken','TestController@getToken');
Route::get('/wx/curl','TestController@getCurltoken');
Route::get('/wx/guzzle','TestController@getGuzzleToken');
Route::get('access','TestController@getapitoken');
Route::get('userinfo','TestController@userInfo');
Route::post('login','TestController@login');
Route::post('sign','TestController@sign');
Route::get('user/info','TestController@userInfo');
Route::get('goods/show','GoodsController@show');//商品详情
Route::get('test/enc','TestController@enc');//加密
Route::get('test/dec','TestController@dec');//解api传过来的值
Route::get('test/header','TestController@headers');//header传输测试




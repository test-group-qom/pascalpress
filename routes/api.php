<?php

use Illuminate\Http\Request;
use App\Http\Middleware\myAuth;

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');



Route::get('search/{string}', ['uses' => 'newsController@search']);
// news routes........................................................................................
Route::get('news',  [ 'as' => 'news.index', 'uses' => 'newsController@index']);
Route::get('news/{id}',  [ 'as' => 'news.show', 'uses' => 'newsController@show']);

Route::group(['middleware'=>myAuth::class], function(){
    Route::post('news',  [ 'as' => 'news.create', 'uses' => 'newsController@store']);
	Route::put('news/{id}',  [ 'as' => 'news.create', 'uses' => 'newsController@update']);
	//Route::delete('news/{id}',  [ 'as' => 'news.index', 'uses' => 'newsController@destroy']);
    Route::delete('news/{id}',  [ 'as' => 'news.index', 'uses' => 'newsController@delete']);
    Route::put('news/{id}/restore',  [ 'as' => 'news.index', 'uses' => 'newsController@restore']);
});

// article routes.......................................................................................
Route::get('article',  [ 'as' => 'article.index', 'uses' => 'articleController@index']);
Route::get('article/{id}',  [ 'as' => 'article.show', 'uses' => 'articleController@show']);

Route::group(['middleware'=>myAuth::class], function(){
	Route::put('article/{id}',  [ 'as' => 'article.update', 'uses' => 'articleController@update']);
	Route::post('article',  [ 'as' => 'article.create', 'uses' => 'articleController@store']);
	//Route::delete('news/{id}',  [ 'as' => 'news.index', 'uses' => 'newsController@destroy']);
	Route::delete('article/{id}',  [ 'as' => 'article.index', 'uses' => 'articleController@delete']);
	Route::put('article/{id}/restore',  [ 'as' => 'article.index', 'uses' => 'articleController@restore']);
});
// pages routes........................................................................................
Route::get('page',  [ 'as' => 'page.index', 'uses' => 'pageController@index']);
Route::get('page/{id}',  [ 'as' => 'page.show', 'uses' => 'pageController@show']);

Route::group(['middleware'=>myAuth::class], function(){
    Route::post('page',  [ 'as' => 'page.create', 'uses' => 'pageController@store']);
	Route::put('page/{id}',  [ 'as' => 'page.create', 'uses' => 'pageController@update']);
	//Route::delete('news/{id}',  [ 'as' => 'news.index', 'uses' => 'newsController@destroy']);
    Route::delete('page/{id}',  [ 'as' => 'page.index', 'uses' => 'pageController@delete']);
    Route::put('page/{id}/restore',  [ 'as' => 'page.index', 'uses' => 'pageController@restore']);
});
// login routes..........................................................................................
Route::post('login',  [ 'as' => '', 'uses' => 'Auth\LoginController@login']);
Route::get('logout',  [ 'as' => '', 'uses' => 'Auth\LoginController@logout', 'middleware' =>myAuth::class]);
Route::post('register',  [ 'as' => '', 'uses' => 'Auth\RegisterController@create_api']);
//..File upload..........................................................................................
Route::post('uploadfile',  [ 'as' => '', 'uses' => 'UploadFileController@showUploadFile', 'middleware' =>myAuth::class]);
Route::get('uploadfile',  [ 'as' => '', 'uses' => 'UploadFileController@index']);
//...config....................................................................................................
Route::group(['middleware'=>myAuth::class], function(){
	Route::get('config',  ['uses' => 'configController@index']);
	Route::get('config/{id}',  [ 'uses' => 'configController@show']);
    Route::post('config',  ['uses' => 'configController@store']);
	Route::put('config/{id}',  ['uses' => 'configController@update']);
	//Route::delete('config/{id}',  ['uses' => 'configController@destroy']);
    Route::delete('config/{id}',  ['uses' => 'configController@delete']);
    Route::put('config/{id}/restore',  ['uses' => 'configController@restore']);
});
//.......................................................................................
Route::get('user',  [ 'as' => 'user.index', 'uses' => 'userController@index']);
Route::get('user/{id}',  [ 'as' => 'user.show', 'uses' => 'userController@show']);
Route::get('user/{id}/edit',  [ 'as' => 'user.create', 'uses' => 'userController@edit']);
Route::put('user/{id}',  [ 'as' => 'user.create', 'uses' => 'userController@update']);
Route::delete('user/{id}',  [ 'as' => 'user.index', 'uses' => 'userController@destroy']);
Route::put('user/{id}',  [ 'as' => 'user.index', 'uses' => 'userController@delete']);
Route::put('user/{id}/restore',  [ 'as' => 'user.index', 'uses' => 'userController@restore']);

//route product and depended on it
Route::group(['namespace' => 'api'], function () {

    Route::resource('/category', 'CategoryController',
        ['only' => ['index', 'show']]);
    Route::resource('/product', 'ProductController',
        ['only' =>[ 'index', 'show']]);
    Route::resource('/productFile', 'ProductFileController',
        ['only' => ['index', 'show']]);
    Route::resource('/productDetail', 'ProductDetailController',
        ['only' => ['index', 'show']]);

    Route::group(['middleware' => \App\Http\Middleware\myAuth::class], function () {
        Route::resource('/category', 'CategoryController',
            ['only' => ['store', 'update', 'destroy']]);
        Route::resource('/product', 'ProductController',
            ['only' => ['store', 'update', 'destroy']]);
        Route::resource('/productFile', 'ProductFileController',
            ['only' =>[ 'store', 'update', 'destroy']]);
        Route::resource('/productDetail', 'ProductDetailController',
            ['only' => ['store', 'update', 'destroy']]);

        Route::get('/product/restore/{id}', 'ProductController@restore');
        Route::get('/productDetail/restore/{id}', 'ProductDetailController@restore');
        Route::get('/productFile/restore/{id}', 'ProductFileController@restore');
        Route::get('/category/restore/{id}', 'CategoryController@restore');
    });
});
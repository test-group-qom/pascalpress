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

// news routes........................................................................................
Route::get('news',  [ 'as' => 'news.index', 'uses' => 'newsController@index']);
Route::get('news/{id}',  [ 'as' => 'news.show', 'uses' => 'newsController@show']);
Route::get('search', [ 'as' => 'news.search', 'uses' => 'newsController@search']);

Route::group(['middleware'=>myAuth::class], function(){
    Route::post('news',  [ 'as' => 'news.create', 'uses' => 'newsController@store']);
	Route::put('news/{id}',  [ 'as' => 'news.create', 'uses' => 'newsController@update']);
	//Route::delete('news/{id}',  [ 'as' => 'news.index', 'uses' => 'newsController@destroy', 'middleware' =>myAuth::class]);
	Route::delete('news/{id}',  [ 'as' => 'news.index', 'uses' => 'newsController@destroy']);
    Route::put('news/{id}',  [ 'as' => 'news.index', 'uses' => 'newsController@delete']);
    Route::put('news/{id}/restore',  [ 'as' => 'news.index', 'uses' => 'newsController@restore']);
});

// article routes.......................................................................................
Route::get('article',  [ 'as' => 'article.index', 'uses' => 'articleController@index']);
Route::get('article/{id}',  [ 'as' => 'article.show', 'uses' => 'articleController@show']);
Route::get('search', [ 'as' => 'article.search', 'uses' => 'articleController@search']);

Route::group(['middleware'=>myAuth::class], function(){
	Route::put('article/{id}',  [ 'as' => 'article.update', 'uses' => 'articleController@update']);
	Route::post('article',  [ 'as' => 'article.create', 'uses' => 'articleController@store']);
	//Route::delete('news/{id}',  [ 'as' => 'news.index', 'uses' => 'newsController@destroy', 'middleware' =>myAuth::class]);
	Route::delete('article/{id}',  [ 'as' => 'article.index', 'uses' => 'articleController@delete']);
	Route::put('article/{id}/restore',  [ 'as' => 'article.index', 'uses' => 'articleController@restore']);
});
// login routes..........................................................................................
Route::post('login',  [ 'as' => '', 'uses' => 'Auth\LoginController@login']);
Route::get('logout',  [ 'as' => '', 'uses' => 'Auth\LoginController@logout', 'middleware' =>myAuth::class]);
Route::post('register',  [ 'as' => '', 'uses' => 'Auth\RegisterController@create_api']);
//.......................................................................................................


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
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


Route::get('news',  [ 'as' => 'news.index', 'uses' => 'newsController@index']);
Route::get('news/{id}',  [ 'as' => 'news.show', 'uses' => 'newsController@show']);
Route::get('search', [ 'as' => 'news.search', 'uses' => 'newsController@search']);

Route::get('news/create',  [ 'as' => 'news.create', 'uses' => 'newsController@create', 'middleware' =>myAuth::class]);
Route::put('news/{id}',  [ 'as' => 'news.update', 'uses' => 'newsController@update', 'middleware' =>myAuth::class]);
Route::post('news',  [ 'as' => 'news.create', 'uses' => 'newsController@store', 'middleware' =>myAuth::class]);
//Route::delete('news/{id}',  [ 'as' => 'news.index', 'uses' => 'newsController@destroy', 'middleware' =>myAuth::class]);
Route::delete('news/{id}',  [ 'as' => 'news.index', 'uses' => 'newsController@delete', 'middleware' =>myAuth::class]);
Route::put('news/{id}/restore',  [ 'as' => 'news.index', 'uses' => 'newsController@restore', 'middleware' =>myAuth::class]);



Route::post('login',  [ 'as' => '', 'uses' => 'Auth\LoginController@login']);
Route::get('logout',  [ 'as' => '', 'uses' => 'Auth\LoginController@logout', 'middleware' =>myAuth::class]);
Route::post('register',  [ 'as' => '', 'uses' => 'Auth\RegisterController@create_api']);



// Route::group(['prefix'=>'api','middleware'=>myAuth::class], function(){
// 	Route::get('news',  [ 'as' => 'news.index', 'uses' => 'newsController@index']);
//     Route::post('news',  [ 'as' => 'news.create', 'uses' => 'newsController@store']);
// 	Route::put('news/{id}',  [ 'as' => 'news.create', 'uses' => 'newsController@update']);
// 	Route::delete('news/{id}',  [ 'as' => 'news.index', 'uses' => 'newsController@destroy']);
//     Route::put('news/{id}',  [ 'as' => 'news.index', 'uses' => 'newsController@delete']);
//     Route::put('news/{id}/restore',  [ 'as' => 'news.index', 'uses' => 'newsController@restore']);
// });

Route::get('user',  [ 'as' => 'user.index', 'uses' => 'userController@index']);
Route::get('user/{id}',  [ 'as' => 'user.show', 'uses' => 'userController@show']);
Route::get('user/{id}/edit',  [ 'as' => 'user.create', 'uses' => 'userController@edit']);
Route::put('user/{id}',  [ 'as' => 'user.create', 'uses' => 'userController@update']);
Route::delete('user/{id}',  [ 'as' => 'user.index', 'uses' => 'userController@destroy']);
Route::put('user/{id}',  [ 'as' => 'user.index', 'uses' => 'userController@delete']);
Route::put('user/{id}/restore',  [ 'as' => 'user.index', 'uses' => 'userController@restore']);

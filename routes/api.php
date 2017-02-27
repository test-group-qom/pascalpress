<?php

use Illuminate\Http\Request;

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
Route::get('news/create',  [ 'as' => 'news.create', 'uses' => 'newsController@create']);
Route::get('news/{id}/edit',  [ 'as' => 'news.create', 'uses' => 'newsController@edit']);
Route::post('news',  [ 'as' => 'news.create', 'uses' => 'newsController@store']);
Route::put('news/{id}',  [ 'as' => 'news.create', 'uses' => 'newsController@update']);
//Route::patch('news/{id}',  [ 'as' => 'news.create', 'uses' => 'newsController@update']);
Route::delete('news/{id}',  [ 'as' => 'news.index', 'uses' => 'newsController@destroy']);
Route::put('news/{id}',  [ 'as' => 'news.index', 'uses' => 'newsController@delete']);
Route::put('news/{id}',  [ 'as' => 'news.index', 'uses' => 'newsController@restore']);
Route::get('search', [ 'as' => 'news.search', 'uses' => 'newsController@search']);


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

Route::get('news',  [ 'as' => 'news.index', 'uses' => 'newsController@index']);
Route::get('news/{id}',  [ 'as' => 'news.show', 'uses' => 'newsController@show']);
Route::get('news/create',  [ 'as' => 'news.create', 'uses' => 'newsController@create']);
Route::get('news/{id}/edit',  [ 'as' => 'news.create', 'uses' => 'newsController@edit']);
Route::put('news/{id}',  [ 'as' => 'news.create', 'uses' => 'newsController@update']);
//Route::patch('news/{id}',  [ 'as' => 'news.create', 'uses' => 'newsController@update']);
Route::delete('news/{id}',  [ 'as' => 'news.index', 'uses' => 'newsController@destroy']);
Route::put('news/{id}',  [ 'as' => 'news.index', 'uses' => 'newsController@delete']);
Route::put('news/{id}',  [ 'as' => 'news.index', 'uses' => 'newsController@restore']);
Route::get('search', [ 'as' => 'news.search', 'uses' => 'newsController@search']);

    Route::group(array('prefix' => 'api'), function() {
        Route::resource('news','newsController@store');
       // Route::post('news',  [ 'as' => 'news.create', 'uses' => 'newsController@store']);

    });
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

Route::group( [ 'middleware' => 'auth.token' ], function () {
	
	## Admin
	Route::get( '/admin/logout', 'AdminController@logout' );
	Route::post( '/admin/change_password', 'AdminController@change_password' );
	Route::post( '/admin/edit_profile', 'AdminController@editProfile' );

	## User
	Route::get( '/user', 'UserController@index' );
	Route::delete( '/user/{id}', 'UserController@destroy' );
	Route::get( '/user/logout', 'UserController@logout' );
	Route::post( '/user/change_password', 'UserController@change_password' );
	Route::post( '/user/edit_profile', 'UserController@editProfile' );
	Route::post( '/user/status/{user_id}', 'UserController@status' );

	## Plan
	Route::post( '/plan', 'PlanController@store' );
	Route::put( '/plan/{id}', 'PlanController@update' );
	Route::delete( '/plan/{id}', 'PlanController@destroy' );
	Route::post( '/plan/status/{plan_id}', 'PlanController@status' );

} );

## Admin
Route::post( '/admin/login', 'AdminController@login' );
Route::post( '/admin/forget', 'AdminController@forgetPassword' );
Route::post( '/admin/recover/{remember_token}', 'AdminController@recover' );

## User
Route::post( '/user', 'UserController@store' );
Route::get( '/user/{id}', 'UserController@show' );
Route::post( '/user/login', 'UserController@login' );
Route::post( '/user/forget', 'UserController@forgetPassword' );
Route::post( '/user/recover/{remember_token}', 'UserController@recover' );

## Category
Route::get( '/category', 'CategoryController@index' );
Route::get( '/category/{id}', 'CategoryController@show' );
Route::post( '/category', 'CategoryController@store' );
Route::put( '/category/{id}', 'CategoryController@update' );
Route::delete( '/category/{id}', 'CategoryController@destroy' );

## Tag
Route::get( '/tag', 'TagController@index' );
Route::get( '/tag/{id}', 'TagController@show' );
Route::post( '/tag', 'TagController@store' );
Route::put( '/tag/{id}', 'TagController@update' );
Route::delete( '/tag/{id}', 'TagController@destroy' );

## Post
Route::get( '/post', 'PostController@index' );
Route::get( '/post/{id}', 'PostController@show' );
Route::post( '/post', 'PostController@store' );
Route::put( '/post/{id}', 'PostController@update' );
Route::delete( '/post/{id}', 'PostController@destroy' );
Route::post( '/post_status', 'PostController@status' );
Route::get( '/cat_post/{cat_id}', 'PostController@cat_post' );
Route::get( '/tag_post/{tag_id}', 'PostController@tag_post' );

## Contact
Route::get( '/contact', 'ContactController@index' );
Route::get( '/contact/{id}', 'ContactController@show' );
Route::post( '/contact', 'ContactController@store' );
Route::delete( '/contact/{id}', 'ContactController@destroy' );

## Plan
Route::get( '/plan', 'PlanController@index' );
Route::get( '/plan/{id}', 'PlanController@show' );
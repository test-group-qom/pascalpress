<?php
Auth::routes();

Route::get( '/', function () {
	return view( 'front.index' );
} );
Route::get( 'about', function () {
	return view( 'front.about' );
} );
Route::get( 'contact', function () {
	return view( 'front.contact' );
} );
Route::get( 'products', function () {
	return view( 'front.products' );
} );
Route::get( 'catalog', function () {
	return view( 'front.catalog' );
} );
Route::get( 'articles', function () {
	return view( 'front.articles' );
} );
Route::get( 'news', function () {
	return view( 'front.news' );
} );

Route::get( '/admin-panel', function () {
	return view( 'admin.auth.login' );
} );

Route::get( '/home', 'HomeController@index' )->name( 'home' );

Route::group( [ 'prefix' => 'admin', 'middleware' => [ 'auth', 'admin' ] ], function () {

	Route::get( '/edit_profile', function () {
		return view( 'admin.auth.edit_profile' );
	} );
	Route::get( '/category/edit', function () {
		return view( 'admin.category.edit' );
	} );
	Route::get( '/tag/edit', function () {
		return view( 'admin.tag.edit' );
	} );
	Route::get( '/post/edit', function () {
		return view( 'admin.post.edit' );
	} );
	Route::get( '/post/add', function () {
		return view( 'admin.post.create' );
	} );
	Route::get( '/dashboard', function () {
		return view( 'admin.dashboard' );
	} );

## Admin
	Route::get( '/logout', 'AdminController@logout' );
	Route::post( '/change_password', 'AdminController@change_password' );
	Route::post( '/edit_profile', 'AdminController@editProfile' );
## Config
	Route::get( '/config', 'ConfigController@show' );
	Route::put( '/config/{id}', 'ConfigController@update' );
## User
	Route::resource( 'user', 'UserController' );
	Route::get( '/user_status/{id}', 'UserController@status' );
## Category
	Route::resource( 'category', 'CategoryController' );
	Route::get( 'category/edit/{id}', 'CategoryController@edit' );
## Tag
	Route::resource( 'tag', 'TagController' );
	Route::get( '/tag/edit/{id}', 'TagController@edit' );
## Post
	Route::resource( 'post', 'PostController' );
	Route::get( '/post/add', 'PostController@add' );
	Route::get( '/post/edit/{id}', 'PostController@edit' );
	Route::get( '/post_status/{id}', 'PostController@status' );
## Contact
	Route::resource( 'contact', 'ContactController' );
} );

## Admin ----------
Route::post( 'admin/login', 'AdminController@login' );
Route::post( 'admin/forget', 'AdminController@forgetPassword' );
Route::post( 'admin/recover/{remember_token}', 'AdminController@recover' );
## User ----------
Route::post( '/user', 'UserController@store' );
Route::post( '/user/login', 'UserController@login' );
Route::post( '/user/forget', 'UserController@forgetPassword' );
Route::post( '/user/recover/{remember_token}', 'UserController@recover' );
## Category ----------
Route::resource( 'category', 'CategoryController', [ 'only' => [ 'index', 'show' ] ] );
## Contact ----------
Route::resource( 'contact', 'ContactController', [ 'only' => [ 'store' ] ] );
## Post ----------
Route::resource( 'post', 'PostController', [ 'only' => [ 'index', 'show' ] ] );
Route::get( '/cat_post/{cat_id}', 'PostController@cat_post' );
Route::get( '/tag_post/{tag_id}', 'PostController@tag_post' );
## Tag ----------
Route::resource( 'tag', 'TagController', [ 'only' => [ 'index', 'show' ] ] );


## Front 
// index
Route::get( '/', 'FrontController@index' );

// contact
Route::get( 'contact', 'FrontController@contact' );

// about
Route::get( 'about', 'FrontController@about' );

// news
Route::get( 'news', 'FrontController@news' );

// articles
Route::get( 'articles', 'FrontController@articles' );

// single post
Route::get( 'single_post/{id}', 'FrontController@single_post' );




<?php

Auth::routes();
Route::get( '/home', 'HomeController@index' )->name( 'home' );



Route::get( '/admin/edit_profile', function () {
	return view( 'admin.edit_profile' );
} );

Route::get( '/admin/category/edit', function () {
	return view( 'category.edit' );
} );

Route::get( '/admin/tag/edit', function () {
	return view( 'tag.edit' );
} );

Route::get( '/admin/poll/edit', function () {
	return view( 'poll.edit' );
} );

Route::get('/admin/section/edit',function(){
	return view('section.edit');
});

## post -----------------
Route::get( '/admin/post/edit', function () {
	return view( 'post.edit' );
} );
Route::get( '/admin/post/add', function () {
	return view( 'post.create' );
} );
## product --------------
Route::get( '/admin/product_cat/edit', function () {
	return view( 'shop.productCat.edit' );
} );

Route::get( '/admin/product/add', function () {
	return view( 'shop.product.create' );
} );
Route::get( '/admin/product/edit', function () {
	return view( 'shop.product.edit' );
} );

Route::get( '/admin/dashboard', function () {
	return view( 'dashboard' );
} );

Route::get( '/admin-panel', function () {
	return view( 'auth.login' );
} );


Route::group( [ 'prefix' => 'admin', 'middleware' => [ 'auth', 'admin' ] ], function () {

## Admin [Admin]
	Route::get( '/logout', 'AdminController@logout' );
	Route::post( '/change_password', 'AdminController@change_password' );
	Route::post( '/edit_profile', 'AdminController@editProfile' );

## User [Admin]
	Route::get( '/user', 'UserController@index' );
	Route::delete( '/user/{id}', 'UserController@destroy' );
	Route::get( '/logout', 'UserController@logout' );
	Route::post( '/user/change_password', 'UserController@change_password' );
	Route::post( '/user/edit_profile', 'UserController@editProfile' );
	Route::get( '/user/{id}', 'UserController@show' );
	Route::post( '/user/forget', 'UserController@forgetPassword' );
	Route::post( '/user/recover/{remember_token}', 'UserController@recover' );
	Route::get( '/user_status/{id}', 'UserController@status' );

## Section [Admin]
	Route::post( '/section', 'SectionController@store' );
	Route::put( '/section/{id}', 'SectionController@update' );
	Route::get( '/section/edit/{id}', 'SectionController@edit' );
	Route::delete( '/section/{id}', 'SectionController@destroy' );


	## Category [Admin]
	Route::post( '/category', 'CategoryController@store' );
	Route::put( '/category/{id}', 'CategoryController@update' );
	Route::get( '/category/edit/{id}', 'CategoryController@edit' );
	Route::delete( '/category/{id}', 'CategoryController@destroy' );


### Product Category [Admin]
	Route::post( '/product_cat', 'ProductCatController@store' );
	Route::put( '/product_cat/{id}', 'ProductCatController@update' );
	Route::get( '/product_cat/edit/{id}', 'ProductCatController@edit' );
	Route::delete( '/product_cat/{id}', 'ProductCatController@destroy' );

### Product [Admin]
	Route::get( '/product/add', 'ProductController@add' );
	Route::post( '/product', 'ProductController@store' );
	Route::get( '/product/edit/{id}', 'ProductController@edit' );
	Route::put( '/product/{id}', 'ProductController@update' );
	Route::delete( '/product/{id}', 'ProductController@destroy' );
	Route::get( '/product_status/{id}', 'ProductController@status' );

## Tag [Admin]
	Route::post( '/tag', 'TagController@store' );
	Route::get( '/tag/edit/{id}', 'TagController@edit' );
	Route::put( '/tag/{id}', 'TagController@update' );
	Route::delete( '/tag/{id}', 'TagController@destroy' );

## Post [Admin]
	Route::get( '/post/add', 'PostController@add' );
	Route::post( '/post', 'PostController@store' );
	Route::get( '/post/edit/{id}', 'PostController@edit' );
	Route::put( '/post/{id}', 'PostController@update' );
	Route::delete( '/post/{id}', 'PostController@destroy' );
	Route::get( '/post_status/{id}', 'PostController@status' );

## Contact [Admin]
	Route::get( '/contact', 'ContactController@index' );
	Route::delete( '/contact/{id}', 'ContactController@destroy' );

## Poll [Admin]
	Route::post( '/poll', 'PollController@store' );
	Route::put( '/poll/{id}', 'PollController@update' );
	Route::delete( '/poll/{id}', 'PollController@destroy' );
	Route::get( '/poll_status/{id}', 'PollController@status' );
	Route::get( '/poll/edit/{id}', 'PollController@edit' );

/***********************************************************************************/
	## Admin ----------
	Route::post( 'admin/login', 'AdminController@login' );
	Route::post( 'admin/forget', 'AdminController@forgetPassword' );
	Route::post( 'admin/recover/{remember_token}', 'AdminController@recover' );

## User ----------
	Route::post( '/user', 'UserController@store' );
	Route::post( '/user/login', 'UserController@login' );

## Section ----------
	Route::get( '/section', 'SectionController@index' );
	Route::get( '/section/{id}', 'SectionController@show' );

## Category ----------
	Route::get( '/category', 'CategoryController@index' );
	Route::get( '/category/{id}', 'CategoryController@show' );

### Product Category ----------
	Route::get( '/product_cat', 'ProductCatController@index' );
	Route::get( '/product_cat/{id}', 'ProductCatController@show' );

## Poll ----------
	Route::get( '/poll', 'PollController@index' );
	Route::get( '/poll/{id}', 'PollController@show' );

## Contact ----------
	Route::get( '/contact/{id}', 'ContactController@show' );
	Route::post( '/contact', 'ContactController@store' );

## Post ----------
	Route::get( '/post', 'PostController@index' );
	Route::get( '/post/{id}', 'PostController@show' );
	Route::get( '/cat_post/{cat_id}', 'PostController@cat_post' );
	Route::get( '/tag_post/{tag_id}', 'PostController@tag_post' );

### Product ----------
	Route::get( '/product', 'ProductController@index' );
	Route::get( '/product/{id}', 'ProductController@show' );
	Route::get( '/productCat_product/{productCat_id}', 'ProductController@cat_post' );


## Tag ----------
	Route::get( '/tag', 'TagController@index' );
	Route::get( '/tag/{id}', 'TagController@show' );
} );
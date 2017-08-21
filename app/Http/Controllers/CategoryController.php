<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\PostCategory;
use Validator;
use Illuminate\Http\Request;

class CategoryController extends Controller {
	public function index() {
		$categories = Category::where( 'id', '!=', 1 )->orderBy( 'id' )->get();

		return view( 'category.index', compact( 'categories' ) );
	}

	public function show( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:categories,id,deleted_at,NULL'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}
		$oneCat = Category::find( $id );

		return view( 'category.show', [ 'oneCat' => $oneCat ] );
	}

	public function store( Request $request ) {
		$validator = Validator::make( $request->all(), [
			'name'      => 'required|max:255',
			'parent_id' => 'nullable|numeric|max:255|exists:categories,id,deleted_at,NULL'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		if ( ! empty( $request->parent_id ) ) {
			$parent_id = $request->parent_id;
		} else {
			$parent_id = null;
		}

		$category = Category::create( [
			'name'      => $request->name,
			'parent_id' => $parent_id
		] );

		return back();
	}

	public function edit( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:categories,id,deleted_at,NULL',
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}


		$oneCat     = Category::find( $id );
		$categories = Category::where( 'id', '!=', 1 )->orderBy( 'id' )->get();

		return view( 'category.edit', compact( [ 'oneCat', 'categories' ] ) );
	}

	public function update( Request $request, $id ) {
		$request = array_add( $request, 'id', $id );

		$validator = Validator::make( $request->all(), [
			'id'        => 'required|numeric|exists:categories,id,deleted_at,NULL',
			'name'      => 'required|max:255',
			'parent_id' => 'nullable|numeric|max:255|exists:categories,id,deleted_at,NULL'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		$category              = Category::find( $id );
		$category->name        = $request->name;
		$category->parent_id = $request->parent_id;
		$category->update();

		return redirect( '/admin/category' );
	}

	public function destroy( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:categories,id,deleted_at,NULL'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}
		$category = Category::find( $id );
		$category->delete();

		$all_posts = PostCategory::where( 'cat_id', $category->id )->get();
		// delete category and change post cat_id
		$all_posts->map( function ( $item ) {
			$item->cat_id = 1;
			$item->update();
		} );

		return back();
	}

}

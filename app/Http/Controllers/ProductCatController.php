<?php

namespace App\Http\Controllers;

use App\Model\ProductCat;
use App\Model\ProductCategory;
use Illuminate\Http\Request;
use Validator;

class ProductCatController extends Controller {
	public function index( Request $request ) {
		$offset = $request->offset > 0 ? (int) $request->offset : 0;
		$mount  = $request->mount > 0 ? (int) $request->mount : 10;

		$categories = ProductCat::where('id','!=',1)->orderBy( 'id' )->get();
		//$count      = $categories->get()->count();
		//$categories = $categories->skip( $offset )->take( $mount )->get();

		return view( 'shop.productCat.index', compact( [ 'categories'] ) );
	}

	public function show( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:product_cats,id,deleted_at,NULL'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}
		$oneCat = ProductCat::find( $id );

		return view( 'shop.productCat.show', compact('oneCat' ) );
	}

	public function store( Request $request ) {
		$validator = Validator::make( $request->all(), [
			'name'      => 'required|max:255',
			'parent_id' => 'nullable|numeric|exists:product_cats,id,deleted_at,NULL',
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}
		$category = ProductCat::create( [
			'name'      => $request->name,
			'parent_id' => $request->parent_id
		] );

		return back();
	}

	public function edit( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:product_cats,id,deleted_at,NULL',
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		$categories = ProductCat::where('id','!=',1)->get();
		$oneCat     = ProductCat::find( $id );

		return view( 'shop.productCat.edit', compact(['categories' , 'oneCat' ] ) );
	}

	public function update( Request $request, $id ) {
		$request = array_add( $request, 'id', $id );

		$validator = Validator::make( $request->all(), [
			'id'        => 'required|numeric|exists:product_cats,id,deleted_at,NULL',
			'name'      => 'required|max:255',
			'parent_id' => 'nullable|numeric|exists:product_cats,id,deleted_at,NULL',
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		if($request->parent_id==$id){
			$parent_id = Null;
		}else{
			$parent_id =$request->parent_id;
		}

		$category            = ProductCat::find( $id );
		$category->name      = $request->name;
		$category->parent_id = $parent_id;
		$category->update();

		return redirect( '/admin/product_cat' );
	}

	public function destroy( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:product_cats,id,deleted_at,NULL'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}
		$category = ProductCat::find( $id );

		// get category child
		$category_childs = $category->GetChilds();

		$all_posts = ProductCategory::where( 'productCat_id', $category->id )->get();

		if ( count( $category_childs ) > 0 ) {
			$child_posts = ProductCategory::whereIn( 'productCat_id', $category_childs )->get();
			$category->DeleteChilds();

			$child_posts->map( function ( $item ) {
				$item->productCat_id = 1;
				$item->update();
			} );
		}
		// delete category and change post cat_id
		$category->delete();
		$all_posts->map( function ( $item ) {
			$item->productCat_id = 1;
			$item->update();
		} );

		return back();
	}
}

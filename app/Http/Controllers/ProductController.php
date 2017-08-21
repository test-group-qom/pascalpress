<?php

namespace App\Http\Controllers;

use App\Model\Post;
use App\Model\Product;
use App\Model\ProductCat;
use App\Model\ProductCategory;
use App\Model\Section;
use Illuminate\Http\Request;
use Validator;
use App\helper\jdf;

class ProductController extends Controller {
	public function index( Request $request ) {

		$order_type = strtolower( $request->order_type );
		if ( ! empty( $order_type ) && $order_type == 'visit' ) {
			$order_type = 'visit';
		} else {
			$order_type = 'created_at';
		}

		$offset = $request->offset > 0 ? (int) $request->offset : 0;
		$mount  = $request->mount > 0 ? (int) $request->mount : 10;

		$all_post = Product::orderBy( $order_type, 'desc' );
		$count    = $all_post->get()->count();
		$all_post = $all_post->skip( $offset )->take( $mount )->get();
		$all_post->map( function ( $item ) {
			//publish date
			$jdf                = new jdf();
			$list               = date_parse( $item->created_at );
			$item->publish_date = $jdf->gregorian_to_jalali( $list['year'], $list['month'], $list['day'], '/' );

			$item->productCat = $item->productCat->map( function ( $pcat ) {
				unset( $pcat->pivot );

				return $pcat->name;
			} );
			$item->productCat = $item->productCat->toArray();

		} );

		return view( 'shop.product.index', compact( [ 'all_post', 'count' ] ) );
	}

	public function show( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:products,id,deleted_at,NULL'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		$post = Product::where( 'id', $id )->where( 'status', 1 )->first();
		if ( $post == null ) {
			return response()->json( [ 'message' => 'not found!' ], 404 );
		}

		$post->visit += 1;
		$post->update();

		$post->productCat->map( function ( $item ) {
			unset( $item->pivot );
		} );


		return view( 'post.show', [ 'post' => $post ] );
	}

	public function add() {
		$categories = ProductCat::all();
		$sections   = Section::all();

		return view( 'shop.product.create', compact( [ 'categories', 'sections' ] ) );
	}

	public function store( Request $request ) {
		$validator = Validator::make( $request->all(), [
			'cat_id.*'     => 'required|numeric|exists:product_cats,id,deleted_at,NULL',
			'title'        => 'required|max:255',
			'thumb'        => 'nullable|max:2048',
			'content'      => 'required',
			'section_id.*' => 'nullable|numeric|exists:sections,id,deleted_at,NULL',
			//'price'    => 'required|numeric',
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		if ( empty( $request->thumb ) ) {
			$thumb = null;
		} else {
			$file = $request->file( 'thumb' );
			if ( $request->hasFile( 'thumb' ) && $file->isValid() ) {
				$fileName = $file->getClientOriginalName();
				$file->move( public_path( "/upload/images/" ), $fileName );
				$thumb = $fileName;
			}
		}

		$product = Product::create( [
			'title'   => $request->title,
			'thumb'   => $thumb,
			'content' => $request->input( 'content' ),
			'usage'   => $request->usage ,
			'price'   => $this->PersianToLatin( $request->price ),
		] );

		$product->productCat()->sync( $request->cat_id );

		// copy this post to another sections
		$section_ids = $request->section_id;
		foreach ( $section_ids as $item ) {
			Post::create( [
				'section_id' => $item,
				'title'      => $request->title,
				'thumb'      => $thumb,
				'content'    => $request->input( 'content' )
			] );
		}

		return redirect( '/admin/product' );
	}

	public function edit( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:products,id,deleted_at,NULL',
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		$post = Product::find( $id );
		$post->productCat->map( function ( $pcat ) {
			unset( $pcat->pivot );
		} );

		$categories = ProductCat::all();
		$sections   = Section::all();

		return view( 'shop.product.edit', compact( [ 'post', 'categories', 'sections' ] ) );
	}

	public function update( Request $request, $id ) {
		$request = array_add( $request, 'id', $id );

		$validator = Validator::make( $request->all(), [
			'id'       => 'required|numeric|exists:products,id,deleted_at,NULL',
			'cat_id.*' => 'required|numeric|exists:product_cats,id,deleted_at,NULL',
			'title'    => 'required|max:255',
			'thumb'    => 'nullable|max:255',
			'content'  => 'required',
			'price'    => 'required|numeric',
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		$post        = Product::find( $id );
		$post->title = $request->title;
		if ( $request->thumb !== null ) {
			$file = $request->file( 'thumb' );
			if ( $request->hasFile( 'thumb' ) && $file->isValid() ) {
				$fileName = $file->getClientOriginalName();
				$file->move( public_path( "/upload/images/" ), $fileName );
				$thumb       = $fileName;
				$post->thumb = $thumb;
			}
		}
		$post->content = $request->input( 'content' );
		$post->usage   = $request->usage;
		$post->price   = $request->price;
		$post->update();

		$post->productCat()->sync( $request->cat_id );

		return redirect( '/admin/product' );
	}

	public function destroy( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:products,id,deleted_at,NULL'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		$post = Product::find( $id );

		// post categories
		$cats = ProductCategory::where( 'product_id', $post->id )->get();
		$cats->map( function ( $item ) {
			$item->delete();
		} );

		$post->delete();

		return back();
	}

	public function status( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:products,id,deleted_at,NULL',
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}
		$post = Product::find( $id );
		if ( $post->status == 0 ) {
			$post->status = 1;
		} else {
			$post->status = 0;
		}

		$post->update();

		if ( $post->status == 1 ) {
			$status = 'activate';
		} else {
			$status = 'deactivated';
		}

		return back();
	}

	public function cat_product( Request $request, $productCat_id ) {
		$validator = Validator::make( [ 'cat_id' => $productCat_id ], [
			'cat_id' => 'required|numeric|exists:product_cats,id,deleted_at,NULL'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		$offset = $request->offset > 0 ? (int) $request->offset : 0;
		$mount  = $request->mount > 0 ? (int) $request->mount : 10;

		$category = ProductCategory::find( $productCat_id );
		$all_post = $category->products();
		$count    = $all_post->get()->count();
		$all_post = $all_post->skip( $offset )->take( $mount )->get();
		$all_post->map( function ( $item ) {
			unset( $item->pivot );
		} );

		return response( [ 'all_post' => $all_post, 'count' => $count ], 200 );
	}

	/**
	 * convert latin number to persian
	 *
	 * @param string $string
	 *   string that we want change number format
	 *
	 * @return formatted string
	 */
	function LatinToPersian( $string ) {
		//arrays of persian and latin numbers
		$persian_num = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' );//۲۳۵۰۰۰
		$latin_num   = range( 0, 9 );

		$string = str_replace( $latin_num, $persian_num, $string );

		return $string;
	}

	/**
	 * convert persian number to latin
	 *
	 * @param string $string
	 *   string that we want change number format
	 *
	 * @return formatted string
	 */
	function PersianToLatin( $string ) {
		//arrays of persian and latin numbers
		$persian_num = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' );
		$latin_num   = range( 0, 9 );

		$string = str_replace( $persian_num, $latin_num, $string );

		return $string;
	}
}

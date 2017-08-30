<?php

namespace App\Http\Controllers;

use App\Model\PostTag;
use App\Model\Tag;
use Illuminate\Http\Request;
use Validator;

class TagController extends Controller {

	public function index( Request $request ) {
		$offset = $request->offset > 0 ? (int) $request->offset : 0;
		$mount  = $request->mount > 0 ? (int) $request->mount : 10;
		$tags   = Tag::orderBy( 'created_at', 'desc' );
		$count  = $tags->get()->count();
		$tags   = $tags->skip( $offset )->take( $mount )->get();

		return view( 'admin.tag.index', [ 'tags' => $tags, 'count' => $count ] );
	}

	public function show( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:tags,id,deleted_at,NULL'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}
		$tag = Tag::find( $id );

		return view( 'admin.tag.show', [ 'tag' => $tag ] );
	}

	public function store( Request $request ) {
		$validator = Validator::make( $request->all(), [
			'name' => 'required|max:255',
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}
		$tag = Tag::create( [
			'name' => $request->name,
		] );

		return back();
	}

	public function edit( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:tags,id,deleted_at,NULL',
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		$tag = Tag::find( $id );

		return view( 'admin.tag.edit', [ 'tag' => $tag ] );
	}

	public function update( Request $request, $id ) {
		$request = array_add( $request, 'id', $id );

		$validator = Validator::make( $request->all(), [
			'id'   => 'required|numeric|exists:tags,id,deleted_at,NULL',
			'name' => 'required|max:255'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		$tag       = Tag::find( $id );
		$tag->name = $request->name;
		$tag->update();

		return redirect('/admin/tag');
	}

	public function destroy( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:tags,id,deleted_at,NULL'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}
		$tag = Tag::find( $id );

		// tags posts
		$posts = PostTag::where( 'tag_id', $tag->id )->get();
		$posts->map( function ( $item ) {
			$item->delete();
		} );

		$tag->delete();

		return back();
	}
}

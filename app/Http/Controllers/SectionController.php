<?php

namespace App\Http\Controllers;

use App\Model\Post;
use App\Model\Section;
use Illuminate\Http\Request;
use Validator;

class SectionController extends Controller {
	public function index( Request $request ) {
		$offset = $request->offset > 0 ? (int) $request->offset : 0;
		$mount  = $request->mount > 0 ? (int) $request->mount : 10;

		$sections = Section::orderBy( 'id' );
		$count    = $sections->get()->count();
		$sections = $sections->skip( $offset )->take( $mount )->get();

		return view( 'section.index', compact( [ 'sections', 'count' ] ) );
	}

	public function show( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:sections,id,deleted_at,NULL'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}
		$section = Section::find( $id );

		return view( 'section.show', compact( 'section' ) );
	}

	public function store( Request $request ) {
		$validator = Validator::make( $request->all(), [
			'name' => 'required|max:255'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		Section::create( [
			'name' => $request->name
		] );

		return back();
	}

	public function edit( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:sections,id,deleted_at,NULL',
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}


		$section = Section::find( $id );

		return view( 'section.edit', compact( 'section' ) );
	}

	public function update( Request $request, $id ) {
		$request = array_add( $request, 'id', $id );

		$validator = Validator::make( $request->all(), [
			'id'   => 'required|numeric|exists:sections,id,deleted_at,NULL',
			'name' => 'required|max:255'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		$section              = Section::find( $id );
		$section->name        = $request->name;
		$section->update();

		return redirect( '/admin/section' );
	}

	public function destroy( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:sections,id,deleted_at,NULL'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}
		$section = Section::find( $id );
		$section->delete();
/*
		$all_posts = Post::where( 'section_id', $id )->get();
		// change posts section
		$all_posts->map( function ( $item ) {
			$item->section_id = 1;
			$item->update();
		} );*/

		return back();
	}
}

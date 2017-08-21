<?php

namespace App\Http\Controllers;

use App\Model\Contact;
use Illuminate\Http\Request;
use Validator;

class ContactController extends Controller {
	public function index( Request $request ) {
		$offset      = $request->offset > 0 ? (int) $request->offset : 0;
		$mount       = $request->mount > 0 ? (int) $request->mount : 10;
		$all_contact = Contact::orderBy( 'created_at', 'desc' );
		$count       = $all_contact->get()->count();
		$all_contact = $all_contact->skip( $offset )->take( $mount )->get();

		return view('contact.index', [ 'all_contact' => $all_contact, 'count' => $count ]);
	}

	public function show( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:contacts,id,deleted_at,NULL'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}
		$contact = Contact::find( $id );

		return view('contact.show', ['contact'=>$contact] );
	}

	public function store( Request $request ) {
		$validator = Validator::make( $request->all(), [
			'name'    => 'required|min:3|max:255',
			'email'   => 'required|email',
			'mobile'  => 'required|numeric|digits:11',
			'message' => 'required|min:5|max:4000'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}
		$contact = Contact::create( [
			'name'    => $request->name,
			'email'   => $request->email,
			'mobile'  => $request->mobile,
			'message' => $request->message
		] );

		return redirect( '/contact' );
	}

	public function destroy( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:contacts,id,deleted_at,NULL'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}
		$contact = Contact::find( $id );
		$contact->delete();

		return back();
	}
}

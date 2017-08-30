<?php

namespace App\Http\Controllers;

use App\Model\Config;
use Illuminate\Http\Request;
use Validator;

class ConfigController extends Controller {
	protected $id = 1;

	public function show() {
		$config = Config::find( $this->id );

		return view( 'admin.config', compact( 'config' ) );
	}
	
	public function update( Request $request, $id ) {
		$request   = array_add( $request, 'id', $id );
		$validator = Validator::make( $request->all(), [
			'title'       => 'required|min:5|max:255',
			'description' => 'nullable|max:255',
			'keyword'     => 'nullable|max:4000',
			'copyright'   => 'nullable|max:255',
			'info'        => 'nullable|max:4000',
		] );
		if ( $validator->fails() ) {
			return back( 302 )->with( [ 'errors' => $validator->errors() ] );
		}

		$config              = Config::find( $id );
		$config->title       = $request->title;
		$config->description = $request->description;
		$config->keyword     = $request->keyword;
		$config->copyright   = $request->copyright;
		$config->info        = $request->info;
		$config->update();

		return redirect( '/admin/config', 302 );
	}
}

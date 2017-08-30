<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller {

	public function index( Request $request ) {
		$offset   = $request->offset > 0 ? (int) $request->offset : 0;
		$mount    = $request->mount > 0 ? (int) $request->mount : 10;
		$all_user = User::where('id', '!=' , 1)->orderBy( 'created_at', 'desc' );
		$count    = $all_user->get()->count();
		$all_user = $all_user->skip( $offset )->take( $mount )->get();
		$all_user->map( function ( $item ) {
			unset( $item->token );
		} );

		return view( 'admin.user.index', [ 'all_user' => $all_user, 'count' => $count ] );
	}

	public function show( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:users,id,deleted_at,NULL'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		$user = User::find( $id );
		unset( $user->token );


		return view('user.show', [ 'user' => $user ]);
	}

	public function store( Request $request ) {
		$validator = Validator::make( $request->all(), [
			'name'         => 'required|min:3|max:64',
			'father_name'  => 'required|min:3|max:64',
			'username'     => 'required|min:4|unique:users',
			'password'     => 'required|min:6|max:32',
			'email'        => 'required|email|unique:users',
			'mobile'       => 'required|numeric|digits:11|unique:users,mobile',
			'city'         => 'required|min:2',
			'card_number'  => 'required|numeric|digits:16',
			'reagent_code' => 'nullable|numeric|digits:8',
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		if ( ! empty( $request->reagent_code ) ) {
			$reagent_code = $request->reagent_code;
		} else {
			$reagent_code = null;
		}

		$user = User::create( [
			'name'         => $request->name,
			'father_name'  => $request->father_name,
			'username'     => $request->username,
			'password'     => bcrypt( $request->password ),
			'email'        => $request->email,
			'mobile'       => $request->mobile,
			'city'         => $request->city,
			'card_number'  => $request->card_number,
			'reagent_code' => $reagent_code,
		] );

		return response()->json( [ 'status_code' => '200', 'user' => $user ], 200 );
	}

	public function destroy( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:users,id,deleted_at,NULL'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		$user = User::find( $id );
		$user->delete();

		return back();
	}

	public function login( Request $request ) {
		$validator = Validator::make( $request->all(), [
			'username' => 'required|min:3|exists:users,username,deleted_at,NULL',
			'password' => 'required|min:6',
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}
/*
		$user = User::where( 'username', $request->username )->where( 'status', 1 )->first();

		if ( $user == null ) {
			return response()->json( [ 'status_code' => 404, 'user' => 'Not Found!' ], 404 );
		}

		if ( ! Hash::check( $request->password, $user->password ) ) {
			return response()->json( [ 'status_code' => 422, 'message' => 'the password is incorrect' ], 422 );
		}

		if ( $user->token == null ) {
			$user->token = $this->TokenGenerator( 64 );
		}

		$user->update();
*/
		return redirect()->route('home');
	}

	public function logout( ) {//$admin
		auth()->logout();
		return redirect('/admin-panel');
	}

	
	public function forgetPassword( Request $request ) {
		$validator = Validator::make( $request->all(), [
			'email' => 'required|email|exists:users,email,deleted_at,NULL',
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		$user                 = User::where( 'email', $request->email )->first();
		$user->remember_token = $this->TokenGenerator( 64 );
		$user->update();

		return response()->json( [ 'remember_token' => $user->remember_token, 'status_code' => 200 ], 200 );
	}

	public function recover( Request $request, $remember_token ) {
		$request = array_add( $request, 'remember_token', $remember_token );

		$validator = Validator::make( $request->all(), [
			'remember_token'        => 'required|exists:users,remember_token,deleted_at,NULL',
			'password'              => 'required|min:6|confirmed',
			'password_confirmation' => 'required|min:6',
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		$user                 = User::where( 'remember_token', $request->remember_token )->first();
		$user->remember_token = null;
		$user->password       = bcrypt( $request->password );
		$user->update();

		return response()->json( [
			'status_code' => 200,
			'message'     => 'Your password has been successfully changed!'
		], 200 );
	}

	public function change_password( Request $request, $user ) {
		$validator = Validator::make( $request->all(), [
			'password'              => 'required|min:6|confirmed',
			'password_confirmation' => 'required|min:6',
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		$user->password = bcrypt( $request->password );
		$user->update();

		return response()->json( [
			'status_code' => 200,
			'message'     => 'Your password has been successfully changed!'
		], 200 );
	}

	public function editProfile( Request $request, $user ) {
		$validator = Validator::make( $request->all(), [
			'name'        => 'nullable|min:3|max:255',
			'father_name' => 'nullable|min:3|max:255',
			'email'       => 'nullable|email|unique:users',
			'mobile'      => 'nullable|numeric|digits:11|unique:users',
			'city'        => 'nullable|min:2',
			'card_number' => 'nullable|numeric|digits:16',
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		if ( empty( $request->name ) && empty( $request->father_name ) && empty( $request->email && empty( $request->mobile ) && empty( $request->city ) && empty( $request->card_number ) ) ) {
			return response()->json( [ 'message' => 'your profile was not update.', 'status_code' => 422 ], 422 );
		}

		if ( ! empty( $request->name ) ) {
			$user->name = $request->name;
		}
		if ( ! empty( $request->father_name ) ) {
			$user->father_name = $request->father_name;
		}
		if ( ! empty( $request->email ) ) {
			$user->email = $request->email;
		}
		if ( ! empty( $request->mobile ) ) {
			$user->mobile = $request->mobile;
		}
		if ( ! empty( $request->city ) ) {
			$user->city = $request->city;
		}
		if ( ! empty( $request->card_number ) ) {
			$user->card_number = $request->card_number;
		}

		$user->update();

		return response()->json( [ 'user' => $user, 'status_code' => 200 ], 200 );
	}

	public function status( $id ) {
		$validator = Validator::make( ['id'=>$id], [
			'id' => 'required|numeric|exists:users,id,deleted_at,NULL',
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		$user         = User::find( $id );
		if($user->status == 0){
			$user->status = 1;
		}else{
			$user->status = 0;
		}

		$user->update();

		return back();
	}

	public function TokenGenerator( $len ) {
		$characters   = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charLenght   = strlen( $characters );
		$randomString = '';
		for ( $i = 0; $i < $len; $i ++ ) {
			$randomString .= $characters[ rand( 0, $charLenght - 1 ) ];
		}

		return $randomString;
	}
}

<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Session;
use Illuminate\Support\Facades\View;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AdminController extends Controller {

	public function login( Request $request ) {
		$validator = Validator::make( $request->all(), [
			'username' => 'required|min:3|exists:users,username',
			'password' => 'required|min:6',
		] );
		if ( $validator->fails() ) {
			return back(302)->with( [ 'errors' => $validator->errors() ] );
		}

		return redirect()->route('home');
	}

	public function logout() {
		auth()->logout();
		return redirect('/admin-panel',302);
	}

	public function forgetPassword( Request $request ) {
		$validator = Validator::make( $request->all(), [
			'email' => 'required|email|exists:admins',
		] );
		if ( $validator->fails() ) {
			return back(302)->with( [ 'errors' => $validator->errors() ] );
		}

		$admin                 = Admin::where( 'email', $request->email )->first();
		$admin->remember_token = $this->TokenGenerator( 64 );
		$admin->update();

		return response()->json( [ 'remember_token' => $admin->remember_token, 'status_code' => 200 ], 200 );
	}

	public function recover( Request $request, $remember_token ) {
		$request = array_add( $request, 'remember_token', $remember_token );

		$validator = Validator::make( $request->all(), [
			'remember_token'        => 'required|exists:admins',
			'password'              => 'required|min:6|confirmed',
			'password_confirmation' => 'required|min:6',
		] );
		if ( $validator->fails() ) {
			return back(302)->with( [ 'errors' => $validator->errors() ] );
		}

		$admin                 = Admin::where( 'remember_token', $request->remember_token )->first();
		$admin->remember_token = null;

		return $this->ChangePassword( $request, $admin );
	}

	public function change_password( Request $request, $admin ) {
		return $this->ChangePassword( $request, $admin );
	}

	public function editProfile( Request $request, $admin ) {
		$validator = Validator::make( $request->all(), [
			'email'  => 'nullable|email|unique:admins',
			'mobile' => 'nullable|numeric|digits:11',
		] );
		if ( $validator->fails() ) {
			return back(302)->with( [ 'errors' => $validator->errors() ] );
		}

		if ( empty( $request->name ) && empty( $request->email && empty( $request->mobile ) ) ) {
			return response()->json( [ 'message' => 'your profile was not update.', 'status_code' => 422 ], 422 );
		}

		if ( ! empty( $request->name ) ) {
			$admin->name = $request->name;
		}
		if ( ! empty( $request->email ) ) {
			$admin->email = $request->email;
		}
		if ( ! empty( $request->mobile ) ) {
			$admin->mobile = $request->mobile;
		}

		$admin->update();

		return response()->json( [ 'message' => 'your profile was updated.', 'status_code' => 200 ], 200 );
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

	public function ChangePassword( Request $request, $user ) {
		$validator = Validator::make( $request->all(), [
			'password'              => 'required|min:6|confirmed',
			'password_confirmation' => 'required|min:6',
		] );
		if ( $validator->fails() ) {
			return back(302)->with( [ 'errors' => $validator->errors() ] );
		}

		$user->password = bcrypt( $request->password );
		$user->update();

		return response()->json( [
			'status_code' => 200,
			'message'     => 'Your password has been successfully changed!'
		], 200 );


	}

}

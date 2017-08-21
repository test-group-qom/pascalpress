<?php
namespace App\Http\Middleware;

use App\Model\Admin;
use App\Model\User;
use Closure;

class AdminAuth {

	public function handle( $request, Closure $next ) {

		if ( $request->headers->has( 'token' ) == true ) {

			$token = $request->header( 'token' );
			$admin = Admin::where( 'token', $token )->first();
			if ( ! empty( $token ) && ! empty( $admin ) ) {
				$request->route()->setParameter( 'admin', $admin );

				return $next( $request );
			}

		} elseif ( $request->headers->has( 'user-token' ) == true ){

			$token = $request->header( 'user-token' );
			$user  = User::where( 'status', 1 )->where( 'token', $token )->first();
			if ( ! empty( $token ) && ! empty( $user ) ) {
				$request->route()->setParameter( 'user', $user );

				return $next( $request );
			}

		}

		return response()->json( [ 'message' => 'authentication failed!', 'status_code' => 401 ], 401 );


	}
}
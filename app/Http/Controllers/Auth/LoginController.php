<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function login(Request $request){
        $user = $request->all(); 
        if (Auth::check(['email' => $user['email'], 'password' => $user['password']])) {
            return response([
                'status' => Response::HTTP_OK,
                'response_time' => microtime(true) - LARAVEL_START,
                'user' => App\User::all()
            ],Response::HTTP_OK);
        }

        return response([
            'status' => Response::HTTP_BAD_REQUEST,
            'response_time' => microtime(true) - LARAVEL_START,
            'error' => 'Wrong email or password',
            'request' => $request->all()
        ],Response::HTTP_BAD_REQUEST);

    }
}

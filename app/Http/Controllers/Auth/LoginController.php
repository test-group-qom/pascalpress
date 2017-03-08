<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use Illuminate\Support\Facades\Hash;

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

    // ...these are for api authentication............................
    public function login(Request $request){
        $u = User::where('email',$request->input('email'))->get();
        $user=$u->first();
        if(Hash::check($request->input('password'),$user->password)){
            return response([
                'status' => Response::HTTP_OK,
                'response_time' => microtime(true) - LARAVEL_START,
                'api_token' => $user->api_token
            ],Response::HTTP_OK);
        }

        return response([
            'status' => Response::HTTP_BAD_REQUEST,
            'response_time' => microtime(true) - LARAVEL_START,
            'error' => 'Wrong email or password',
            'request' => $request->all()
        ],Response::HTTP_BAD_REQUEST);

    }

     public function logout(Request $request) {
        $user = &$request->client;        
        $user->api_token=NULL;
        //$user->update();
        return 'Logged out';
    }
}

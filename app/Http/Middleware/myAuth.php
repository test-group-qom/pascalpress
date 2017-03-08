<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class myAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       $request->client=null;
       $token=$request->header('token');
       if(!empty($token) && $user=User::where('api_token','=',$token)->get()->first()){
           if(!empty($user)){
               $request->client=$user;
               return $next($request);
           }
       }
       return response('Access denied! You are not logged in',401);
    }
}

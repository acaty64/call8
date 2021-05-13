<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class HostMiddleware
{
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        if(!Auth::check()){
            Auth::logout();
            return redirect()->to('login');
        };
        if($this->auth->user()->is_admin || $this->auth->user()->is_host ){
	        return $next($request);
        }
        throw new AuthorizationException;
        // return response()->view('errors.forbidden', [], 403);
        // return redirect()->to('home');
    }
}

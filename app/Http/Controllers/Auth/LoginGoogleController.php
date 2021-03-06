<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginGoogleController extends Controller
{
	public function redirect()
	{
	    return Socialite::driver('google')->redirect();
	}

	public function callback()
	{
	    $user = Socialite::driver('google')->user();

	    $email = $user->getEmail();

		$domain = substr($email, strpos($email, '@')+1);

		if ( $domain == 'ucss.edu.pe' || $domain = 'ucss.pe' )
		{
		    $userLogued = User::where('email', $email)->first();

		    if(!$userLogued){
				$userLogued = User::create([
					'email' => $user->getEmail(),
					'name' => $user->getName(),
					'given_name' => $user->user['given_name'],
					'code' => substr(substr($user->email, 0, strpos($user->email, '@')), 0, 11),
				]);
				if(!$userLogued){
					throw new AuthorizationException;
				}

		    }

		    Auth::login($userLogued, true);

		    if(Auth::user()->is_master){
		    	return redirect(route('master.menu'));
		    }

		    if(Auth::user()->is_admin){
		    	return redirect(route('admin.menu'));
		    }

		    if(Auth::user()->is_host){
		    	return redirect(route('call.host'));
		    }

	    	return redirect(route('call.client'));
		}

    	return redirect(route('login.google'));

	}

}

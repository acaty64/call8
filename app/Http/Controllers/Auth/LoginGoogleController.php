<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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

	    $userLogued = User::where('email', $email)->first();
	    Auth::login($userLogued, true);

	    return redirect(route('home'));
	}

}

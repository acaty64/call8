<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
	public function master()
	{
		return view('app.menu.master');
	}

	public function admin()
	{
		return view('app.menu.admin');
	}
}

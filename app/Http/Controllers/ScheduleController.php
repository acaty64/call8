<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScheduleController extends Controller
{
	public function index()
	{
		return view('app.admin.schedule');
	}

	public function crud()
	{
		return view('app.schedule.crud');
	}
}

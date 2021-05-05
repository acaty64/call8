<?php

namespace App\Http\Controllers;

use App\Http\Traits\WindowTrait;
use App\Models\User;
use App\Models\Window;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use WindowTrait;

    public function stopWindow($window_id)
    {
    	$window = Window::find($window_id);
    	$response = $this->window_stop($window_id);
    	return $response;
    }

    public function sendStop()
    {
    	$response = $this->window_stop($window_id);
    	return $response;
    }
}

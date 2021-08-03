<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Trace;
use App\Models\Window;
use Illuminate\Http\Request;

class WindowController extends Controller
{
    public function index()
    {
        return view('app.window.index');
    }

    public function stop()
    {
        return view('app.host.stop');
    }


}

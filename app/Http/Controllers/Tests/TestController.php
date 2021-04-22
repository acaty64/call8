<?php

namespace App\Http\Controllers\Tests;

use App\Events\Test1Event;
use App\Events\Test2Event;
use App\Events\Test3Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function data()
    {
        return ['Primer mensaje', 'Segundo mensaje'];
    }

    public function send3(Request $request)
    {
        broadcast(new Test3Event($request->data));
        return response()->json($request->data);
    }

    public function send1(Request $request)
    {
        // event(new Test1Event($request->data));
        broadcast(new Test1Event($request->data));
        return response()->json($request->data);
    }


    public function send2(Request $request)
    {
        broadcast(new Test2Event($request->data));
        return response()->json($request->data);
    }

}

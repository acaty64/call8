<?php

namespace App\Http\Controllers;

use App\Models\Call;
use App\Models\Status;
use App\Models\Trace;
use App\Models\User;
use Illuminate\Http\Request;

class CallController extends Controller
{

    public function client()
    {
        return view('app.client.screen');
    }

    public function host()
    {
        return view('app.host.screen');
    }

    public function index()
    {
        $calls = Call::all()->sortByDesc('id');
        return view('app.call.index')->with([
            'data' => $calls
        ]);
    }

    public function stop()
    {
        return view('app.client.stop');
    }


}

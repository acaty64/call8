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
        $data = Window::all();
        return view('app.window.index')->with('data', $data);
    }

    public function open()
    {
        $host_id = \Auth::user()->id;

        $status_id = Status::where('status', 'En Pausa')->first()->id;

        $window = Window::where('host_id', $host_id)->first();
        if(!$window)
        {
            $status_close = Status::where('status', 'Cerrado')->first()->id;
            $window = Window::where('status_id', $status_close)->first();
            $window->host_id = $host_id;
            $window->status_id = $status_id;
            $window->save();
        }
        Trace::new_window($window);

        return $window;

    }

    public function free(Request $request)
    {
        $host_id = \Auth::user()->id;
        $status_id = Status::where('status', 'Libre')->first()->id;
        $window = Window::where('host_id', $host_id)->first();
        $window->status_id = $status_id;
        $window->save();

        Trace::new_window($window);

        return $window;
    }

    public function hang(Request $request)
    {
        $host_id = \Auth::user()->id;
        $status_id = Status::where('status', 'En Pausa')->first()->id;
        $window = Window::where('host_id', $host_id)->first();
        $window->status_id = $status_id;
        $window->save();

        Trace::new_window($window);

        return $window;
    }

    public function close(Request $request)
    {
        $host_id = \Auth::user()->id;
        $status_id = Status::where('status', 'Cerrado')->first()->id;
        $window = Window::where('host_id', $host_id)->first();
        $window->status_id = $status_id;
        $window->save();

        Trace::new_window($window);

        return $window;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Traits;

use App\Models\Call;
use App\Models\Status;
use App\Models\Trace;
use App\Models\Window;


trait WindowTrait {

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


    public function free()
    {
        $host_id = \Auth::user()->id;
        $status_id = Status::where('status', 'Libre')->first()->id;
        $window = Window::where('host_id', $host_id)->first();
        $window->status_id = $status_id;
        $window->save();

        Trace::new_window($window);

        return $window;
    }

    public function start()
    {
        $host = \Auth::user();
        $host_id = $host->id;

        $status_paused = Status::where('status', 'En Pausa')->first()->id;
        $call = Call::where('status_id', $status_paused)->first();

        $status_id = Status::where('status', 'Llamando')->first()->id;

        $call->status_id = $status_id;
        $call->save();

        $window = Window::findOrFail($host->window_id);
        $window->status_id = $status_id;
        $window->client_id = $call->user_id;
        $window->call_id = $call->id;

        $window->save();

        Trace::new_window($window);

        return $window;

    }

    public function stop()
    {
        $host = \Auth::user();
        $host_id = $host->id;

        $window = Window::findOrFail($host->window_id);
        $call = Call::findOrFail($window->call_id)->first();

        $status_close = Status::where('status', 'Cerrado')->first()->id;

        $call->status_id = $status_close;
        $call->save();

        $trace = $window;

        $status_id = Status::where('status', 'En Pausa')->first()->id;
        $window->client_id = null;
        $window->call_id = null;
        $window->status_id = $status_id;
        $window->save();

        $trace->status_id = $status_close;
        Trace::new_window($trace);

        return $window;

    }

    public function close($request)
    {
        $host_id = \Auth::user()->id;
        $status_id = Status::where('status', 'Cerrado')->first()->id;
        $window = Window::where('host_id', $host_id)->first();
        $window->host_id = null;
        $window->client_id = null;
        $window->status_id = $status_id;
        $window->save();

        $trace = $window;
        $trace->host_id = $host_id;
        Trace::new_window($trace);

        return $window;
    }

}
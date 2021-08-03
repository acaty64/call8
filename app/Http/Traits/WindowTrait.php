<?php

namespace App\Http\Traits;

use App\Events\Ring2Event;
use App\Models\Call;
use App\Models\Status;
use App\Models\Trace;
use App\Models\User;
use App\Models\Window;


trait WindowTrait {

	public function window_open()
    {
        $host_id = \Auth::user()->id;

        $status_id = Status::where('status', 'En Pausa')->first()->id;

        $win = new Window;
        $win->host_id = $host_id;
        if($win->office_now)
        {
            $window = Window::where('host_id', $host_id)->first();
            if(!$window)
            {
                $status_close = Status::where('status', 'Cerrado')->first()->id;
                $window = Window::where('status_id', $status_close)->first();
                $window->host_id = $host_id;
                $window->status_id = $status_id;
                $window->office_id = $win->office_now->office_id;
                $window->mensaje = 'Módulo abierto';
                $window->save();
            }
            Trace::new_window($window);
            return $window;
        }
        return false;
    }

    public function window_free()
    {
        $host_id = \Auth::user()->id;

        $status_id = Status::where('status', 'Libre')->first()->id;
        $window = Window::where('host_id', $host_id)->first();
        $window->status_id = $status_id;
        $window->mensaje = 'Operador Libre';
        $window->save();

        Trace::new_window($window);

        return $window;
    }

    public function window_start()
    {
        $host = \Auth::user();
        $host_id = $host->id;

        $status_paused = Status::where('status', 'En Pausa')->first()->id;
        $call = Call::where('status_id', $status_paused)
                    ->where('office_id', $host->window->office_id)
                    ->first();
        if(!$call){
            $window = $host->window;
            $window->mensaje = 'No hay llamadas en espera.' ;
            $window->save();
            return $window;
        }

        $status_id = Status::where('status', 'Llamando')->first()->id;

        $call->status_id = $status_id;
        $call->save();

        $window = Window::findOrFail($host->window_id);
        $window->status_id = $status_id;
        $window->client_id = $call->client_id;
        $window->call_id = $call->id;
        $window->mensaje = 'Llamando a ' . $window->client->name ;
        $window->save();

        Trace::new_window($window);

        $response = broadcast(new Ring2Event([
            'window_id' => $window->id,
            'host_id' => $window->host_id,
            'client_id' => $window->client_id,
            'call_id' => $window->call_id,
            'message' => 'Llamando a ' . $window->client->name
        ]));

        return $window;

    }

    public function window_stop($user_id)
    {
        $host = User::findOrFail($user_id);

        $window = Window::findOrFail($host->window_id);
        $trace = $window;

        $call = Call::findOrFail($window->call_id);

        $status_close = Status::where('status', 'Cerrado')->first();

        $call->status_id = $status_close->id;
        $call->save();

        $status_paused = Status::where('status', 'En Pausa')->first();
        $window->status_id = $status_paused->id;
        $window->mensaje = 'Llamada terminada por operador ' . $host->name;
        $window->save();

        $trace->status_id = $status_close->id;
        Trace::new_window($trace);

        $response = broadcast(new Ring2Event([
                'window_id' => $window->id,
                'host_id' => $window->host_id,
                'client_id' => $window->client_id,
                'call_id' => $window->call_id,
                'message' => 'Llamada terminada por operador ' . $host->name
            ]));

        $window = Window::findOrFail($host->window_id);
        $window->client_id = null;
        $window->save();
        return $window;

    }

    public function window_paused()
    {
        $host = \Auth::user();
        $host_id = $host->id;

        $status_id = Status::where('status', 'En Pausa')->first()->id;
        $window = Window::where('host_id', $host_id)->first();
        $window->client_id = null;
        $window->status_id = $status_id;
        $window->save();

        Trace::new_window($window);

        return $window;

    }

    public function window_out($host_id=null)
    {
        if($host_id == null){
            $host = \Auth::user();
            $host_id = $host->id;
        }
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
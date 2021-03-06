<?php

namespace App\Http\Traits;

use App\Events\Ring2Event;
use App\Events\RingEvent;
use App\Models\Call;
use App\Models\Status;
use App\Models\Trace;
use App\Models\User;
use App\Models\Window;

trait CallTrait
{

    public function call_open($office_id)
    {
        $client = \Auth::user();

        $status = Status::where('status', 'En Pausa')->first();

        $call = Call::where('client_id', $client->id)
                    ->where('status_id', $status->id)
                    ->where('office_id', $office_id)
                    ->first();
        if(!$call){
            $call = Call::create([
                'client_id' => $client->id,
                'status_id' => $status->id,
                'office_id' => $office_id,
            ]);

            $call->number = $call->number_today();
            $call->save();
        }

        $check = Trace::new_call($call);

        // $response = broadcast(new Ring2Event([
        //     'window_id'=> null,
        //     'host_id' => null,
        //     'client_id' => $client->id,
        //     'call_id' => $call->id,
        //     'office_id' => $office_id,
        //     'message' => 'Usuario en Espera.'
        // ]));
        $response = broadcast(new RingEvent([
            'message' => 'Usuario en Espera.'
        ]));

        if(!$check){
            return 'Error';
        }

        return $call;

    }

    public function call_answer($call_id)
    {
        $client = \Auth::user();

        $status_answer = Status::where('status', 'Atendiendo')->first();

        $call = Call::findOrFail($call_id);

        $window = Window::where('call_id', $call->id)->first();

        $call->status_id = $status_answer->id;
        $call->save();

        $window->status_id = $status_answer->id;
        $window->mensaje = 'Respondiendo llamada.';
        $window->save();

        $check = Trace::new_call($call);

        $response = broadcast(new Ring2Event([
            'window_id' => $window->id,
            'host_id' => $window->host_id,
            'client_id' => $window->client_id,
            'call_id' => $window->call_id,
            'message' => 'Respondiendo llamada.'
        ]));

        return $call;

    }

    public function call_close()
    {
        $client = \Auth::user();

        $status_closed = Status::where('status', 'Cerrado')->first();
        $status_paused = Status::where('status', 'En Pausa')->first();

        if($client->window)
        {
            $call = Call::findOrFail($client->window->call_id);
            $call->status_id = $status_closed->id;
            $call->save();
            $call_id = $call->id;

            $window = Window::where('client_id', $client->id)->first();
            $window->status_id = $status_paused->id;
            $window->client_id = null;
            $window->mensaje = 'Llamada terminada por usuario ' . $client->name;
            $window->call_id = null;
            $window->save();
        }else{
            $call = Call::where('client_id', $client->id)
                    ->where('status_id','!=', $status_closed)
                    ->first();
            $call_id = $call->id;
            $call->status_id = $status_closed->id;
            $call->save();
            $window_id = null;
            $window = new Window;
        }
        $response = broadcast(new Ring2Event([
            'window_id' => $window->id,
            'host_id' => $window->host_id,
            'client_id' => $window->client_id,
            'call_id' => $call_id,
            'message' => 'Llamada terminada por usuario ' . $client->name
            ]));
        $check = Trace::new_call($call);

        if(!$check){
            return 'Error';
        }
        return true;

    }

    public function call_out($call_id)
    {
        $call = Call::findOrFail($call_id);

        $status_closed = Status::where('status', 'Cerrado')->first();

        $call->status_id = $status_closed->id;
        $call->save();

        if($call->window){
            $window = $call->window;
            $window->message = 'Llamada terminada por usuario ' . \Auth::user()->name;
            $window->call_id = null;
            $window->save();
        }

        $data_event = [
            'window_id' => ($call->window) ? $window->id : null,
            'host_id' => \Auth::user()->id,
            'client_id' => $call->user_id,
            'call_id' => $call->id,
            'message' => 'Llamada terminada por usuario ' . \Auth::user()->name
            ];

        $response = broadcast(new Ring2Event($data_event));
        $check = Trace::new_call($call);

        if(!$check){
            return 'Error';
        }

        return true;

    }
}


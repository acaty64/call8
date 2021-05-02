<?php

namespace App\Http\Traits;

use App\Events\Ring2Event;
use App\Models\Call;
use App\Models\Status;
use App\Models\Trace;
use App\Models\User;
use App\Models\Window;

trait CallTrait
{

    public function call_open()
    {
        $client = \Auth::user();

        $status = Status::where('status', 'En Pausa')->first();

        $call = Call::where('user_id', $client->id)
                ->where('status_id', $status->id)
                ->first();
        if(!$call){
            $call = Call::create([
                'user_id' => $client->id,
                'status_id' => $status->id,
            ]);

            $call->number = $call->number_today();
            $call->save();
        }

        $check = Trace::new_call($call);

        $response = broadcast(new Ring2Event('Usuario en Espera.'));

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

        $response = broadcast(new Ring2Event('Respondiendo llamada.'));

        return $call;

    }

    public function call_close()
    {

        $client = \Auth::user();

        $status_closed = Status::where('status', 'Cerrado')->first();
        $status_paused = Status::where('status', 'En Pausa')->first();

        $call = Call::findOrFail($client->window->call_id);
        $call->status_id = $status_closed->id;
        $call->save();

        $window = Window::where('client_id', $client->id)->first();
        $window->status_id = $status_paused->id;
        $window->client_id = null;
        $window->mensaje = 'Llamada terminada por usuario ' . $client->name;
        $window->call_id = null;
        $window->save();

        $response = broadcast(new Ring2Event('Llamada terminada por usuario ' . $client->name));

        $check = Trace::new_call($call);

        if(!$check){
            return 'Error';
        }

    }

}

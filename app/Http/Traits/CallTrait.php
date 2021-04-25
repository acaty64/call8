<?php

namespace App\Http\Traits;

use App\Models\Call;
use App\Models\Status;
use App\Models\Trace;
use App\Models\User;
use App\Models\Window;

trait CallTrait
{

    public function open()
    {
        $user = \Auth::user();

        $status = Status::where('status', 'En Pausa')->first();

        $call = Call::create([
            'user_id' => $user->id,
            'status_id' => $status->id,
        ]);

        $call->number = $call->number_today();
        $call->save();

        $check = Trace::new_call($call);

        if(!$check){
            return 'Error';
        }

        return $call;
        return $call->toJson();

    }

    public function close($array)
    {

        $user = \Auth::user();

        $status_closed = Status::where('status', 'Cerrado')->first();
        $status_paused = Status::where('status', 'En Pausa')->first();

        $call = Call::findOrFail($array['id']);
        $call->status_id = $status_closed->id;
        $call->save();

        $window = Window::where('client_id', $user->id)->first();
        $window->status_id = $status_paused->id;
        $window->client_id = null;
        $window->call_id = null;
        $window->save();

        $check = Trace::new_call($call);

        if(!$check){
            return 'Error';
        }

        return $call->toJson();

    }

}

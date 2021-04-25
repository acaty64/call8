<?php

namespace App\Http\Traits;

use App\Models\Call;
use App\Models\Status;
use App\Models\Trace;
use App\Models\User;

trait CallTrait
{

    public function store()
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

        $status = Status::where('status', 'Cerrado')->first();

        $call = Call::findOrFail($array['id']);

        $call->status_id = $status->id;

        $call->save();

        $check = Trace::new_call($call);

        if(!$check){
            return 'Error';
        }

        return $call->toJson();

    }

}

<?php

namespace App\Models;

use App\Models\Call;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Trace extends Model
{
    protected $fillable = [
        'user_id', 'call_id', 'window_id', 'status_id'
    ];

    public function getUserAttribute()
    {
        return $this->hasOne(User::class);
    }

    public function getCallAttribute()
    {
    	$call = Call::findOrFail($this->call_id);
    	if(!$call){
    		return [];
    	}
        return $call;
    }

    public function getWindowAttribute()
    {
    	$w = Call::findOrFail($this->window_id);
    	if(!$w){
    		return [];
    	}
        return $w;
    }

    public function getStatusAttribute()
    {
        return $this->hasOne(Status::class);
    }

    public static function new_call($call)
    {
        Trace::create([
            'user_id' => $call->user_id,
            'call_id' => $call->id,
            'status_id' => $call->status_id,
        ]);

        return true;
    }

}

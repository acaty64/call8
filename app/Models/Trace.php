<?php

namespace App\Models;

use App\Models\Call;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Trace extends Model
{
    protected $fillable = [
        'host_id',
        'client_id',
        'call_id',
        'window_id',
        'status_id',
        'office_id',
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
            'client_id' => $call->client_id,
            'call_id' => $call->id,
            'status_id' => $call->status_id,
            'office_id' => $call->office_id,
        ]);
        return true;
    }

    public static function new_window($window)
    {
        Trace::create([
            'host_id' => $window->host_id,
            'client_id' => $window->client_id,
            'call_id' => $window->call_id,
            'window_id' => $window->id,
            'status_id' => $window->status_id,
            'office_id' => $window->office_id,
        ]);
        return true;
    }

}

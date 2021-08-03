<?php

namespace App\Models;

use App\Models\Call;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
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

    public function getDateAttribute()
    {
        return CarbonImmutable::parse($this->created_at)->format('Y-m-d');
    }

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

    public function attend_time($call_id)
    {
        $status_attend_id = Status::where('status', 'Atendiendo')->first()->id;
        $status_close_id = Status::where('status', 'Cerrado')->first()->id;

        $call_start = Trace::where('call_id', $call_id)
                    ->where('host_id', null)
                    ->where('status_id', $status_attend_id)
                    ->first();
        if($call_start){
            $startTime = Carbon::parse($call_start->created_at);
        }
        $call_stop = Trace::where('call_id', $call_id)
                    ->where('status_id', $status_close_id)
                    ->first();
        if($call_stop){
            $stopTime = Carbon::parse($call_stop->created_at);
        }

        if($call_start && $call_stop){
            return $stopTime->diffInSeconds($startTime);
        }else{
            return null;
        }
    }

    public function paused_time($call_id)
    {
        $status_paused_id = Status::where('status', 'En Pausa')->first()->id;
        $status_attend_id = Status::where('status', 'Atendiendo')->first()->id;

        $call_start = Trace::where('call_id', $call_id)
                    ->where('host_id', null)
                    ->where('status_id', $status_paused_id)
                    ->first();
        if($call_start){
            $startTime = Carbon::parse($call_start->created_at);
        }
        $call_stop = Trace::where('call_id', $call_id)
                    ->where('status_id', $status_attend_id)
                    ->first();
        if($call_stop){
            $stopTime = Carbon::parse($call_stop->created_at);
        }

        if($call_start && $call_stop){
            return $stopTime->diffInSeconds($startTime);
        }else{
            return null;
        }
    }


}

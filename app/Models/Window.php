<?php

namespace App\Models;

use App\Models\Call;
use App\Models\Status;
use App\Models\User;
use App\Models\Window;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Window extends Model
{
    protected $fillable = [
        'window', 'host_id', 'client_id', 'status_id', 'call_id', 'link', 'qclients', 'qwindows', 'time_busy', 'time_paused'
    ];


    public function getTimeBusyAttribute()
    {
        $status = Status::where('status', 'Atendiendo')->first();
        if($this->status_id == $status->id){
            $startTime = Carbon::parse($this->updated_at);
            $finishTime = Carbon::parse(date('Y-m-d H:i:s'));
            $totalDuration = $finishTime->diffInSeconds($startTime);
            return gmdate('H:i:s', $totalDuration);
        }
        return "";
    }

    public function getTimePausedAttribute()
    {
        $status = Status::where('status', 'En Pausa')->first();
        if($this->status_id == $status->id){
            $startTime = Carbon::parse($this->updated_at);
            $finishTime = Carbon::parse(date('Y-m-d H:i:s'));
            $totalDuration = $finishTime->diffInSeconds($startTime);
            return gmdate('H:i:s', $totalDuration);
        }
        return "";
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    public function host()
    {
        return $this->belongsTo(User::class, 'host_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function getQclientsAttribute()
    {
        $status_paused = Status::where('status', 'En Pausa')->first();
        return Call::where('status_id', $status_paused->id)->count();
    }

    public function getQwindowsAttribute()
    {
        return Window::where('host_id', '!=', null)->count();
    }

}

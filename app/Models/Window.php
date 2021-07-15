<?php

namespace App\Models;

use App\Models\Call;
use App\Models\Office;
use App\Models\Status;
use App\Models\User;
use App\Models\Window;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Window extends Model
{
    protected $fillable = [
        'window',
        'host_id',
        'client_id',
        'status_id',
        'call_id',
        'office_id',
    ];

    protected $appends = [
        'qclients',
        'qwindows',
        'time_busy',
        'time_paused',
        'time_free',
        'office_now',
        'host_name',
        'client_name',
    ];

    public function getClientNameAttribute()
    {
        $client = User::find($this->client_id);
        if(!$client){
            return "";
        }
        return $client->name;
    }

    public function getHostNameAttribute()
    {
        $host = User::find($this->host_id);
        if(!$host){
            return "";
        }
        return $host->name;
    }

    public function getOfficeNowAttribute()
    {
        $now = Carbon::now();
        $date_now = $now->format('Y-m-d');
        $time_now = str_pad($now->hour, 2, "00", STR_PAD_LEFT) . ':' . str_pad($now->minute, 2, "00", STR_PAD_LEFT);
        $schedule = Schedule::where('host_id', $this->host_id)
                        ->where('date_start', '<=', $date_now)
                        ->where('date_end', '>=', $date_now)
                        ->where('day', $now->dayOfWeek)
                        ->where('hour_start', '<=', $time_now)
                        ->where('hour_end', '>=', $time_now)
                        ->first();
        if(empty($schedule)){
            return false;
        }
        return $schedule;
    }

    public function getTimeFreeAttribute()
    {
        $status = Status::where('status', 'Libre')->first();
        if($this->status_id == $status->id){
            $startTime = Carbon::parse($this->updated_at);
            $finishTime = Carbon::parse(date('Y-m-d H:i:s'));
            $totalDuration = $finishTime->diffInSeconds($startTime);
            return gmdate('H:i:s', $totalDuration);
        }
        return "";
    }

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

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id', 'id');
    }

    public function call()
    {
        return $this->belongsTo(Call::class, 'call_id', 'id');
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

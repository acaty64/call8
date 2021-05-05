<?php

namespace App\Models;


use App\Models\Status;
use App\Models\User;
use App\Models\Window;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    protected $fillable = [
        'number',
        'client_id',
        'status_id',
    ];

    protected $appends = [
        'window',
        'time_paused'
    ];

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


    public function user()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function number_today()
    {
        // Todo: Calc number_yesterday
        $number_yesterday = 0;
        $number_today = $this->id - $number_yesterday;
        return $number_today;
    }

    public function getWindowAttribute()
    {
        $window = Window::where('call_id', $this->id)->first();
        return $window;
    }

}

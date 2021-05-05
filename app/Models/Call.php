<?php

namespace App\Models;


use App\Models\Status;
use App\Models\User;
use App\Models\Window;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    protected $fillable = [
        'number',
        'client_id',
        'status_id',
    ];

    protected $appends = ['window'];

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

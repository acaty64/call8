<?php

namespace App\Models;


use App\Models\User;
use App\Status;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    protected $fillable = [
        'number',
        'user_id',
        'status_id',
    ];

    // protected $appends = ['user', 'status', 'number_today'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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

}

<?php

namespace App\Models;

use App\Models\Office;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
    		'office_id',
    		'host_id',
    		'day',
    		'hour_start',
    		'hour_end',
    		'date_start',
    		'date_end',
    	];


    public function host()
    {
        return $this->belongsTo(User::class, 'host_id', 'id');
    }

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id', 'id');
    }


}

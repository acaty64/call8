<?php

namespace App\Models;

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

}

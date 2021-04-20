<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Window extends Model
{
    protected $fillable = [
        'window', 'user_id', 'status_id',
    ];

}

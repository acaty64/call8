<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $fillable = [
    	'host_id',
    	'client_id',
    	'host_comment',
    	'client_comment',
    ];
}

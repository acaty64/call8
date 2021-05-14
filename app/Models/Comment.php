<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $fillable = [
    	'call_id',
    	'host_id',
    	'client_id',
    	'host_comment',
    	'client_comment',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    public function host()
    {
        return $this->belongsTo(User::class, 'host_id', 'id');
    }

    public function call()
    {
        return $this->belongsTo(Call::class, 'call_id', 'id');
    }

}

<?php

namespace App\Models;

use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Window extends Model
{
    protected $fillable = [
        'window', 'host_id', 'client_id', 'status_id', 'link'
    ];

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



}

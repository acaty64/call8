<?php

namespace App\Models;

use App\Models\Call;
use App\Models\Status;
use App\Models\User;
use App\Models\Window;
use Illuminate\Database\Eloquent\Model;

class Window extends Model
{
    protected $fillable = [
        'window', 'host_id', 'client_id', 'status_id', 'call_id', 'link', 'qclients', 'qwindows', 
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

<?php

namespace App\Models;

use App\Models\Status;
use App\Models\User;
use App\Models\Window;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = ['window_id', 'host_id', 'client_id', 'status_id', 'link'];

    protected $append = ['host', 'client', 'window', 'status'];

    public function getStatusAttribute()
    {
    	$status = Status::findOrFail($this->status_id)->status;
    	return $status;
    }

    public function getWindowAttribute()
    {
    	$window = Window::findOrFail($this->window_id)->window;
    	return $window;
    }

    public function getHostAttribute()
    {
    	$host = User::findOrFail($this->host_id)->name;
    	return $host;
    }

    public function getClientAttribute()
    {
    	$client = User::findOrFail($this->client_id)->name;
    	return $client;
    }


}

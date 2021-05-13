<?php

namespace App\Models;

use App\Models\Status;
use App\Models\User;
use App\Models\Window;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = ['order', 'name', 'link', 'description', 'active'];


}

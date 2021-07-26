<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    public $fillable = [
        'order',
        'name',
        'filename',
        'link',
        'active',
    ];
}

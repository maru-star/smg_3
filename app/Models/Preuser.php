<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preuser extends Model
{
    protected $fillable = [
        'email',
        'token',
        'expiration_datetime',
        'status',
    ];
}

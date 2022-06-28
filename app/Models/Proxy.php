<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proxy extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'list_number',
        'login',
        'password',
        'ip_port',
        'ip',
        'region',
        'uuid',
        'name',
        'location_id',
        'status'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Number extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'number',
        'content',
        'type',
        'icon',
        'avito',
        'yula',
        'yudu',
        'yandeks',
        'date'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform',
        'account',
        'type_account',
        'profile',
        'date_create',
        'geo',
        'etap',
        'status',
        'info',
        'connect_provider',
        'ip_port',
        'city',
        'name',
        'surname',
        'day',
        'month',
        'year',
        'login',
        'password',
        'number',
        'payment',
        'type_payment',
        'date_payment',
        'billing',
        'comment',
        'file1',
        'file2',
        'file3',
        'file4',
        'image',
        'img1',
        'img2',
        'img3',
        'img4',
        'img5',
        'img6'
        
    ];
    protected $casts = [
        'img' => 'json'
    ];
}

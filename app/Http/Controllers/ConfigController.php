<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function clearRoute()
    {
        \Artisan::call('route:clear');
    }
}

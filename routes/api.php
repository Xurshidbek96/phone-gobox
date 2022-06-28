<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("login",[UserController::class,'index']);
Route::post('register', [UserController::class, 'signup']);

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::resource('/numbers', NumberController::class);
    Route::resource('/emails', EmailController::class);
    Route::resource('/billings', BillingController::class);
    Route::resource('/proxys', ProxyController::class);
    Route::resource('/accounts', AccountController::class);
    Route::resource('/users', UsersController::class);
    Route::post('proxy_city', [ProxyController::class, 'proxy_city']);

    Route::resource('/adminproxys', AdminProxyController::class);
    Route::resource('/managers', ManagerController::class);
});


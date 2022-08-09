<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
use \App\Http\Controllers\Api\Auth;

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [Auth\RegisterController::class, 'register']);
    Route::post('login',    [Auth\LoginController::class, 'login']);
    Route::get('token/valid',    [Auth\LoginController::class, 'getUserDetail']);

    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [Auth\LoginController::class, 'logout']);
    });
});

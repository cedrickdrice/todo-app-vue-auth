<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\TaskManagementController;
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
use \App\Http\Controllers;
Route::group(['namespace' => 'Api'], function () {
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {
        Route::post('register',         [RegisterController::class, 'register']);
        Route::post('login',            [LoginController::class, 'login']);
        Route::get('token/valid',       [LoginController::class, 'getUserDetail']);

        Route::middleware('auth:api')->group(function () {
            Route::post('logout',       [LoginController::class, 'logout']);
        });
    });

    Route::middleware('auth:api')->group(function () {
        Route::group(['prefix' => 'task'], function () {
            Route::get('{id}',          [TaskManagementController::class, 'getTaskDetail']);
            Route::post('/',            [TaskManagementController::class, 'createTask']);
            Route::put('{id}',          [TaskManagementController::class, 'updateTask']);
            Route::get('list',          [TaskManagementController::class, 'getTaskList']);
            Route::delete('delete',     [TaskManagementController::class, 'deleteTask']);
        });
    });
});

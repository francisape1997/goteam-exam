<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [UserController::class, 'show']);
    Route::get('/list', [UserController::class, 'list']);
    Route::put('/update-profile', [UserController::class, 'update']);
});

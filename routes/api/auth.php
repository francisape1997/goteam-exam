<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', RegisterController::class)->name('register');

Route::middleware(['auth:sanctum'])->post('logout', [AuthController::class, 'logout'])->name('logout');

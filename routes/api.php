<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('movies', MovieController::class);
Route::apiResource('ratings', RatingController::class);
Route::apiResource('users', UserController::class);

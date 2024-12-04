<?php

use App\Http\Controllers\Api\JobController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// WARNING: Don't remove, or alter, socialite passport provider relies on this route to get user,
// and the middleware must be 'auth:api'
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::apiResource('jobs', JobController::class)->middleware(['client']);

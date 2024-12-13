<?php

use App\Http\Controllers\API\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('users', UserApiController::class); // user.index, user.store
// Route::apiResource('users', UserApiController::class, array('as' => 'api')); // condition if got the error message : Another route has already been assigned name


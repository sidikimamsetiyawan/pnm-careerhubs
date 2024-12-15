<?php

use App\Http\Controllers\API\AuthApiController;
use App\Http\Controllers\API\HobbyApiController;
use App\Http\Controllers\API\RoleApiController;
use App\Http\Controllers\API\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('users', UserApiController::class); // user.index, user.store
    Route::apiResource('roles', RoleApiController::class); // user.index, user.store
    Route::apiResource('hobbies', HobbyApiController::class); // user.index, user.store

    Route::post('/logout', [AuthApiController::class, 'logout']);
});


// Route::apiResource('users', UserApiController::class, array('as' => 'api')); // condition if got the error message : Another route has already been assigned name
Route::post('/login', [AuthApiController::class, 'login']);


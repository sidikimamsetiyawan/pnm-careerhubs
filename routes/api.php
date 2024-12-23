<?php

use App\Http\Controllers\API\AuthApiController;
use App\Http\Controllers\API\CareerApiController;
use App\Http\Controllers\API\CareerReportsApiController;
use App\Http\Controllers\API\EmployeeApiController;
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

    Route::apiResource('employees', EmployeeApiController::class); // user.index, user.store
    Route::apiResource('careers', CareerApiController::class); // user.index, user.store
    // Route::apiResource('reports', CareerReportsApiController::class, 'report'); 
    Route::get('/reports', [CareerReportsApiController::class, 'report']);
    Route::get('/reports/joined-by-year', [CareerReportsApiController::class, 'get_employee_joined_by_year']);
    Route::get('/reports/resigned-by-year', [CareerReportsApiController::class, 'get_employee_resigned_by_year']);
    Route::get('/reports/tenure-over-one-year', [CareerReportsApiController::class, 'get_employee_tenure_over_one_year']);
    Route::get('/reports/get-unit-heads', [CareerReportsApiController::class, 'get_unit_heads_with_ao_experience']);
    

    Route::post('/logout', [AuthApiController::class, 'logout']);
});


// Route::apiResource('users', UserApiController::class, array('as' => 'api')); // condition if got the error message : Another route has already been assigned name
Route::post('/login', [AuthApiController::class, 'login']);


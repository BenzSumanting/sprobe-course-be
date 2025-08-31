<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::post('login', LoginController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('student', StudentController::class);
    Route::apiResource('course', CourseController::class);
    Route::apiResource('assignment', AssignmentController::class);

    Route::get('student/{id}/assignment', [StudentController::class, 'studentAssignment']);
    Route::post('student/{id}/score', [StudentController::class, 'studentScore']);

    Route::post('logout', LogoutController::class);
});

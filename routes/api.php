<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth.role:admin,doctor,patient'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('users', UserController::class);
});
    
Route::middleware(['auth.role:admin'])->group(function () {
    Route::apiResource('doctors', DoctorController::class);
    Route::apiResource('patients', PatientController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('appointments', AppointmentController::class);
    Route::apiResource('availability', AvailabilityController::class);
});
    
Route::middleware(['auth.role:doctor'])->group(function () {
    Route::apiResource('users', UserController::class)->only('show', 'update', 'delete');
    Route::apiResource('patients', PatientController::class)->only(['index', 'show']);
    Route::apiResource('doctors', DoctorController::class);
    Route::apiResource('availability', AvailabilityController::class);
});

Route::middleware(['auth.role:patient'])->group(function () {
    Route::apiResource('users', UserController::class)->only('show', 'update', 'delete');
    Route::apiResource('patients', PatientController::class)->only(['show', 'update', 'destroy']);
    Route::apiResource('doctors', DoctorController::class)->only(['index', 'show']);
    Route::apiResource('appointments', AppointmentController::class);
    Route::apiResource('availability', AvailabilityController::class)->only(['index', 'show']);
});    

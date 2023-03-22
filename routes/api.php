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
Route::post('/logout', [AuthController::class, 'logout']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('user', [UserController::class, 'getUser']);
    Route::post('user/update', [UserController::class, 'updateUser']);
    Route::post('user/delete', [UserController::class, 'deleteUser']);
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('appointments', [AppointmentController::class, 'index']);
    Route::post('appointments', [AppointmentController::class, 'store']);
    Route::put('appointments/{id}', [AppointmentController::class, 'update']);
    Route::delete('appointments/{id}', [AppointmentController::class, 'destroy']);
});

// Availability
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('availability', [AvailabilityController::class, 'index']);
    Route::post('availability', [AvailabilityController::class, 'store']);
    Route::put('availability/{id}', [AvailabilityController::class, 'update']);
    Route::delete('availability/{id}', [AvailabilityController::class, 'destroy']);
});

// Doctors
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('doctors', [DoctorController::class, 'index']);
    Route::get('doctors/{id}', [DoctorController::class, 'show']);
});

// Patients
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('patients', [PatientController::class, 'index']);
    Route::get('patients/{id}', [PatientController::class, 'show']);
});
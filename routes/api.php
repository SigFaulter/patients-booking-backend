<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\ChatController;
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

Route::middleware(['auth.role:patient'])->group(function () {
    Route::apiResource('appointments', AppointmentController::class)->only('store', 'update', 'destroy');
    Route::apiResource('availabilities', AvailabilityController::class)->only(['index', 'show']);
});

Route::middleware(['auth.role:doctor,patients,admin'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('users', PatientController::class)->only('index', 'show', 'update', 'destroy');
    Route::apiResource('patients', PatientController::class)->only('index', 'show');
    Route::apiResource('doctors', DoctorController::class)->only('index', 'show');
    Route::apiResource('chat', ChatController::class)->only('index', 'store');
});

Route::middleware(['auth.role:patient,admin'])->group(function () {
    Route::apiResource('patients', PatientController::class)->only('update', 'destroy');
    Route::apiResource('appointments', AppointmentController::class)->only('index', 'store', 'update', 'destroy');
    Route::apiResource('availabilities', AvailabilityController::class)->only('index', 'show');
});

Route::middleware(['auth.role:doctor,admin'])->group(function () {
    Route::apiResource('doctors', PatientController::class)->only('update', 'destroy');
    Route::apiResource('availabilities', AvailabilityController::class)->only('index', 'store', 'update', 'destroy');
});
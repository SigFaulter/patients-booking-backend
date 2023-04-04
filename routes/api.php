<?php

use App\Http\Controllers\UserController;
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

Route::middleware(['auth.role:admin,doctor,patient'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('chats', ChatController::class)->only('index', 'store');

    Route::apiResource('doctors', DoctorController::class)->middleware('auth.resource:doctor,admin')->except('index');

    Route::apiResource('patients', PatientController::class)->middleware('auth.resource:patient,admin')->except('index');

    Route::apiResource('appointments', AppointmentController::class)->middleware('auth.resource:patient,admin')->except('index');

    Route::apiResource('availabilities', AvailabilityController::class)->middleware('auth.resource:doctor,admin')->except('index');
});

Route::middleware(['auth.role:admin'])->group(function () {
    Route::apiResource('doctors', DoctorController::class)->only('index', 'update', 'destroy');
    Route::apiResource('patients', PatientController::class)->only('index', 'update', 'destroy');
    Route::apiResource('appointments', AppointmentController::class)->only('index', 'destroy');
    Route::apiResource('availabilities', AvailabilityController::class)->only('index', 'destroy');
});

Route::middleware(['auth.role:doctor'])->group(function () {
    Route::apiResource('patients', PatientController::class)->only(['index', 'show']);
    Route::apiResource('availabilities', AvailabilityController::class)->only('store', 'update', 'destroy');
});

Route::middleware(['auth.role:patient'])->group(function () {
    Route::apiResource('patients', PatientController::class)->only('index','show', 'update');
    Route::apiResource('appointments', AppointmentController::class)->only('store', 'update', 'destroy');
    Route::apiResource('availabilities', AvailabilityController::class)->only(['index', 'show']);
});

/*
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth.role:admin,doctor,patient'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('chat', ChatController::class)->only('index', 'store');
    Route::apiResource('users', UserController::class)->except('index')->middleware('auth.resource:user');
});

Route::middleware(['auth.role:admin'])->group(function () {
    Route::apiResource('doctors', DoctorController::class);
    Route::apiResource('patients', PatientController::class);
    Route::apiResource('appointments', AppointmentController::class);
    Route::apiResource('availability', AvailabilityController::class);
});

Route::middleware(['auth.role:doctor'])->group(function () {
    Route::apiResource('patients', PatientController::class)->only(['index', 'show']);
    Route::apiResource('doctors', DoctorController::class)->only('update', 'destroy')->middleware('auth.resource:doctor');
    Route::apiResource('availability', AvailabilityController::class)->only('store', 'update' ,'destroy');
});

Route::middleware(['auth.role:doctor,patient'])->group(function () {
    Route::apiResource('doctors', DoctorController::class)->only(['index', 'show']);
});

Route::middleware(['auth.role:patient'])->group(function () {
    Route::apiResource('patients', PatientController::class)->only('show', 'update', 'destroy')->middleware('auth.resource:patient');
    Route::apiResource('appointments', AppointmentController::class)->only('show');
    Route::apiResource('appointments', AppointmentController::class)->only('store', 'update', 'destroy')->middleware('auth.resource:patient');
    Route::apiResource('availability', AvailabilityController::class)->only(['index', 'show']);
});
*/
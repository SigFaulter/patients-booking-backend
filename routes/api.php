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
});

Route::middleware(['auth.role:admin,patient'])->group(function () {
    Route::resource('users', UserController::class)->only(['index', 'update', 'destroy']);
    Route::resource('appointments', AppointmentController::class)->except(['create', 'edit']);
});

Route::middleware(['auth.role:admin,doctor'])->group(function () {
    Route::resource('availability', AvailabilityController::class)->except(['create', 'edit']);
    Route::resource('doctors', DoctorController::class)->only(['index', 'show']);
    Route::resource('patients', PatientController::class)->only(['index', 'show']);
});

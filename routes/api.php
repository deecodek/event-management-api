<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\ArtistController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\OrganizerController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RegistrationController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::apiResource('events', EventController::class);
    Route::apiResource('artists', ArtistController::class);
    Route::apiResource('locations', LocationController::class);
    Route::apiResource('organizers', OrganizerController::class);
    Route::post('/events/{event}/register', [RegistrationController::class, 'store']);
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('permissions', PermissionController::class);
    Route::post('/events/{event}/bulk-register', [RegistrationController::class, 'bulkRegister']);
});
// PDF Download Route
Route::get('/events/{event}/download-pdf', [EventController::class, 'downloadPdf']);



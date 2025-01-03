<?php

use App\Http\Controllers\Api\ArtistController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\OrganizerController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\RoleController;
use Illuminate\Support\Facades\Route;

// Public routes (no authentication required)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (authentication required)
Route::middleware('auth:sanctum')->group(function () {
    // Authentication routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Resource routes
    Route::apiResource('events', EventController::class);
    Route::apiResource('artists', ArtistController::class);
    Route::apiResource('locations', LocationController::class);
    Route::apiResource('organizers', OrganizerController::class);
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('permissions', PermissionController::class);

    // Event registration routes
    Route::post('/events/{event}/register', [RegistrationController::class, 'store']);
    Route::post('/events/{event}/bulk-register', [RegistrationController::class, 'bulkRegister']);

    // Impersonation routes (protected by Sanctum)
    Route::middleware('impersonate')->group(function () {
        Route::impersonate();
    });
});

// PDF Download Route (public or protected, depending on your requirement)
Route::get('/events/{event}/download-pdf', [EventController::class, 'downloadPdf']);

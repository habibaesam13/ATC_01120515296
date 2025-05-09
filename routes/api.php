<?php

use App\Http\Controllers\api\ApiAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\api\ApiEventController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login',    [ApiAuthController::class, 'login']);
Route::post('/logout',   [ApiAuthController::class, 'logout'])->middleware('auth:sanctum');

// Event Management API routes for ADMIN
Route::middleware(['auth:sanctum', RoleMiddleware::class . ':admin'])->prefix('admin')->group(function () {
    Route::get('/events/create', [ApiEventController::class, 'create']);
    Route::post('/events/save', [ApiEventController::class, 'store']);
    Route::get('/events/edit/{id}', [ApiEventController::class, 'edit']);
    Route::post('/events/update/{id}', [ApiEventController::class, 'update']);
    Route::delete('/events/delete/{id}', [ApiEventController::class, 'destroy']);
});


// Public or shared route (for both admin and users)
Route::middleware(['auth:sanctum'])->get('/events/show/{id}', [ApiEventController::class, 'show']);


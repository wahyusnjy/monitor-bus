<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\GpsController;
use App\Http\Controllers\RouteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    // Bus endpoints
    Route::prefix('buses')->group(function () {
        Route::get('/', [BusController::class, 'index']); // List semua bus
        Route::get('/active', [BusController::class, 'activeBuses']); // Bus aktif
        Route::get('/{bus}/locations', [BusController::class, 'locationHistory']); // Histori lokasi
        Route::get('/nearby', [BusController::class, 'nearbyBuses']); // Bus terdekat
    });
    
    // Route endpoints
    Route::prefix('routes')->group(function () {
        Route::get('/', [RouteController::class, 'index']);
        Route::get('/{route}', [RouteController::class, 'show']);
    });
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/gps-update', [GpsController::class, 'handleGpsUpdate'])
    ->middleware('gps.device.auth');

// WebSocket auth channel
Route::post('/broadcasting/auth', function () {
    return Broadcast::auth(request());
});

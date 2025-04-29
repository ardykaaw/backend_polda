<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Tambahkan ini untuk debug
Log::info('API routes are loading');

// Route test API
Route::get('test', function() {
    return response()->json([
        'message' => 'API is working'
    ]);
});

// Route untuk debugging
Route::get('/', function() {
    return response()->json([
        'message' => 'API is working!',
        'status' => 'success',
        'timestamp' => now()
    ]);
});

// Route login (tambahkan slash di awal)
Route::post('/login', [AuthController::class, 'login']);

// Route untuk debugging - menampilkan semua route
Route::get('/routes', function() {
    $routes = collect(Route::getRoutes())->map(function($route) {
        return [
            'method' => $route->methods(),
            'uri' => $route->uri(),
            'name' => $route->getName(),
            'action' => $route->getActionName(),
        ];
    });
    return response()->json($routes);
});

Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn']);
Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut']);
Route::get('/attendance/history/{userId}', [AttendanceController::class, 'history']);
Route::post('users/{id}/profile-image', [UserController::class, 'updateProfileImage']); 
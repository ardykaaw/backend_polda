<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Mobile\AuthController;
use App\Http\Controllers\Mobile\DashboardController;
use App\Http\Controllers\Mobile\ProfileController;
use App\Http\Controllers\Mobile\ScheduleController;
use App\Http\Controllers\Mobile\AttendanceController;
use Illuminate\Support\Facades\Request;

/*
|--------------------------------------------------------------------------
| Web Routesppp
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('mobile.login');
});

// Admin Panel Routes
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    // Admin Guest Routes
    Route::middleware(['guest:admin'])->group(function () {
        Route::get('login', [AdminController::class, 'login'])->name('login');
        Route::post('login', [AdminController::class, 'authenticate'])->name('authenticate');
    });

    // Admin Auth Routes
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('attendance', [AdminController::class, 'attendance'])->name('attendance');
        Route::get('users', [UserController::class, 'index'])->name('users');
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('logout', [AdminController::class, 'logout'])->name('logout');

    });
});

// Mobile App Routes
Route::group(['prefix' => 'mobile', 'as' => 'mobile.'], function () {
    // Install Route (letakkan di awal sebelum guest routes)
    Route::get('install', function () {
        return view('mobile.user.install');
    })->name('install');

    // Mobile Guest Routes
    Route::middleware(['guest:web'])->group(function () {
        Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('authenticate');
    });

    // Mobile Auth Routes
    Route::middleware(['auth:web'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('profile', [ProfileController::class, 'index'])->name('profile');
        Route::get('schedule', [ScheduleController::class, 'index'])->name('schedule');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        
        // Attendance Routes
        Route::prefix('attendance')->name('attendance.')->group(function () {
            Route::post('check-in', [AttendanceController::class, 'checkIn'])->name('check-in');
            Route::post('check-out', [AttendanceController::class, 'checkOut'])->name('check-out');
        });

        Route::post('profile/update-photo', [ProfileController::class, 'updatePhoto'])->name('profile.update-photo');
    });
});

// Root redirect
Route::get('/', function () {
    return redirect()->route('mobile.login');
});

// Fallback untuk route yang tidak ditemukan
Route::fallback(function () {
    $uri = Request::path();
    if (str_starts_with($uri, 'admin')) {
        // Jika akses ke admin, redirect ke login admin
        return redirect()->route('admin.login')->with('error', 'Silakan login kembali.');
    } elseif (str_starts_with($uri, 'mobile')) {
        // Jika akses ke mobile, redirect ke login mobile
        return redirect()->route('mobile.login')->with('error', 'Silakan login kembali.');
    } else {
        // Default ke login mobile
        return redirect()->route('mobile.login')->with('error', 'Silakan login kembali.');
    }
});

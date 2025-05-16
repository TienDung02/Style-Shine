<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\testController;
use App\Http\Controllers\backend\profileController;
use App\Http\Controllers\auth\LoginController;





Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard.index');
Route::get('/table', [testController::class, 'index'])->name('admin.test');
Route::get('/profile', [profileController::class, 'index'])->name('admin.profile');


Route::get('/login', [LoginController::class, 'index'])->name('admin.login.index');
Route::get('/table', [testController::class, 'index'])->name('admin.test');
Route::get('/profile', [profileController::class, 'index'])->name('admin.profile');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\testController;
use App\Http\Controllers\backend\ProfileController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\OrderController;
use App\Http\Controllers\auth\LoginController;





Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard.index');
Route::get('/icon', [testController::class, 'index'])->name('admin.test');
Route::get('/profile', [profileController::class, 'index'])->name('admin.profile');
Route::get('/category', [CategoryController::class, 'index'])->name('admin.category');
Route::get('/product', [ProductController::class, 'index'])->name('admin.product');
Route::get('/order', [OrderController::class, 'index'])->name('admin.order');


//Route::get('/login', [LoginController::class, 'index'])->name('admin.login.index');
//Route::get('/profile', [profileController::class, 'index'])->name('admin.profile');

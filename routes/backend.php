<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\testController;
use App\Http\Controllers\backend\ProfileController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\OrderController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\ForgotPasswordController;


Route::get('/', [LoginController::class, 'index'])->name('admin.login.index');
Route::post('/login-process', [LoginController::class, 'login'])->name('login');
Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('forgot-password');
Route::post('/forgot-password-process', [ForgotPasswordController::class, 'forgot_password'])->name('send-mail');
Route::get('/admin-change-password', [ForgotPasswordController::class, 'change_password'])->name('change-password');
Route::post('/admin-change-password-process', [ForgotPasswordController::class, 'update_password'])->name('update-password');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('admin.dashboard.index');
    Route::get('/dashboard/data', [DashboardController::class, 'getStatsData'])->name('dashboard.data');
    Route::get('/stats/best-selling', [DashboardController::class, 'bestSelling'])->name('dashboard.bestSelling');

    // User
    Route::get('/user', [UserController::class, 'index'])->name('admin.user');







    Route::get('/icon', [testController::class, 'index'])->name('admin.test');
    Route::get('/profile', [profileController::class, 'index'])->name('admin.profile');
    Route::get('/category', [CategoryController::class, 'index'])->name('admin.category');
    Route::get('/product', [ProductController::class, 'index'])->name('admin.product');
    Route::get('/order', [OrderController::class, 'index'])->name('admin.order');



    Route::any('/logout', [LoginController::class, 'logout'])->name('logout');
});

//Route::get('/login', [LoginController::class, 'index'])->name('admin.login.index');
//Route::get('/profile', [profileController::class, 'index'])->name('admin.profile');
Route::get('/email', [LoginController::class, 'forgot_password_2'])->name('avasd');

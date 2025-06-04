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
Route::get('/change-password', [ForgotPasswordController::class, 'change_password'])->name('change-password');
Route::post('/admin-change-password-process', [ForgotPasswordController::class, 'update_password'])->name('update-password');

//Route::middleware(['auth'])->group(function () {

// Change Password
    Route::get('/admin-change-sendMail', [ForgotPasswordController::class, 'change_password_sendMail'])->name('admin.password');
    Route::get('/admin-change-password', [ForgotPasswordController::class, 'change_password_home'])->name('admin.password.index');
    Route::post('/admin-sendmail', [ForgotPasswordController::class, 'send_mail_process'])->name('admin.password.sendMail');


// Dashboard
    Route::get('/home', [DashboardController::class, 'index'])->name('admin.dashboard.index');
    Route::get('/dashboard/data', [DashboardController::class, 'getStatsData'])->name('dashboard.data');
    Route::get('/stats/best-selling', [DashboardController::class, 'bestSelling'])->name('dashboard.bestSelling');


// User
    Route::get('/user', [UserController::class, 'index'])->name('admin.user');
    Route::get('user/paginate-limit', [UserController::class, 'getLimit'])->name('admin.user.limit');
    Route::get('/user/search', [UserController::class, 'search'])->name('admin.user.search');
    Route::get('/user/{user}/view', [UserController::class, 'view'])->name('admin.user.view');


// Category
    Route::get('/category', [CategoryController::class, 'index'])->name('admin.category');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::put('/category/update/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::get('category/paginate-limit', [CategoryController::class, 'getLimit'])->name('admin.category.limit');
    Route::get('/category/search', [CategoryController::class, 'search'])->name('admin.category.search');
    Route::delete('category/delete/{category}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');


// Product
    Route::get('/product', [ProductController::class, 'index'])->name('admin.product');
    Route::get('/product/add', [ProductController::class, 'add'])->name('admin.product.add');
    Route::get('/product/{product}/view', [ProductController::class, 'view'])->name('admin.product.view');
    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('admin.product.edit');
    Route::post('/product/store', [ProductController::class, 'store'])->name('admin.product.store');
    Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('admin.product.update');
    Route::get('product/paginate-limit', [ProductController::class, 'getLimit'])->name('admin.product.limit');
    Route::get('/product/search', [ProductController::class, 'search'])->name('admin.product.search');
    Route::delete('product/delete/{product}', [ProductController::class, 'destroy'])->name('admin.product.destroy');


// Order
    Route::get('/order', [OrderController::class, 'index'])->name('admin.order');
    Route::get('order/paginate-limit', [OrderController::class, 'getLimit'])->name('admin.order.limit');
    Route::get('/order/search', [OrderController::class, 'search'])->name('admin.order.search');
    Route::delete('order/delete/{category}', [OrderController::class, 'destroy'])->name('admin.order.destroy');
    Route::get('/order/{order}/view', [OrderController::class, 'view'])->name('admin.order.view');

// Logout
    Route::any('/logout', [LoginController::class, 'logout'])->name('logout');
//});


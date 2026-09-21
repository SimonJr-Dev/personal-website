<?php

use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'show'])->name('home');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.submit');

    Route::get('forgot-password', [AdminAuthController::class, 'showForgotPasswordForm'])->name('forgot-password');
    Route::post('forgot-password', [AdminAuthController::class, 'sendPasswordResetLink'])->name('forgot-password.submit');

    Route::get('reset-password', [AdminAuthController::class, 'showResetPasswordForm'])->name('reset-password');
    Route::post('reset-password', [AdminAuthController::class, 'resetPassword'])->name('reset-password.submit');

    Route::middleware('admin')->group(function () {
        Route::get('/', [AdminAuthController::class, 'dashboard'])->name('dashboard');
        Route::post('/', [AdminAuthController::class, 'updateSiteContent'])->name('dashboard.update');

        Route::resource('posts', PostController::class)->except('show');

        Route::get('settings', [AdminAuthController::class, 'settings'])->name('settings');
        Route::post('settings', [AdminAuthController::class, 'updateSettings'])->name('settings.update');

        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});

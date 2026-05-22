<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;

// Public Landing Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Feedback submissions
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/feedback/detailed', [FeedbackController::class, 'createDetailed'])->name('feedback.detailed');
Route::post('/feedback/detailed', [FeedbackController::class, 'storeDetailed'])->name('feedback.detailed.store');

// Admin Auth Routes
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login.submit');

// Authenticated Admin Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/feedback/{feedback}/status', [DashboardController::class, 'updateStatus'])->name('admin.feedback.status');
    Route::post('/admin/feedback/{feedback}/featured', [DashboardController::class, 'toggleFeatured'])->name('admin.feedback.featured');
    Route::delete('/admin/feedback/{feedback}', [DashboardController::class, 'destroy'])->name('admin.feedback.destroy');
    Route::get('/admin/feedback/export', [DashboardController::class, 'export'])->name('admin.feedback.export');
});

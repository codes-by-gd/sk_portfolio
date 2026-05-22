<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\DevelopmentWorkController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ProfileController;

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

    // Feedback Management
    Route::get('/admin/dashboard', [AdminFeedbackController::class, 'index'])->name('admin.dashboard');
    Route::put('/admin/feedback/{feedback}', [AdminFeedbackController::class, 'update'])->name('admin.feedback.update');
    Route::post('/admin/feedback/{feedback}/status', [AdminFeedbackController::class, 'updateStatus'])->name('admin.feedback.status');
    Route::post('/admin/feedback/{feedback}/featured', [AdminFeedbackController::class, 'toggleFeatured'])->name('admin.feedback.featured');
    Route::post('/admin/feedback/{feedback}/avatar', [AdminFeedbackController::class, 'updateAvatar'])->name('admin.feedback.avatar');
    Route::delete('/admin/feedback/{feedback}', [AdminFeedbackController::class, 'destroy'])->name('admin.feedback.destroy');
    Route::get('/admin/feedback/export', [AdminFeedbackController::class, 'export'])->name('admin.feedback.export');

    // Gallery Management
    Route::get('/admin/gallery', [GalleryController::class, 'index'])->name('admin.gallery.index');
    Route::post('/admin/gallery', [GalleryController::class, 'store'])->name('admin.gallery.store');
    Route::delete('/admin/gallery/{gallery}', [GalleryController::class, 'destroy'])->name('admin.gallery.destroy');

    // Development Works Management
    Route::get('/admin/development', [DevelopmentWorkController::class, 'index'])->name('admin.development.index');
    Route::get('/admin/development/create', [DevelopmentWorkController::class, 'create'])->name('admin.development.create');
    Route::post('/admin/development', [DevelopmentWorkController::class, 'store'])->name('admin.development.store');
    Route::get('/admin/development/{development}/edit', [DevelopmentWorkController::class, 'edit'])->name('admin.development.edit');
    Route::put('/admin/development/{development}', [DevelopmentWorkController::class, 'update'])->name('admin.development.update');
    Route::delete('/admin/development/{development}', [DevelopmentWorkController::class, 'destroy'])->name('admin.development.destroy');

    // CMS Content Management
    Route::get('/admin/cms', [CmsController::class, 'index'])->name('admin.cms.index');
    Route::put('/admin/cms/{cms}', [CmsController::class, 'update'])->name('admin.cms.update');

    // Settings Management
    Route::get('/admin/settings', [SettingsController::class, 'index'])->name('admin.settings.index');
    Route::post('/admin/settings', [SettingsController::class, 'update'])->name('admin.settings.update');

    // Profile Management
    Route::get('/admin/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('/admin/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
});


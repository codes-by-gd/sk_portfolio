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
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ComplaintController;
use App\Http\Controllers\Admin\ProjectTimelineController;

// Public Landing Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Feedback submissions
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/feedback/detailed', [FeedbackController::class, 'createDetailed'])->name('feedback.detailed');
Route::post('/feedback/detailed', [FeedbackController::class, 'storeDetailed'])->name('feedback.detailed.store');

// Citizen Grievances
Route::get('/grievance', [App\Http\Controllers\ComplaintController::class, 'create'])->name('complaint.create');
Route::post('/grievance', [App\Http\Controllers\ComplaintController::class, 'store'])->name('complaint.store');
Route::get('/grievance/track', [App\Http\Controllers\ComplaintController::class, 'track'])->name('complaint.track');

// Admin Auth Routes
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login.submit');

// Authenticated Admin Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

    // Profile Management (Accessible to all logged-in admin users)
    Route::get('/admin/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('/admin/profile', [ProfileController::class, 'update'])->name('admin.profile.update');

    // ==========================================
    // SUPER ADMIN ONLY ROUTES (Gate: super-admin)
    // ==========================================
    Route::middleware(['can:super-admin'])->group(function () {
        // User Management
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.user.index');
        Route::post('/admin/users', [UserController::class, 'store'])->name('admin.user.store');
        Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.user.update');
        Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.user.destroy');

        // Settings Management
        Route::get('/admin/settings', [SettingsController::class, 'index'])->name('admin.settings.index');
        Route::post('/admin/settings', [SettingsController::class, 'update'])->name('admin.settings.update');

        // Deletion Actions on other entities
        Route::delete('/admin/feedback/{feedback}', [AdminFeedbackController::class, 'destroy'])->name('admin.feedback.destroy');
        Route::delete('/admin/gallery/{gallery}', [GalleryController::class, 'destroy'])->name('admin.gallery.destroy');
        Route::delete('/admin/development/{development}', [DevelopmentWorkController::class, 'destroy'])->name('admin.development.destroy');
        Route::delete('/admin/contacts/{contact}', [ContactController::class, 'destroy'])->name('admin.contact.destroy');
        Route::delete('/admin/complaints/{complaint}', [ComplaintController::class, 'destroy'])->name('admin.complaint.destroy');
        Route::delete('/admin/timeline/{timeline}', [ProjectTimelineController::class, 'destroy'])->name('admin.timeline.destroy');
        Route::delete('/admin/milestones/{milestone}', [ProjectTimelineController::class, 'destroyMilestone'])->name('admin.milestones.destroy');
    });

    // ===============================================
    // MODERATE CONTENT ROUTES (Gate: moderate-content)
    // ===============================================
    Route::middleware(['can:moderate-content'])->group(function () {
        // Feedback Moderation
        Route::get('/admin/dashboard', [AdminFeedbackController::class, 'index'])->name('admin.dashboard');
        Route::put('/admin/feedback/{feedback}', [AdminFeedbackController::class, 'update'])->name('admin.feedback.update');
        Route::post('/admin/feedback/{feedback}/status', [AdminFeedbackController::class, 'updateStatus'])->name('admin.feedback.status');
        Route::post('/admin/feedback/{feedback}/featured', [AdminFeedbackController::class, 'toggleFeatured'])->name('admin.feedback.featured');
        Route::get('/admin/feedback/export', [AdminFeedbackController::class, 'export'])->name('admin.feedback.export');

        // Contacts Address Book
        Route::get('/admin/contacts', [ContactController::class, 'index'])->name('admin.contact.index');
        Route::post('/admin/contacts', [ContactController::class, 'store'])->name('admin.contact.store');
        Route::put('/admin/contacts/{contact}', [ContactController::class, 'update'])->name('admin.contact.update');
        Route::get('/admin/contacts/export', [ContactController::class, 'export'])->name('admin.contact.export');

        // Citizens Grievance Logs
        Route::get('/admin/complaints', [ComplaintController::class, 'index'])->name('admin.complaint.index');
        Route::post('/admin/complaints', [ComplaintController::class, 'store'])->name('admin.complaint.store');
        Route::put('/admin/complaints/{complaint}', [ComplaintController::class, 'update'])->name('admin.complaint.update');
        Route::get('/admin/complaints/export', [ComplaintController::class, 'export'])->name('admin.complaint.export');
    });

    // ===========================================
    // EDIT CONTENT ROUTES (Gate: edit-content)
    // ===========================================
    Route::middleware(['can:edit-content'])->group(function () {
        // Gallery Management
        Route::get('/admin/gallery', [GalleryController::class, 'index'])->name('admin.gallery.index');
        Route::post('/admin/gallery', [GalleryController::class, 'store'])->name('admin.gallery.store');
        Route::put('/admin/gallery/{gallery}', [GalleryController::class, 'update'])->name('admin.gallery.update');

        // Development Works Management
        Route::get('/admin/development', [DevelopmentWorkController::class, 'index'])->name('admin.development.index');
        Route::get('/admin/development/create', [DevelopmentWorkController::class, 'create'])->name('admin.development.create');
        Route::post('/admin/development', [DevelopmentWorkController::class, 'store'])->name('admin.development.store');
        Route::get('/admin/development/{development}/edit', [DevelopmentWorkController::class, 'edit'])->name('admin.development.edit');
        Route::put('/admin/development/{development}', [DevelopmentWorkController::class, 'update'])->name('admin.development.update');
        Route::get('/admin/development/export', [DevelopmentWorkController::class, 'export'])->name('admin.development.export');

        // Standalone Project Timeline Management
        Route::get('/admin/timeline', [ProjectTimelineController::class, 'index'])->name('admin.timeline.index');
        Route::get('/admin/timeline/create', [ProjectTimelineController::class, 'create'])->name('admin.timeline.create');
        Route::post('/admin/timeline', [ProjectTimelineController::class, 'store'])->name('admin.timeline.store');
        Route::get('/admin/timeline/{timeline}', [ProjectTimelineController::class, 'show'])->name('admin.timeline.show');
        Route::get('/admin/timeline/{timeline}/edit', [ProjectTimelineController::class, 'edit'])->name('admin.timeline.edit');
        Route::put('/admin/timeline/{timeline}', [ProjectTimelineController::class, 'update'])->name('admin.timeline.update');
        Route::get('/admin/timeline/export', [ProjectTimelineController::class, 'export'])->name('admin.timeline.export');

        // Milestones
        Route::post('/admin/timeline/{timeline}/milestones', [ProjectTimelineController::class, 'storeMilestone'])->name('admin.milestones.store');
        Route::put('/admin/milestones/{milestone}', [ProjectTimelineController::class, 'updateMilestone'])->name('admin.milestones.update');

        // CMS Content Management
        Route::get('/admin/cms', [CmsController::class, 'index'])->name('admin.cms.index');
        Route::put('/admin/cms/{cms}', [CmsController::class, 'update'])->name('admin.cms.update');
        Route::post('/admin/cms/update-section', [CmsController::class, 'updateSection'])->name('admin.cms.update-section');
        Route::post('/admin/cms/hero-image', [CmsController::class, 'updateHero'])->name('admin.cms.update-hero');
    });
});

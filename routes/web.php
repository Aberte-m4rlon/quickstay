<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Owner\PropertyController;
use App\Http\Controllers\OwnerProfileController;
use App\Http\Controllers\OwnerMessageController;
use App\Http\Controllers\Renter\renterDashboardController;
use App\Http\Controllers\Renter\SearchController;
use App\Http\Controllers\Renter\InquiryController;
use App\Http\Controllers\Renter\ReviewController;
use App\Http\Controllers\RenterProfileController;
use App\Http\Controllers\RenterMessageController;
use App\Http\Controllers\MessageController;

// -----------------------------------------------------------------------------
// ROOT REDIRECT
// -----------------------------------------------------------------------------
Route::get('/', function () {
    return redirect()->route('login');
});

// -----------------------------------------------------------------------------
// DASHBOARD REDIRECT BY ROLE
// -----------------------------------------------------------------------------
Route::get('/dashboard', function () {
    $user = auth()->user();

    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'owner' => redirect()->route('owner.dashboard'),
        default => redirect()->route('renter.dashboard'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

// -----------------------------------------------------------------------------
// AUTH PROFILE ROUTES
// -----------------------------------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// -----------------------------------------------------------------------------
// ADMIN ROUTES
// -----------------------------------------------------------------------------
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/properties', [AdminController::class, 'properties'])->name('properties');
        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
        Route::get('/info', [AdminController::class, 'info'])->name('info');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::get('/feedbacks', [AdminController::class, 'feedbacks'])->name('feedbacks');
        Route::post('/properties/{id}/approve', [AdminController::class, 'approve'])->name('properties.approve');
    });

// -----------------------------------------------------------------------------
// OWNER ROUTES
// -----------------------------------------------------------------------------
Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {
        
        // Dashboard and Property Management
        Route::get('/dashboard', [PropertyController::class, 'index'])->name('dashboard');
        Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create');
        Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
        Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
        Route::put('/properties/{property}', [PropertyController::class, 'update'])->name('properties.update');
        Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');
        Route::post('/properties/{property}/status', [PropertyController::class, 'updateStatus'])->name('properties.status');
        // Messages list
        Route::get('/messages', [OwnerMessageController::class, 'index'])->name('messages.index');
         // Messages
        Route::get('/messages', [OwnerMessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/chat/{property}', [OwnerMessageController::class, 'chat'])->name('messages.chat');
        Route::post('/messages/send', [OwnerMessageController::class, 'sendMessage'])->name('messages.send');
    
        // Chat page for a property
        Route::get('/messages/{property}', [OwnerMessageController::class, 'showMessages'])->name('messages.show');

        // Send message
        Route::post('/messages/send', [OwnerMessageController::class, 'sendMessage'])->name('messages.send');
        // Owner Profile
        Route::get('/profile', [OwnerProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [OwnerProfileController::class, 'update'])->name('profile.update');
Route::get('/messages', [OwnerMessageController::class, 'index'])->name('messages'); 

        // Owner Messages (cleaned, no duplicates)
        Route::get('/messages', [OwnerMessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/{property_id}', [OwnerMessageController::class, 'showMessages'])->name('messages.show');
        Route::post('/messages/{property_id?}/send', [OwnerMessageController::class, 'sendMessage'])->name('messages.send');
        Route::post('/messages/{id}/mark-read', [OwnerMessageController::class, 'markRead'])->name('messages.mark_read');
    });

// -----------------------------------------------------------------------------
// RENTER ROUTES
// -----------------------------------------------------------------------------
Route::middleware(['auth', 'role:renter'])
    ->prefix('renter')
    ->name('renter.')
    ->group(function () {
        // Dashboard and Property Browsing
        Route::get('/dashboard', [SearchController::class, 'index'])->name('dashboard');
        Route::get('/properties/{id}', [SearchController::class, 'show'])->name('properties.show');
        Route::post('/properties/{id}/inquiries', [InquiryController::class, 'store'])->name('inquiries.store');
        Route::post('/properties/{id}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

        // Renter Profile
        Route::get('/profile', [RenterProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [RenterProfileController::class, 'update'])->name('profile.update');
        Route::get('/renter/messages', [RenterMessageController::class, 'index'])->name('renter.messages');
        Route::get('/renter/messages/chat/{property}', [RenterMessageController::class, 'chat'])->name('renter.messages.chat');
        Route::post('/renter/messages/send', [RenterMessageController::class, 'send'])->name('renter.messages.send');
        Route::post('/renter/messages/store', [RenterMessageController::class, 'send'])->name('renter.messages.store');
       Route::get('/renter/messages/chat/{property}', [RenterMessageController::class, 'chat'])
            ->name('renter.messages.chat');


        // 🟢 Renter Messages (Final + Working)
        Route::get('/messages', [RenterMessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/chat/{property}', [RenterMessageController::class, 'chat'])->name('messages.chat');
        Route::post('/messages/send', [RenterMessageController::class, 'send'])->name('messages.send');
    });

Route::get('/messages/{property}', [RenterMessageController::class, 'chat'])
    ->name('renter.messages.chat');
Route::get('/renter/messages/chat/{owner}', [RenterMessageController::class, 'chat'])
    ->name('renter.messages.chat');

// -----------------------------------------------------------------------------
// PROPERTY FEEDBACK
// -----------------------------------------------------------------------------
Route::post('/properties/{id}/feedback', [App\Http\Controllers\PropertyFeedbackController::class, 'store'])
    ->name('renter.feedback.store')
    ->middleware('auth');

Route::get('/admin/properties/{id}/feedback', [App\Http\Controllers\AdminController::class, 'fetchFeedback'])
    ->name('admin.properties.feedback');

// -----------------------------------------------------------------------------
// LOGOUT
// -----------------------------------------------------------------------------
Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');
Route::get('/renter/messages/{property}', [App\Http\Controllers\RenterMessageController::class, 'chat'])
     ->name('messages.chat');
Route::prefix('renter')->name('renter.')->group(function() {
    // Messages list page
    Route::get('/messages', [App\Http\Controllers\RenterMessageController::class, 'index'])
         ->name('messages.index');

    // Chat page for a specific property / owner
    Route::get('/messages/{property}', [App\Http\Controllers\RenterMessageController::class, 'chat'])
         ->name('messages.chat');
});
// routes/web.php

Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::post('/owner/messages/send', [App\Http\Controllers\MessageController::class, 'sendOwnerMessage'])->name('owner.messages.send');
});

// routes/web.php
Route::prefix('renter')->middleware(['auth', 'role:renter'])->group(function() {
    Route::get('messages/{property}', [App\Http\Controllers\RenterMessageController::class, 'chat'])
         ->name('messages.chat');

    Route::post('messages/send', [App\Http\Controllers\RenterMessageController::class, 'send'])
         ->name('renter.messages.send');
});
use App\Http\Controllers\PropertyFeedbackController;

Route::post('/properties/{property}/feedback', [PropertyFeedbackController::class, 'store'])
    ->name('property.feedback.store');

require __DIR__ . '/auth.php';

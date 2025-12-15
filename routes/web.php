<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/search', [\App\Http\Controllers\HomeController::class, 'search'])->name('search');
Route::get('/api/suggestions', [\App\Http\Controllers\HomeController::class, 'suggestions'])->name('api.suggestions');

Route::get('kalkulator', function () {
    return view('kalkulator');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Profile Routes
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    
    // Developer Registration
    Route::get('/become-developer', [\App\Http\Controllers\DeveloperRegistrationController::class, 'showRegistrationForm'])->name('developer.register');
    Route::post('/become-developer', [\App\Http\Controllers\DeveloperRegistrationController::class, 'registerDeveloper'])->name('developer.register.action');
    
    // Community Developer Registration
    Route::get('/become-community-developer', [\App\Http\Controllers\DeveloperRegistrationController::class, 'showCommunityRegistrationForm'])->name('developer.become.community');
    Route::post('/become-community-developer', [\App\Http\Controllers\DeveloperRegistrationController::class, 'registerCommunityDeveloper'])->name('developer.become.community.action');
});

// Service Details & Ordering
Route::get('/service/{service}', [\App\Http\Controllers\ServiceController::class, 'show'])->name('service.show');
Route::post('/service/{service}/order', [\App\Http\Controllers\OrderController::class, 'store'])->middleware('auth')->name('service.order');

// --- Developer Routes ---
Route::middleware(['auth', 'role:developer'])->prefix('developer')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DeveloperDashboardController::class, 'index'])->name('developer.dashboard');

    // Legacy/Existing Views mapped to new structure
    Route::get('/upload-jasa', [\App\Http\Controllers\ServiceController::class, 'create'])->name('developer.upload');
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'indexDeveloper'])->name('developer.orders');
    Route::get('/performance', [\App\Http\Controllers\DeveloperDashboardController::class, 'performance'])->name('developer.performance');

    // Community
    Route::get('/community', [\App\Http\Controllers\CommunityController::class, 'index'])->name('developer.community');
    Route::post('/community', [\App\Http\Controllers\CommunityController::class, 'store'])->name('developer.community.store');
    Route::get('/community/{id}/edit', [\App\Http\Controllers\CommunityController::class, 'edit'])->name('developer.community.edit');
    Route::put('/community/{id}', [\App\Http\Controllers\CommunityController::class, 'update'])->name('developer.community.update');
    Route::delete('/community/{id}', [\App\Http\Controllers\CommunityController::class, 'destroy'])->name('developer.community.destroy');
    Route::post('/community/{id}/like', [\App\Http\Controllers\CommunityController::class, 'like'])->name('developer.community.like');
    Route::post('/community/{id}/comment', [\App\Http\Controllers\CommunityController::class, 'comment'])->name('developer.community.comment');
    Route::put('/community/comment/{id}', [\App\Http\Controllers\CommunityController::class, 'updateComment'])->name('developer.community.comment.update');
    Route::delete('/community/comment/{id}', [\App\Http\Controllers\CommunityController::class, 'destroyComment'])->name('developer.community.comment.destroy');
    
    // Profile
    Route::get('/community/profile', [\App\Http\Controllers\CommunityController::class, 'profile'])->name('developer.community.profile');
    Route::put('/community/profile', [\App\Http\Controllers\CommunityController::class, 'updateProfile'])->name('developer.community.profile.update');

    // Service Management
    Route::resource('services', \App\Http\Controllers\ServiceController::class)->names([
        'index' => 'developer.services.index',
        'create' => 'developer.services.create',
        'store' => 'developer.services.store',
        'edit' => 'developer.services.edit',
        'update' => 'developer.services.update',
        'destroy' => 'developer.services.destroy',
    ]);
});

// --- Admin Routes ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return "<h1>Admin Dashboard - Coming Soon</h1>";
    })->name('admin.dashboard');
});

// --- User/Client Routes ---
Route::middleware(['auth', 'role:client'])->prefix('user')->group(function () {
    Route::get('/dashboard', function () {
        return redirect('/'); // Client fallback to home for now
    })->name('user.dashboard');
});

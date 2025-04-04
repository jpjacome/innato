<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HeroSettingsController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StyleController;
use App\Http\Controllers\PagesController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\EditorMiddleware;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::match(['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'OPTIONS'], '/', [WelcomeController::class, 'index'])->name('welcome');

// Control Panel Routes (accessible to all authenticated users)
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard - The main entry point for authenticated users
    Route::get('/dashboard', function () {
        $dashboardSettings = \App\Models\DashboardSettings::first();
        if (!$dashboardSettings) {
            $dashboardSettings = new \App\Models\DashboardSettings([
                'primary_color' => '#4F46E5',
                'secondary_color' => '#818CF8',
                'accent_color' => '#6366f1',
                'dashboard_title' => 'Dashboard'
            ]);
        }
        
        $heroSettings = \App\Models\HeroSetting::first();
        if (!$heroSettings) {
            $heroSettings = new \App\Models\HeroSetting([
                'title_text' => 'WELCOME',
                'title_color' => '#FFFFFF',
                'title_size' => '4rem',
                'title_font' => 'Playfair Display'
            ]);
        }
        
        return view('dashboard', [
            'settings' => $dashboardSettings,
            'heroSettings' => $heroSettings
        ]);
    })->name('admin.dashboard');
    
    // Profile Settings
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Theme Toggle
    Route::post('/theme', function () {
        $theme = request('theme', 'light');
        session(['theme' => $theme]);
        return response()->json(['success' => true]);
    })->name('theme.toggle');
    
    // Example routes
    Route::get('/examples/interactive-icon', function () {
        return view('examples.interactive-icon-demo');
    })->name('examples.interactive-icon');
});

// Admin-only Routes
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    // User Management
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    
    // Dashboard Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('/admin/settings', [SettingsController::class, 'index'])->name('admin.settings');
    Route::put('/admin/settings', [SettingsController::class, 'update'])->name('settings.update');
    
    // Hero Settings (for the welcome page)
    Route::get('/hero-settings', [HeroSettingsController::class, 'edit'])->name('hero-settings.edit');
    Route::put('/hero-settings', [HeroSettingsController::class, 'update'])->name('hero-settings.update');
    
    // Telescope integration
    Route::get('/admin/telescope', function () {
        return redirect('/telescope');
    })->name('admin.telescope');
    
    // Pulse integration
    Route::get('/admin/pulse', function () {
        return redirect('/pulse');
    })->name('admin.pulse');
});

// Admin and Editor Routes
Route::middleware(['auth', EditorMiddleware::class])->group(function () {
    // Pages
    Route::get('/admin/pages', [PagesController::class, 'index'])->name('admin.pages');
});

// Dynamic CSS
Route::get('/css/control-panel-dynamic.css', [StyleController::class, 'controlPanel'])->name('control-panel.css');

// Handle all other unmatched routes, especially important for subdirectory installations
Route::fallback(function() {
    // Check if the URL path might be the root in a subdirectory
    if (request()->path() === '/') {
        return app()->make(WelcomeController::class)->index();
    }
    
    abort(404);
});

require __DIR__.'/auth.php';

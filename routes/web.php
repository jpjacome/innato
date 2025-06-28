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
use App\Http\Controllers\PlantViewController;

// Public Routes
Route::match(['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'OPTIONS'], '/', [WelcomeController::class, 'index'])->name('welcome');

// Public route for home page (Blade view)
Route::get('/home', function () {
    $homeSetting = \App\Models\HomeSetting::instance();
    return view('home', compact('homeSetting'));
});

// Public route for about page (Blade view)
Route::get('/about', function () {
    return view('about');
});

// Public route for destinations page (Blade view)
Route::get('/destinations', function () {
    return view('destinations');
});

// Public route for single destination page (Blade view)
Route::get('/destination', function () {
    return view('single-page-destination');
});

// Public route for Experience Center (Blade view)
Route::get('/experience-center', function () {
    return view('experience-center');
});

// Public route for Contact (Blade view)
Route::get('/contact', function () {
    return view('contact');
});

// Public Plants Routes
Route::get('/plants', [PlantViewController::class, 'index'])->name('public.plants.index');
Route::get('/plants/{plant}', [PlantViewController::class, 'show'])->name('public.plants.show');
Route::get('/plants/create', [PlantViewController::class, 'create'])->name('public.plants.create');
Route::get('/plants/maintenance', [PlantViewController::class, 'maintenance'])->name('public.plants.maintenance');

// Legacy Plant Routes (for backward compatibility with existing plantas folder)
Route::get('/plantas/view-plant.php', [PlantViewController::class, 'legacyViewPlant']);
Route::get('/plantas/add-plant.html', [PlantViewController::class, 'legacyAddPlant']);
Route::get('/plantas/maintenance-form.html', [PlantViewController::class, 'legacyMaintenance']);

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
    
    // Dashboard Settings - Using a single consistent path
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
    Route::get('/admin/pages/edit-home', [PagesController::class, 'editHome'])->name('admin.pages.edit-home');
    Route::put('/admin/pages/edit-home', [PagesController::class, 'updateHome'])->name('admin.pages.update-home');
    
    // Plants Management
    Route::get('/admin/plants', [App\Http\Controllers\Admin\PlantController::class, 'index'])->name('admin.plants.index');
    Route::get('/admin/plants/create', [App\Http\Controllers\Admin\PlantController::class, 'create'])->name('admin.plants.create');
    Route::post('/admin/plants', [App\Http\Controllers\Admin\PlantController::class, 'store'])->name('admin.plants.store');
    Route::get('/admin/plants/{plant}', [App\Http\Controllers\Admin\PlantController::class, 'show'])->name('admin.plants.show');
    Route::get('/admin/plants/{plant}/edit', [App\Http\Controllers\Admin\PlantController::class, 'edit'])->name('admin.plants.edit');
    Route::put('/admin/plants/{plant}', [App\Http\Controllers\Admin\PlantController::class, 'update'])->name('admin.plants.update');
    Route::delete('/admin/plants/{plant}', [App\Http\Controllers\Admin\PlantController::class, 'destroy'])->name('admin.plants.destroy');
    Route::delete('/admin/plants/{plant}/images/{image}', [App\Http\Controllers\Admin\PlantController::class, 'deleteImage'])->name('admin.plants.images.destroy');
    Route::post('/admin/plants/{plant}/reorder-images', [App\Http\Controllers\Admin\PlantController::class, 'reorderImages'])->name('admin.plants.images.reorder');
    
    // Maintenance Logs Management
    Route::get('/admin/maintenance', [App\Http\Controllers\Admin\MaintenanceLogController::class, 'index'])->name('admin.maintenance.index');
    Route::get('/admin/maintenance/create', [App\Http\Controllers\Admin\MaintenanceLogController::class, 'create'])->name('admin.maintenance.create');
    Route::post('/admin/maintenance', [App\Http\Controllers\Admin\MaintenanceLogController::class, 'store'])->name('admin.maintenance.store');
    Route::get('/admin/maintenance/{maintenanceLog}', [App\Http\Controllers\Admin\MaintenanceLogController::class, 'show'])->name('admin.maintenance.show');
    Route::get('/admin/maintenance/{maintenanceLog}/edit', [App\Http\Controllers\Admin\MaintenanceLogController::class, 'edit'])->name('admin.maintenance.edit');
    Route::put('/admin/maintenance/{maintenanceLog}', [App\Http\Controllers\Admin\MaintenanceLogController::class, 'update'])->name('admin.maintenance.update');
    Route::delete('/admin/maintenance/{maintenanceLog}', [App\Http\Controllers\Admin\MaintenanceLogController::class, 'destroy'])->name('admin.maintenance.destroy');
    Route::delete('/admin/maintenance/{maintenanceLog}/images/{image}', [App\Http\Controllers\Admin\MaintenanceLogController::class, 'deleteImage'])->name('admin.maintenance.images.destroy');
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

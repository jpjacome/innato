<?php
// Reservation admin delete route for AJAX
use App\Http\Controllers\ReservationController;
Route::delete('/admin/reservations/{id}', [ReservationController::class, 'destroy'])->name('admin.reservations.destroy');
use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\User;
use App\Http\Controllers\NewsletterController;

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])
    ->name('newsletter.subscribe')
    ->middleware('throttle:5,1'); // 5 requests per minute per IP

Route::post('/admin/destinations/create', function(Request $request) {
    // Support JSON payloads for AJAX
    $validated = validator($request->json()->all(), [
        'destinationName' => 'required|string|max:255',
        'editorSelect' => 'required|exists:users,id',
        'destinationSlug' => 'required|string|max:255|unique:destinations,slug',
        'destinationRegion' => 'nullable|string|max:255',
    ])->validate();

    $destination = new Destination();
    $destination->title = $validated['destinationName'];
    $destination->slug = $validated['destinationSlug'];
    $destination->region = $validated['destinationRegion'] ?? 'unknown';
    $destination->status = 'active';
    // Set default values for required fields not provided by modal
    $destination->subtitle = 'unknown';
    $destination->coordinates = 'unknown';
    $destination->conservation_status = 'unknown';
    $destination->province = 'unknown';
    $destination->canton = 'unknown';
    $destination->parish = 'unknown';
    $destination->sector = 'unknown';
    $destination->reference_distance = '49.9 KM del GAD de Santa Elena';
    $destination->climate_dry_season = [];
    $destination->climate_wet_season = [];
    $destination->access_from = 'unknown';
    $destination->access_route = 'unknown';
    $destination->access_transport = 'unknown';
    $destination->access_time = 'unknown';
    $destination->schedule_hours = 'unknown';
    $destination->entry_fee = 'unknown';
    $destination->season_availability = 'unknown';
    $destination->requirements = 'unknown';
    $destination->contact_person = 'unknown';
    $destination->contact_role = 'unknown';
    $destination->contact_phone = 'unknown';
    $destination->contact_email = 'unknown';
    $destination->activities = [];
    $destination->target_audience_type = 'unknown';
    $destination->target_audience_origin = 'unknown';
    $destination->target_audience_age = 'unknown';
    $destination->target_audience_transport = 'unknown';
    $destination->target_audience_stay = 'unknown';
    $destination->services = [];
    $destination->average_price = 'unknown';
    $destination->capacity = 'unknown';
    $destination->payment_methods = 'unknown';
    $destination->mobile_coverage = 'unknown';
    $destination->tourism_criteria = [];
    $destination->main_description = '';
    $destination->secondary_description = '';
    $destination->strengths_benefits = '';
    $destination->environmental_challenges = [];
    $destination->save();

    // Assign the editor by updating the user's destination_id
    $editor = User::find($validated['editorSelect']);
    if ($editor) {
        $editor->destination_id = $destination->id;
        $editor->save();
    }

    // Optionally, return JSON for AJAX
    return response()->json(['success' => true, 'destination' => $destination]);
});

Route::get('/admin/editors-list', function() {
    // Adjust role check as needed (e.g., 'editor')
    $editors = User::where('role', 'editor')->get(['id', 'name', 'email']);
    return response()->json($editors);
});
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HeroSettingsController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StyleController;
use App\Http\Controllers\PagesController;

use Illuminate\Support\Facades\Storage;

Route::get('/admin/regions-list', function() {
    $regions = [];
    $path = storage_path('app/regions.json');
    if (file_exists($path)) {
        $regions = json_decode(file_get_contents($path), true) ?? [];
    }
    return response()->json($regions);
});

Route::post('/admin/regions-add', function(Request $request) {
    $region = trim($request->json('region'));
    if (!$region) return response()->json(['error' => 'Empty region'], 400);
    $path = storage_path('app/regions.json');
    $regions = file_exists($path) ? json_decode(file_get_contents($path), true) ?? [] : [];
    if (!in_array($region, $regions)) {
        $regions[] = $region;
        file_put_contents($path, json_encode($regions, JSON_PRETTY_PRINT));
    }
    return response()->json(['success' => true, 'regions' => $regions]);
});

Route::post('/admin/regions-delete', function(Request $request) {
    $region = trim($request->json('region'));
    $path = storage_path('app/regions.json');
    $regions = file_exists($path) ? json_decode(file_get_contents($path), true) ?? [] : [];
    $regions = array_values(array_filter($regions, fn($r) => $r !== $region));
    file_put_contents($path, json_encode($regions, JSON_PRETTY_PRINT));
    return response()->json(['success' => true, 'regions' => $regions]);
});
use App\Http\Controllers\DestinationViewController;
use App\Http\Controllers\Admin\AdminDestinationController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\EditorMiddleware;
use Illuminate\Support\Facades\Route;
use App\Models\ReviewsSetting;

// Public Routes - Root redirects to home page
use App\Models\Review;
Route::match(['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'OPTIONS'], '/', function () {
    $homeSetting = \App\Models\HomeSetting::instance();
    $reviews = Review::published()->orderByDesc('created_at')->get();
    return view('home', compact('homeSetting', 'reviews'));
})->name('welcome');

// Public route for home page (Blade view)
Route::get('/home', function () {
    $homeSetting = \App\Models\HomeSetting::instance();
    $reviews = Review::published()->orderByDesc('created_at')->get();
    return view('home', compact('homeSetting', 'reviews'));
});

// Public route for about page (Blade view, dynamic content)
Route::get('/about', [\App\Http\Controllers\PagesController::class, 'showAbout'])->name('about');

// Public route for destinations page (dynamic content)
Route::get('/destinations', [\App\Http\Controllers\DestinationsController::class, 'show'])->name('destinations');
Route::get('/destinations/{region}', [\App\Http\Controllers\DestinationsController::class, 'showRegion'])->name('destinations.region');
    Route::get('/admin/pages/edit-destinations', [\App\Http\Controllers\DestinationsController::class, 'edit'])->name('admin.pages.edit-destinations');
    Route::put('/admin/pages/edit-destinations', [\App\Http\Controllers\DestinationsController::class, 'update'])->name('admin.pages.update-destinations');

// Public route for single destination page (dynamic)
Route::get('/destination/{slug}', [App\Http\Controllers\DestinationViewController::class, 'show'])->name('destination.show');

// Public route for Experience Center (Blade view)
Route::get('/experience-center', function () {
    return view('experience-center');
});

// Public route for Contact (dynamic content)
Route::get('/contact', [\App\Http\Controllers\ContactController::class, 'show'])->name('contact');

// Control Panel Routes (accessible to all authenticated users)
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard - The main entry point for authenticated users
    Route::get('/dashboard', function () {
        $user = auth()->user();

        // Redirect users to their role-specific dashboard
        if ($user->isEditor()) {
            return redirect()->route('editor.dashboard');
        }

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Fallback for other users - show admin dashboard
        return redirect()->route('admin.dashboard');
    })->name('dashboard');

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
    // Admin Dashboard
    Route::get('/admin/dashboard', function () {
        $dashboardSettings = \App\Models\DashboardSettings::first();
        if (!$dashboardSettings) {
            $dashboardSettings = new \App\Models\DashboardSettings([
                'primary_color' => '#4F46E5',
                'secondary_color' => '#818CF8',
                'accent_color' => '#6366f1',
                'dashboard_title' => 'Admin Dashboard'
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

        // Add reservations for dashboard table (paginated)
        $reservations = \App\Models\Reservation::with('destination')->latest()->paginate(10);

        return view('admin.dashboard', [
            'settings' => $dashboardSettings,
            'heroSettings' => $heroSettings,
            'reservations' => $reservations
        ]);
    })->name('admin.dashboard');

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

    // Admin Destinations Management
    Route::get('/admin/destinations', [AdminDestinationController::class, 'index'])->name('admin.destinations.index');
    Route::get('/admin/destinations/{destination}/edit', [AdminDestinationController::class, 'edit'])->name('admin.destinations.edit');
    Route::put('/admin/destinations/{destination}', [AdminDestinationController::class, 'update'])->name('admin.destinations.update');
    Route::delete('/admin/destinations/{id}', function($id) {
        $destination = \App\Models\Destination::find($id);
        if ($destination) {
            $destination->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    });

    // Admin User Creation Routes
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
});

// User Management - accessible to admins and editors
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    // Editors and admins can edit their own user; admins can edit anyone
    Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
});

// Admin and Editor Routes
// Admin and Editor Routes
Route::middleware(['auth', EditorMiddleware::class])->group(function () {
    // Pages
    Route::get('/admin/pages', [PagesController::class, 'index'])->name('admin.pages');
    Route::get('/admin/pages/edit-home', [PagesController::class, 'editHome'])->name('admin.pages.edit-home');
    Route::put('/admin/pages/edit-home', [PagesController::class, 'updateHome'])->name('admin.pages.update-home');
    Route::get('/admin/pages/edit-about', [PagesController::class, 'editAbout'])->name('admin.pages.edit-about');
    Route::put('/admin/pages/edit-about', [PagesController::class, 'updateAbout'])->name('admin.pages.update-about');
    Route::get('/admin/pages/home-stats', [PagesController::class, 'homeStats'])->name('admin.pages.home-stats');

    // Contact Page Admin Edit
    Route::get('/admin/pages/edit-contact', [\App\Http\Controllers\ContactController::class, 'edit'])->name('admin.contact.edit');
    Route::post('/admin/pages/edit-contact', [\App\Http\Controllers\ContactController::class, 'update'])->name('admin.contact.update');
    // Experience Center Page Admin Edit
    Route::get('/admin/pages/edit-experience-center', [\App\Http\Controllers\ExperienceCenterController::class, 'edit'])->name('admin.experience-center.edit');
    Route::post('/admin/pages/edit-experience-center', [\App\Http\Controllers\ExperienceCenterController::class, 'update'])->name('admin.experience-center.update');

    // Component Routes
    Route::get('/admin/components/edit-header', [\App\Http\Controllers\ComponentsController::class, 'editHeader'])->name('admin.components.edit-header');
    Route::put('/admin/components/edit-header', [\App\Http\Controllers\ComponentsController::class, 'updateHeader'])->name('admin.components.update-header');
    Route::get('/admin/components/edit-footer', [\App\Http\Controllers\ComponentsController::class, 'editFooter'])->name('admin.components.edit-footer');
    Route::put('/admin/components/edit-footer', [\App\Http\Controllers\ComponentsController::class, 'updateFooter'])->name('admin.components.update-footer');

    // Reviews CRUD (DB-based)
    Route::get('/admin/components/edit-reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('admin.components.edit-reviews');
    Route::post('/admin/reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'store'])->name('admin.reviews.store');
    Route::put('/admin/reviews/{review}', [\App\Http\Controllers\Admin\ReviewController::class, 'update'])->name('admin.reviews.update');
    Route::delete('/admin/reviews/{review}', [\App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('admin.reviews.destroy');

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

// Editor Dashboard Routes (Protected by EditorMiddleware)
Route::middleware(['auth', EditorMiddleware::class])->prefix('editor')->name('editor.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Editor\EditorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/destinations', [\App\Http\Controllers\Editor\EditorDestinationController::class, 'index'])->name('destinations.index');
    Route::get('/destinations/{destination}/edit', [\App\Http\Controllers\Editor\EditorDestinationController::class, 'edit'])->name('destinations.edit');
    Route::put('/destinations/{destination}', [\App\Http\Controllers\Editor\EditorDestinationController::class, 'update'])->name('destinations.update');
    // Editor user routes
    Route::get('/users', [\App\Http\Controllers\Editor\UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\Editor\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\Editor\UserController::class, 'update'])->name('users.update');
});

// Reservation routes
Route::get('/reservation', [App\Http\Controllers\ReservationController::class, 'showForm'])->name('reservation.form');
Route::post('/reservation', [App\Http\Controllers\ReservationController::class, 'store'])->name('reservation.store');

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

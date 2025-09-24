SEO Implementation for Innato CMS
================================

This document describes a modest, practical SEO management feature for the Innato Laravel CMS. It covers both the frontend admin UI work and the backend implementation details (database, models, controllers, routes, views, JS preview, and tests). Use this as a step-by-step guide to implement SEO management in the admin panel.

Goals
-----
- Provide a modest admin-accessible SEO management area.
- Allow editing of meta title, meta description, OG image, canonical URL and robots directives at the content level (destinations, pages, etc.) using a polymorphic `seo_meta` table.
- Offer a small SEO dashboard (linked from Pages admin) that aggregates SEO-related admin tasks.
- Keep changes non-destructive and backward compatible.

Overview
--------
- Add an `SEO` button to the Pages admin index view that links to an SEO index page.
- Create an admin SEO index blade view with minimal cards for Global, Destinations, Pages, Sitemap, Robots, Audit.
- Implement `SeoMeta` polymorphic model and `HasSEO` trait for content models (Destination, Page, etc.).
- Create migration for the `seo_meta` table.
- Add admin routes and an `AdminSeoController` to manage the SEO pages and actions.
- Update public `components.public-head` blade to accept `seoData` and render meta tags, OG tags, robots, canonical link and JSON-LD structured data.
- Add a small JS file for SEO preview and character counts.
- Add basic PHPUnit tests to ensure SEO metadata saving and rendering.


Step-by-step Implementation
--------------------------

1) Add SEO button to Pages admin index (frontend small change)
------------------------------------------------------------
File: `resources/views/admin/pages/index.blade.php`

Locate the top of the `pages-main-card` and replace the H2 block with a flex container that contains the H2 and a modest SEO button linking to the SEO index route. Example snippet:

```blade
<div class="control-panel-card pages-main-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2 class="control-panel-title" style="margin: 0;">Páginas</h2>
        <a href="{{ route('admin.seo.index') }}" class="control-panel-button" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
            <i class="fas fa-search"></i> SEO
        </a>
    </div>
    <p class="text-white opacity-75">Esta es la sección de gestión de páginas. El contenido se añadirá aquí en el futuro.</p>
```

This is intentionally modest and non-intrusive.

2) Create Admin SEO index blade
-------------------------------
File: `resources/views/admin/seo/index.blade.php`

Create a modest dashboard with cards for Global, Destinations, Pages, Sitemap, Robots and Audit. Use project visual patterns (cards-wrapper, control-panel-card, pages-card). The view should also have a "Back to Pages" button.

Example structure (trimmed):

```blade
<x-control-panel-layout>
    <div class="control-panel-card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
            <div>
                <h2 class="control-panel-title">Gestión SEO</h2>
                <p class="text-white opacity-75">Optimiza el SEO de tu sitio web para mejorar el posicionamiento en buscadores.</p>
            </div>
            <a href="{{ route('admin.pages.index') }}" class="control-panel-button control-panel-button-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Páginas
            </a>
        </div>

        <div class="cards-wrapper">
            <!-- cards for Global, Destinations, Pages -->
        </div>
    </div>
</x-control-panel-layout>
```

Add the file and wire routes/controller to serve it.

3) Routes and Controller skeleton
---------------------------------

Add routes to `routes/web.php` within the admin middleware group. Example:

```php
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('seo')->name('seo.')->group(function () {
        Route::get('/', [AdminSeoController::class, 'index'])->name('index');
        Route::get('/global', [AdminSeoController::class, 'global'])->name('global');
        Route::get('/destinations', [AdminSeoController::class, 'destinations'])->name('destinations');
        Route::get('/pages', [AdminSeoController::class, 'pages'])->name('pages');
        Route::get('/sitemap/generate', [AdminSeoController::class, 'generateSitemap'])->name('sitemap.generate');
        Route::get('/robots', [AdminSeoController::class, 'robots'])->name('robots');
        Route::get('/audit', [AdminSeoController::class, 'audit'])->name('audit');
    });
});
```

Create controller: `app/Http/Controllers/Admin/AdminSeoController.php` (skeleton methods returning the blades above). Use dependency injection for models like `Destination` when needed.

4) Database: SeoMeta migration and model
---------------------------------------

Create a migration for `seo_meta`:

```php
Schema::create('seo_meta', function (Blueprint $table) {
    $table->id();
    $table->string('seoable_type');
    $table->unsignedBigInteger('seoable_id');
    $table->string('meta_title', 255)->nullable();
    $table->string('meta_description', 160)->nullable();
    $table->text('meta_keywords')->nullable();
    $table->string('canonical_url')->nullable();
    $table->string('og_title')->nullable();
    $table->text('og_description')->nullable();
    $table->string('og_image')->nullable();
    $table->string('og_type')->default('website');
    $table->string('twitter_card')->default('summary_large_image');
    $table->boolean('robots_index')->default(true);
    $table->boolean('robots_follow')->default(true);
    $table->json('custom_meta')->nullable();
    $table->timestamps();

    $table->index(['seoable_type','seoable_id']);
    $table->unique(['seoable_type','seoable_id']);
});
```

Model: `app/Models/SeoMeta.php` with `seoable()` morphTo relationship and fillable attributes.

Trait: `app/Traits/HasSEO.php` (morphOne relationship and helper methods like `getSeoTitle()` and `getSeoDescription()`). Add the trait to `Destination` and other content models.

5) Admin edit form for content SEO
----------------------------------

For each content edit form (e.g., `resources/views/admin/destinations/edit.blade.php`), add a small SEO tab or a collapsible section containing the fields:

- meta_title (input, maxlength 60)
- meta_description (textarea, maxlength 160)
- og_image (file upload)
- canonical_url (input type=url)
- meta_keywords (input)
- robots_index / robots_follow (checkboxes)

Provide a small Google preview block showing title, URL and description. Add JS to live update preview and character counters.

6) Controller saving logic and file uploads
------------------------------------------

In admin update controller, validate incoming `seo` array and call a helper to create/update the `SeoMeta` record. Handle OG image upload and deletion with `Storage`.

Validation snippet:

```php
$validated = $request->validate([
    'seo.meta_title' => 'nullable|string|max:60',
    'seo.meta_description' => 'nullable|string|max:160',
    'seo.meta_keywords' => 'nullable|string|max:255',
    'seo.canonical_url' => 'nullable|url|max:255',
    'seo.og_image' => 'nullable|image|max:2048',
    'seo.robots_index' => 'boolean',
    'seo.robots_follow' => 'boolean',
]);
```

Processing function `updateSeoMeta($model, $seoData, $request)` should upload og_image if present and save the `SeoMeta` model via `$model->seoMeta()->save($seoMeta);`.

7) Public head integration
--------------------------

Update `resources/views/components/public-head.blade.php` to accept an optional `$seoData` variable and render the meta tags accordingly. Include canonical link, robots meta tag, OG tags, Twitter card tags and JSON-LD structured data (if available).

Example:

```blade
<title>{{ $seoData?->meta_title ?? ($title ?? 'INNATO – Turismo Comunitario Ecuador') }}</title>
<meta name="description" content="{{ $seoData?->meta_description ?? 'Descubre...' }}">
@if($seoData?->meta_keywords)
    <meta name="keywords" content="{{ $seoData->meta_keywords }}">
@endif
<link rel="canonical" href="{{ $seoData?->canonical_url ?? url()->current() }}">
<meta name="robots" content="{{ $seoData ? ($seoData->robots_index ? 'index' : 'noindex') : 'index' }},{{ $seoData ? ($seoData->robots_follow ? 'follow' : 'nofollow') : 'follow' }}">
<meta property="og:title" content="{{ $seoData?->og_title ?? $seoData?->meta_title ?? 'INNATO' }}">
@if($seoData?->og_image)
    <meta property="og:image" content="{{ Storage::url($seoData->og_image) }}">
@endif
```

8) JS SEO preview
-----------------

Create `public/js/seo-preview.js` with code that updates the preview card and character counters as the admin types. Hook it to inputs with IDs `meta_title` and `meta_description`.

9) Tests
--------

Add a feature test `tests/Feature/SeoManagementTest.php` that:
- Creates a destination
- Posts SEO data to the admin update route
- Asserts `seo_meta` table contains the new values
- Checks that public view renders the `meta` tags with the provided data

10) Rollout notes and backward compatibility
-------------------------------------------
- Existing entries that already stored "27°C" in temperature fields (from earlier conversation) are unaffected by SEO changes; unrelated.
- Existing content without SEO will use default fallbacks from model helper methods.
- No destructive migration; the `seo_meta` table is additive.

11) Security and Validation
---------------------------
- Validate file uploads and sanitize outputs to avoid XSS
- Ensure only authorized roles (admins/editors) can modify SEO fields
- Limit OG image size and file types

12) Next steps and enhancements
------------------------------
- Add batch SEO audit and mass-edit tools
- Add sitemap generation command and schedule via cron
- Add localized SEO (per-language meta fields)
- Add automatic suggestions and keyword analysis integration


Appendix: Example Controller Snippets
------------------------------------

(See the conversation above for full snippets.)


That's it — this markdown contains the full plan and step-by-step instructions to implement a modest, admin-facing SEO management area for Innato CMS. Implement the steps in order (frontend button, SEO index blade, routes/controller, migration/model, admin edit form, public-head integration, JS preview, tests).
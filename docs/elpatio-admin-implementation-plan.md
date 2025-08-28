# El Patio — Admin Edit Implementation Plan

Task receipt

I will create a complete, consistent plan to add an admin editor for the `elpatio` landing page, following existing admin patterns (home, header, footer, reviews). The file below lists a checklist, concrete steps, example code/location suggestions, validation, storage policy, QA and follow-ups.

Checklist

- [ ] Add persistent storage (model + migration) for El Patio editable content (`ElPatioSetting`).
- [ ] Add admin routes and controller methods (GET edit + PUT update) with the same middleware used by existing pages.
- [ ] Create admin Blade `resources/views/admin/pages/edit-elpatio.blade.php` that follows `edit-home.blade.php` UI patterns.
- [ ] Add a link/card in `resources/views/admin/pages/index.blade.php` so the page appears in the Pages dashboard.
- [ ] Implement file upload handling and previews (store in `storage/app/public/elpatio/`).
- [ ] Update the public `resources/views/elpatio/elpatio.blade.php` to read values injected from the model (or controller) when ready.
- [ ] Add basic feature test(s) and QA checklist.
- [ ] Provide migration and artisan instructions (migrate, view:clear, storage:link, cache clear).

Why this approach

- Keeps admin UI consistent with existing pages/components.
- Persists content in DB so the admin can edit without touching Blade templates.
- Stores images in `storage` using Laravel conventions (`public` disk) and uses `Storage::url()` for serving.

Concrete plan (step-by-step)

1) Database & Model

- Add migration file: `create_elpatio_settings_table.php` with fields (complete example so every editable piece is captured):
  - id (increments)
  - /* Header */
    - header_logo (string, nullable)                    -- path to logo image
    - header_show_logo (boolean, default true)
    - header_nav (json, nullable)                       -- array of {text,url,icon}
    - header_social (json, nullable)                    -- object with social URLs (instagram,tiktok,facebook,etc.)
    - header_whatsapp (string, nullable)
    - header_extra (json, nullable)                     -- any additional header flags

  - /* Hero */
    - hero_images (json, nullable)                      -- ordered array of image paths
    - hero_title (string, nullable)
    - hero_subtitle (string, nullable)
    - hero_button_text (string, nullable)
    - hero_button_link (string, nullable)

  - /* About sections */
    - about_title (string, nullable)
    - about_text (text, nullable)
    - about_image (string, nullable)

    - about2_title (string, nullable)
    - about2_text (text, nullable)
    - about2_image (string, nullable)

  - /* Rooms / Amenities */
    - rooms_title (string, nullable)
    - amenities (json, nullable)                        -- array of amenity text/items

  - /* Photo gallery */
    - gallery_images (json, nullable)                   -- ordered array of image paths

  - /* Blog / Latest posts preview (keeps small metadata only) */
    - blog_posts (json, nullable)                       -- array of {title,excerpt,date,author,slug,image}

  - /* Footer */
    - footer_address (string, nullable)
    - footer_phone (string, nullable)
    - footer_whatsapp_numbers (json, nullable)          -- array of phone numbers
    - footer_email (string, nullable)
    - footer_social (json, nullable)                    -- object with social URLs
    - footer_newsletter_title (string, nullable)
    - footer_newsletter_placeholder (string, nullable)
    - footer_newsletter_button_text (string, nullable)
    - footer_badge (string, nullable)                   -- path to badge image
    - footer_copyright (string, nullable)
    - footer_attribution_text (string, nullable)
    - footer_attribution_url (string, nullable)
    - footer_attribution_link_text (string, nullable)

  - extras (json, nullable)                             -- flexible for any future keys or complex structures
  - created_at, updated_at (timestamps)

- Add model `app/Models/ElPatioSetting.php` with an `instance()` singleton helper, matching the `HomeSetting::instance()` pattern used elsewhere:
  - public static function instance() { return static::first() ?? static::create([]); }
  - Add casts, for example:
    - protected $casts = [
        'hero_images' => 'array',
        'gallery_images' => 'array',
        'amenities' => 'array',
        'blog_posts' => 'array',
        'header_nav' => 'array',
        'header_social' => 'array',
        'footer_whatsapp_numbers' => 'array',
        'footer_social' => 'array',
        'extras' => 'array',
    ];

2) Routes

- Add admin routes (inside the existing admin/editor middleware groups in `routes/web.php`):

  Route::get('/admin/pages/edit-elpatio', [PagesController::class, 'editElPatio'])->name('admin.pages.edit-elpatio');
  Route::put('/admin/pages/edit-elpatio', [PagesController::class, 'updateElPatio'])->name('admin.pages.update-elpatio');

- Protect them with the same middleware as `edit-home` (Editor/Admin middleware groups).

3) Controller

- In `App\Http\Controllers\PagesController.php` add two methods:

  public function editElPatio()
  {
      $el = \App\Models\ElPatioSetting::instance();
      return view('admin.pages.edit-elpatio', compact('el'));
  }

  public function updateElPatio(Request $request)
  {
      $el = \App\Models\ElPatioSetting::instance();

      $validated = $request->validate([
          'hero_title' => 'nullable|string|max:255',
          'about_title' => 'nullable|string|max:255',
          'about_text' => 'nullable|string',
          'about_image' => 'nullable|image|mimes:jpeg,png,webp,avif|max:5120',
          'hero_images.*' => 'nullable|image|mimes:jpeg,png,webp,avif|max:5120',
          'gallery_images.*' => 'nullable|image|mimes:jpeg,png,webp,avif|max:5120',
          'amenities' => 'nullable|string', // comma-separated or JSON
      ]);

      // Handle image uploads (store on public disk under elpatio/)
      // Merge existing JSON arrays with newly uploaded images, or replace depending on form controls.

      // Example saving simple fields
      $el->hero_title = $validated['hero_title'] ?? $el->hero_title;
      $el->about_title = $validated['about_title'] ?? $el->about_title;
      $el->about_text = $validated['about_text'] ?? $el->about_text;

      // Save and redirect
      $el->save();
      return redirect()->back()->with('success', 'El Patio settings updated.');
  }

- Keep file storage code consistent with other components: `Storage::disk('public')->putFileAs('elpatio', $file, $filename)` and save relative path.

4) Admin Blade UI

- Create `resources/views/admin/pages/edit-elpatio.blade.php` following the `edit-home.blade.php` layout:
  - Use `<x-control-panel-layout>` wrapper.
  - Form `id="elpatio-edit-form" method="POST" action="{{ route('admin.pages.update-elpatio') }}" enctype="multipart/form-data"` with `@csrf` and `@method('PUT')`.
  - Sections (each as `control-panel-card pages-card control-panel-form-section`):
    - Hero: title, `hero_images[]` multi-upload with previews.
    - About: title, text, `about_image` file with preview.
    - About2: same as above for the second about section.
    - Rooms / Amenities: textarea or multiple fields saved as JSON.
    - Gallery: multiple uploads and previews; show existing gallery images with a "remove" checkbox for each (server-side deletion handled in controller).
  - Provide `previewImage(input, 'preview-...')` JS helper inline (copy from `edit-home`).
  - Use the same fixed action buttons pattern (cancel, save, view site) at the bottom.

5) Add the Pages dashboard link

- Edit `resources/views/admin/pages/index.blade.php` and add a card (mirroring Home/Contact cards) under the Pages list. Suggested snippet to add:

```blade
<!-- El Patio Management Card -->
<div class="control-panel-card pages-card">
    <h3 class="control-panel-subtitle">
        <i class="fas fa-bed"></i>
        El Patio
    </h3>
    <p>Manage the El Patio landing page content.</p>
    <div class="pages-card-actions">
        <a href="{{ route('admin.pages.edit-elpatio') }}" class="control-panel-button">
            <i class="fas fa-edit"></i> Editar
        </a>
    </div>
</div>
```

- Add this in the `cards-wrapper` area so it follows the same visual structure.

6) Public Blade consumption

- Keep `resources/views/elpatio/elpatio.blade.php` as the public template. Update it to use injected `$el` values instead of hard-coded text / URLs when ready. Example usage in the blade header:

```blade
@php $el = \App\Models\ElPatioSetting::instance(); @endphp
<h2>{{ $el->about_title ?? 'About our Casa' }}</h2>
<p>{!! nl2br(e($el->about_text ?? 'Default about text...')) !!}</p>
```

- Better: have your route/controller for the public landing page pass the model to the view:

```php
Route::get('/elpatio', function() {
    $el = \App\Models\ElPatioSetting::instance();
    return view('elpatio.elpatio', compact('el'));
});
```

7) Storage and preview behavior

- Upload path: `storage/app/public/elpatio/`
- Make sure `php artisan storage:link` has been run and the `public/storage` symlink exists.
- When rendering previews in admin, show images with `asset('storage/' . $path)` or `Storage::url($path)`.
- Provide small inline preview JS (same as existing `previewImage` used in `edit-home.blade.php`).

8) Tests & QA

- Add Feature tests under `tests/Feature/ElPatioAdminTest.php` to cover:
  - Admin GET edit page returns 200 for authenticated admin/editor.
  - Admin PUT update with fake images stores DB and files on disk (use `Storage::fake('public')` and `UploadedFile::fake()`).

Manual QA checklist

- [ ] Admin page loads and shows current values.
- [ ] File preview displays after selecting a new image.
- [ ] Saving updates DB row and stores files under `public/elpatio/`.
- [ ] Public page displays updated text/images without editing the Blade.
- [ ] Permissions: only Admin/Editor access the edit route.
- [ ] XSS protection: saved text is escaped or sanitized when rendering.

9) Edge cases & follow-ups

- Consider adding revision history if content rollback is needed.
- Consider a small WYSIWYG (Trix or TinyMCE) for long text fields, with server-side sanitization.
- For many gallery images, add pagination or a gallery management UI.
- Add an API endpoint for AJAX uploads if you want drag & drop in the admin.

10) Commands to run after changes

```powershell
php artisan migrate
php artisan storage:link
php artisan view:clear
php artisan cache:clear
php artisan config:clear
```

Files to create / edit (summary)

- Add: `database/migrations/xxxx_xx_xx_create_elpatio_settings_table.php`
- Add: `app/Models/ElPatioSetting.php`
- Edit: `routes/web.php` (add admin routes inside admin/editor middleware group)
- Edit: `app/Http/Controllers/PagesController.php` (add `editElPatio` + `updateElPatio`)
- Add: `resources/views/admin/pages/edit-elpatio.blade.php` (admin form UI)
- Edit: `resources/views/admin/pages/index.blade.php` (add El Patio card) — small change described above
- Edit (optional): `resources/views/elpatio/elpatio.blade.php` to use `$el` model fields when ready
- Add tests: `tests/Feature/ElPatioAdminTest.php` (recommended)

Security notes

- Validate and constrain uploads (mime types, size limits).
- Sanitize or escape all saved rich text before rendering (avoid raw untrusted HTML). Use `e()` or a sanitizer library for HTML.
- Ensure admin routes are protected by `auth`, `verified` and `Editor`/`Admin` middleware as appropriate.

Acceptance criteria

- Admin can update page title, sections, images and gallery via the new admin form.
- Public page shows updates after save without manual Blade edits.
- Files uploaded are saved in `storage/app/public/elpatio/` and served via `storage` symlink.
- Routes and views follow existing admin patterns and UI conventions.

Next steps I can take now

- I can scaffold the model + migration + controller skeleton + routes + admin blade and add the card to `admin/pages/index.blade.php` now. This will include the preview JS and the storage usage pattern used elsewhere.
- Or I can provide the exact text/code snippets for each file for you to paste manually.

Tell me whether you want me to scaffold the files now (I will create code and run small verification checks), or if you want the snippets and to apply them yourself.

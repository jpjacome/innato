# Current Reviews Setup: DR Pixel CMS

## 1. Data Model
- **Model:** `App\Models\ReviewsSetting`
  - Stores reviews as a single row in the `reviews_settings` table.
  - Main fields: `title`, `subtitle`, `reviews_data` (JSON string).
  - `instance()` static method returns the singleton instance, creating it with default reviews if not present.
  - `getReviewsAttribute()` decodes `reviews_data` to an array.

## 2. Admin Editing UI
- **Blade View:** `resources/views/admin/components/edit-reviews.blade.php`
  - Admin can edit `title`, `subtitle`, and `reviews_data` (as raw JSON in a textarea).
  - Form posts to `admin.components.update-reviews` route.
  - Validation errors and success messages shown.
  - Read-only preview of reviews as cards at the bottom (Alpine.js, parses JSON from textarea).

## 3. Frontend Display
- **Blade Component:** `resources/views/components/reviews-section.blade.php`
  - Loops through `$reviews` and renders each with `<x-review-card>`.
  - If no reviews, shows default hardcoded reviews.
- **Review Card:** `resources/views/components/review-card.blade.php`
  - Displays up to 4 stars (SVG), review text, reviewer name.
  - If rating >= 4, shows a `...` indicator.

## 4. Data Flow
- On frontend, reviews are passed as an array to the Blade component.
- In controllers/routes, reviews are loaded via `ReviewsSetting::instance()->reviews` (decoded from JSON).
- No individual review records; all reviews are stored as a single JSON blob.

## 5. Limitations
- **No relational DB for reviews:**
  - Cannot query, paginate, or manage reviews individually.
  - No timestamps, user IDs, or moderation status per review.
  - All reviews must be edited as JSON, risking structure errors.
- **No Eloquent model for individual reviews.**
- **No review CRUD operations.**
- **No review-related tests.**

## 6. Related Files
- `app/Models/ReviewsSetting.php`
- `resources/views/admin/components/edit-reviews.blade.php`
- `resources/views/components/reviews-section.blade.php`
- `resources/views/components/review-card.blade.php`
- `routes/web.php` (loads and passes reviews)

## 7. Conclusion
- The current reviews system is a monolithic JSON blob, not scalable or robust.
- Moving to a relational reviews table will enable proper CRUD, validation, moderation, and extensibility.
- All UI and backend logic will need to be refactored to support a true reviews database.

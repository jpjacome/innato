
# Google Analytics Integration Implementation Guide (Local & Production)

This guide describes how to integrate Google Analytics (GA4) with the Innato Laravel application, display homepage stats in the admin dashboard, and prepare for a seamless transition between local and production environments. All steps are environment-agnostic and use environment variables and placeholders to avoid rework after deployment.

---

## 1. Set Up Google Analytics (GA4)
- Go to https://analytics.google.com/ and create a Google Analytics account if you don't have one.
- Create a new property for your project (choose GA4).
- Add your local development domain (e.g., http://localhost:8000) and your production domain as data streams.
- Copy the Measurement ID (looks like G-XXXXXXXXXX).

## 2. Add the Google Analytics Tracking Script (Environment-Agnostic)
- In your main Blade layout (e.g., `resources/views/layouts/app.blade.php`), add the following placeholder code inside the `<head>` tag:

```blade
@if (config('analytics.measurement_id'))
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('analytics.measurement_id') }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ config('analytics.measurement_id') }}');
    </script>
@endif
```
- The Measurement ID will be set via environment variable (see step 5).

## 3. Create a Google Cloud Service Account for Analytics API
- Go to https://console.cloud.google.com/ and create a new project (or use an existing one).
- Enable the "Google Analytics Data API" for your project.
- Go to IAM & Admin > Service Accounts > Create Service Account.
- Download the JSON credentials file and save it to `storage/app/analytics/service-account-credentials.json` in your Laravel project.
- In Google Analytics, add the service account email as a user (Viewer role) to your GA property.

## 4. Install the Spatie Laravel Analytics Package
- In your project root, run:
  ```
  composer require spatie/laravel-analytics
  ```
- Publish the config file:
  ```
  php artisan vendor:publish --provider="Spatie\\LaravelAnalytics\\LaravelAnalyticsServiceProvider"
  ```

## 5. Configure the Package for Environment Variables
- Edit `config/analytics.php` to use environment variables:
  - Set the `property_id` to `env('GA_PROPERTY_ID')`.
  - Set the `credentials_json` path to `env('GA_CREDENTIALS_JSON', storage_path('app/analytics/service-account-credentials.json'))`.
  - Add a new key `measurement_id` set to `env('GA_MEASUREMENT_ID')` for use in Blade.
- In your `.env` file, add:
  ```
  GA_PROPERTY_ID=your-ga4-property-id
  GA_MEASUREMENT_ID=G-XXXXXXXXXX
  GA_CREDENTIALS_JSON=storage/app/analytics/service-account-credentials.json
  ```


## 6. Fetch and Display Stats in the Admin Dashboard (Production-Ready, No Mock Data)
- Create a new route in `routes/web.php` for the homepage stats page:
  ```php
  Route::get('/admin/pages/home-stats', [PagesController::class, 'homeStats'])->name('admin.pages.home-stats');
  ```
- In your `PagesController`, add a `homeStats` method:
  ```php
  use Spatie\Analytics\Analytics;
  use Spatie\Analytics\Period;

  public function homeStats()
  {
      // Only show analytics if credentials and property ID are set
      if (config('analytics.property_id') && file_exists(config('analytics.credentials_json'))) {
          $analyticsData = Analytics::fetchVisitorsAndPageViews(Period::days(7));
          return view('admin.pages.home-stats', compact('analyticsData'));
      }
      // If not configured, show a message or redirect
      return view('admin.pages.home-stats-disabled');
  }
  ```
- Create a new Blade view at `resources/views/admin/pages/home-stats.blade.php` to display the stats as a table or chart (only if analytics is configured).
- Create a new Blade view at `resources/views/admin/pages/home-stats-disabled.blade.php` with a message like:
  ```blade
  <x-control-panel-layout>
      <div class="control-panel-card">
          <h2 class="control-panel-title">Homepage Stats</h2>
          <p>Analytics will be available after deployment and configuration.</p>
      </div>
  </x-control-panel-layout>
  ```
- Make sure only admins can access this page.
- Do not display any mock or fake data locally. Analytics UI and data will only appear after deployment and configuration.

## 7. Test the Integration (Locally)
- Visit your homepage and admin dashboard locally.
- You should NOT see any analytics data or UI until you deploy and configure Google Analytics credentials.
- The stats page will show a message: "Analytics will be available after deployment and configuration."

## 8. What To Do After Deployment (Production Setup)
Once your app is deployed online and you are ready to enable Google Analytics:

1. **Set up your Google Analytics property and credentials:**
   - Create a GA4 property for your production domain.
   - Download the service account credentials JSON and upload it to `storage/app/analytics/service-account-credentials.json` on your server.
   - Add the service account email as a Viewer to your GA property.

2. **Update your production `.env` file:**
   - Set the following variables with your real values:
     ```
     GA_PROPERTY_ID=your-production-ga4-property-id
     GA_MEASUREMENT_ID=G-XXXXXXXXXX
     GA_CREDENTIALS_JSON=storage/app/analytics/service-account-credentials.json
     ```

3. **Verify permissions:**
   - Make sure only admins can access the analytics stats page.

4. **Test the integration:**
   - Visit the admin stats page. You should now see real analytics data from Google Analytics.

---

**Notes:**
- For advanced stats, see the Spatie package documentation: https://github.com/spatie/laravel-analytics
- Only admins should see analytics data in the dashboard.
- The codebase is now ready for analytics integration in any environment without rework. No mock data is ever shown.

---

# End of Implementation Guide

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\SeoMeta;
use App\Models\GlobalSeoSetting;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminSeoController extends Controller
{
    /**
     * Display the SEO management dashboard.
     */
    public function index(): View
    {
        $destinationsCount = Destination::count();
        $destinationsWithSeo = Destination::whereHas('seoMeta')->count();
        
        // Basic SEO stats
        $seoStats = [
            'optimized' => $destinationsWithSeo,
            'partial' => 0, // Can be enhanced later with partial optimization detection
            'missing' => $destinationsCount - $destinationsWithSeo,
            'total' => $destinationsCount + 5 // +5 for static pages
        ];
        
        return view('admin.seo.index', compact('destinationsCount', 'seoStats'));
    }
    
    /**
     * Display SEO management for destinations.
     */
    public function destinations(): View
    {
        $destinations = Destination::with('seoMeta')->paginate(15);
        
        return view('admin.seo.destinations', compact('destinations'));
    }
    
    /**
     * Show SEO edit form for a specific destination.
     */
    public function editDestination(Destination $destination): View
    {
        $destination->load('seoMeta');
        
        return view('admin.seo.edit', [
            'resource' => $destination,
            'resourceType' => 'destination',
            'backUrl' => route('admin.seo.destinations')
        ]);
    }
    
    /**
     * Update SEO data for a destination.
     */
    public function updateDestination(Request $request, Destination $destination): RedirectResponse
    {
        $validated = $request->validate([
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:500',
            'canonical_url' => 'nullable|url|max:255',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:300',
            'og_image' => 'nullable|image|max:2048', // 2MB max
            'robots_index' => 'boolean',
            'robots_follow' => 'boolean',
        ]);
        
        $this->updateSeoMeta($destination, $validated, $request);
        
        return redirect()->back()->with('success', 'SEO actualizado correctamente');
    }
    
    /**
     * Display global SEO settings.
     */
    public function global(): View
    {
        $settings = GlobalSeoSetting::instance();
        
        return view('admin.seo.global', compact('settings'));
    }

    /**
     * Update global SEO settings.
     */
    public function updateGlobal(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_title' => 'nullable|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'site_keywords' => 'nullable|string|max:500',
            'author' => 'nullable|string|max:255',
            'site_language' => 'nullable|string|max:10',
            'og_site_name' => 'nullable|string|max:255',
            'og_image' => 'nullable|image|max:2048',
            'og_type' => 'nullable|string|max:50',
            'twitter_card' => 'nullable|string|max:50',
            'twitter_site' => 'nullable|string|max:100',
            'twitter_creator' => 'nullable|string|max:100',
            'google_analytics_id' => 'nullable|string|max:50',
            'google_tag_manager_id' => 'nullable|string|max:50',
            'google_site_verification' => 'nullable|string|max:100',
            'bing_site_verification' => 'nullable|string|max:100',
            'yandex_site_verification' => 'nullable|string|max:100',
            'head_scripts' => 'nullable|string|max:10000',
            'body_scripts' => 'nullable|string|max:10000',
            'enable_canonical_urls' => 'boolean',
            'enable_og_tags' => 'boolean',
            'enable_twitter_cards' => 'boolean',
            'enable_schema_markup' => 'boolean',
        ]);

        $settings = GlobalSeoSetting::instance();

        // Handle OG image upload
        if ($request->hasFile('og_image')) {
            // Delete old image if exists
            if ($settings->og_image) {
                Storage::disk('public')->delete($settings->og_image);
            }
            
            // Store new image
            $path = $request->file('og_image')->store('seo/global', 'public');
            $validated['og_image'] = $path;
        }

        // Set boolean values for checkboxes
        $validated['enable_canonical_urls'] = $request->has('enable_canonical_urls');
        $validated['enable_og_tags'] = $request->has('enable_og_tags');
        $validated['enable_twitter_cards'] = $request->has('enable_twitter_cards');
        $validated['enable_schema_markup'] = $request->has('enable_schema_markup');

        $settings->update($validated);

        return redirect()->back()->with('success', 'Configuración SEO global actualizada correctamente');
    }
    
    /**
     * Display SEO management for static pages.
     */
    public function pages(): View
    {
        // For now, just show a placeholder
        return view('admin.seo.pages');
    }
    
    /**
     * Generate sitemap.xml
     */
    public function generateSitemap()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Homepage
        $xml .= '  <url>' . "\n";
        $xml .= '    <loc>' . url('/') . '</loc>' . "\n";
        $xml .= '    <changefreq>weekly</changefreq>' . "\n";
        $xml .= '    <priority>1.0</priority>' . "\n";
        $xml .= '  </url>' . "\n";

        // Static pages
        $staticPages = [
            ['url' => '/home', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['url' => '/about', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => '/contact', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => '/experience-center', 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['url' => '/destinations', 'priority' => '0.9', 'changefreq' => 'weekly'],
        ];

        foreach ($staticPages as $page) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . url($page['url']) . '</loc>' . "\n";
            $xml .= '    <changefreq>' . $page['changefreq'] . '</changefreq>' . "\n";
            $xml .= '    <priority>' . $page['priority'] . '</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }

        // Individual destinations
        $destinations = \App\Models\Destination::where('status', 'active')->get();
        foreach ($destinations as $destination) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . route('destination.show', $destination->slug) . '</loc>' . "\n";
            $xml .= '    <lastmod>' . $destination->updated_at->toISOString() . '</lastmod>' . "\n";
            $xml .= '    <changefreq>monthly</changefreq>' . "\n";
            $xml .= '    <priority>0.8</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }

        // Regional destination pages
        $regions = \App\Models\Destination::where('status', 'active')
            ->whereNotNull('region')
            ->distinct('region')
            ->pluck('region');

        foreach ($regions as $region) {
            if (!empty($region)) {
                $xml .= '  <url>' . "\n";
                $xml .= '    <loc>' . route('destinations.region', $region) . '</loc>' . "\n";
                $xml .= '    <changefreq>weekly</changefreq>' . "\n";
                $xml .= '    <priority>0.7</priority>' . "\n";
                $xml .= '  </url>' . "\n";
            }
        }

        // El Patio pages (if applicable to main domain)
        $elPatioPages = [
            ['url' => '/elpatio', 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['url' => '/elpatio-test', 'priority' => '0.4', 'changefreq' => 'monthly'],
            ['url' => '/elpatio-live', 'priority' => '0.4', 'changefreq' => 'monthly'],
        ];

        foreach ($elPatioPages as $page) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . url($page['url']) . '</loc>' . "\n";
            $xml .= '    <changefreq>' . $page['changefreq'] . '</changefreq>' . "\n";
            $xml .= '    <priority>' . $page['priority'] . '</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }

        // El Patio blog posts (if ElPatioPost model exists)
        if (class_exists('App\\Models\\ElPatioPost')) {
            $blogPosts = \App\Models\ElPatioPost::whereNotNull('published_at')->get();
            foreach ($blogPosts as $post) {
                $xml .= '  <url>' . "\n";
                $xml .= '    <loc>' . url('/elpatio/blog/' . $post->slug) . '</loc>' . "\n";
                $xml .= '    <lastmod>' . $post->updated_at->toISOString() . '</lastmod>' . "\n";
                $xml .= '    <changefreq>monthly</changefreq>' . "\n";
                $xml .= '    <priority>0.5</priority>' . "\n";
                $xml .= '  </url>' . "\n";
            }
        }

        // Public plant pages (if public routes exist)
        if (class_exists('App\\Models\\Plant')) {
            $plants = \App\Models\Plant::all();
            foreach ($plants as $plant) {
                // Check if public plant routes exist by attempting to generate URL
                try {
                    $plantUrl = route('public.plants.show', $plant->id);
                    $xml .= '  <url>' . "\n";
                    $xml .= '    <loc>' . $plantUrl . '</loc>' . "\n";
                    $xml .= '    <lastmod>' . $plant->updated_at->toISOString() . '</lastmod>' . "\n";
                    $xml .= '    <changefreq>monthly</changefreq>' . "\n";
                    $xml .= '    <priority>0.4</priority>' . "\n";
                    $xml .= '  </url>' . "\n";
                } catch (\Exception $e) {
                    // Route doesn't exist, skip
                }
            }

            // Plants index page
            try {
                $plantsIndexUrl = route('public.plants.index');
                $xml .= '  <url>' . "\n";
                $xml .= '    <loc>' . $plantsIndexUrl . '</loc>' . "\n";
                $xml .= '    <changefreq>weekly</changefreq>' . "\n";
                $xml .= '    <priority>0.6</priority>' . "\n";
                $xml .= '  </url>' . "\n";
            } catch (\Exception $e) {
                // Route doesn't exist, skip
            }
        }

        $xml .= '</urlset>';

        // Save to public directory
        file_put_contents(public_path('sitemap.xml'), $xml);

        return back()->with('success', 'Sitemap generated successfully with ' . substr_count($xml, '<url>') . ' URLs!');
    }

    /**
     * Display robots.txt management.
     */
    public function robots(): View
    {
        $robotsPath = public_path('robots.txt');
        $robotsContent = file_exists($robotsPath) ? file_get_contents($robotsPath) : $this->getDefaultRobotsTxt();
        
        return view('admin.seo.robots', compact('robotsContent'));
    }

    /**
     * Update robots.txt file.
     */
    public function updateRobots(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'robots_content' => 'required|string|max:10000'
        ]);
        
        $robotsPath = public_path('robots.txt');
        file_put_contents($robotsPath, $validated['robots_content']);
        
        return redirect()->back()->with('success', 'Robots.txt actualizado correctamente');
    }

    /**
     * Display SEO audit results.
     */
    public function audit(): View
    {
        $auditResults = $this->runBasicSeoAudit();
        
        return view('admin.seo.audit', compact('auditResults'));
    }

    /**
     * Get default robots.txt content.
     */
    private function getDefaultRobotsTxt(): string
    {
        return "User-agent: *\nAllow: /\n\nSitemap: " . url('/sitemap.xml');
    }

    /**
     * Run basic SEO audit.
     */
    private function runBasicSeoAudit(): array
    {
        $results = [];
        
        // Check sitemap exists
        $results[] = [
            'test' => 'Sitemap XML',
            'status' => file_exists(public_path('sitemap.xml')) ? 'pass' : 'fail',
            'message' => file_exists(public_path('sitemap.xml')) ? 
                'Sitemap encontrado' : 'Sitemap no encontrado - genera uno nuevo'
        ];
        
        // Check robots.txt exists
        $results[] = [
            'test' => 'Robots.txt',
            'status' => file_exists(public_path('robots.txt')) ? 'pass' : 'warning',
            'message' => file_exists(public_path('robots.txt')) ? 
                'Robots.txt encontrado' : 'Robots.txt no encontrado - considera crear uno'
        ];
        
        // Check destinations with SEO
        $destinationsCount = Destination::count();
        $destinationsWithSeo = Destination::whereHas('seoMeta')->count();
        $seoPercentage = $destinationsCount > 0 ? round(($destinationsWithSeo / $destinationsCount) * 100) : 0;
        
        $results[] = [
            'test' => 'SEO de Destinos',
            'status' => $seoPercentage >= 80 ? 'pass' : ($seoPercentage >= 50 ? 'warning' : 'fail'),
            'message' => "{$destinationsWithSeo} de {$destinationsCount} destinos tienen SEO optimizado ({$seoPercentage}%)"
        ];
        
        return $results;
    }
    
    /**
     * Update or create SEO meta data for a model.
     */
    private function updateSeoMeta($model, array $validated, Request $request): void
    {
        $seoMeta = $model->seoMeta ?? new SeoMeta();
        
        // Handle OG image upload
        if ($request->hasFile('og_image')) {
            // Delete old image if exists
            if ($seoMeta->og_image) {
                Storage::disk('public')->delete($seoMeta->og_image);
            }
            
            // Store new image
            $path = $request->file('og_image')->store('seo/og-images', 'public');
            $validated['og_image'] = $path;
        }
        
        // Set default values for checkboxes
        $validated['robots_index'] = $request->has('robots_index');
        $validated['robots_follow'] = $request->has('robots_follow');
        
        $seoMeta->fill($validated);
        $model->seoMeta()->save($seoMeta);
    }
}

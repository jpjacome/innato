<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeSetting;
use Illuminate\Support\Facades\Storage;

class PagesController extends Controller
{
    /**
     * Display the Pages page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.pages.index');
    }

    /**
     * Show the about page edit form.
     *
     * @return \Illuminate\View\View
     */
    public function editAbout()
    {
        $aboutSetting = null;
        if (class_exists('App\\Models\\AboutSetting')) {
            $aboutSetting = \App\Models\AboutSetting::instance();
        }
        return view('admin.pages.edit-about', compact('aboutSetting'));
    }

    /**
     * Show the about page on the public site.
     *
     * @return \Illuminate\View\View
     */
    public function showAbout()
    {
        if (class_exists('App\\Models\\AboutSetting')) {
            $aboutSetting = \App\Models\AboutSetting::instance();
        }
        if (!$aboutSetting) {
            // Create a blank AboutSetting-like object to avoid null errors in the Blade
            $aboutSetting = (object) [
                'title' => null,
                'description' => null,
                'cards' => json_encode([]),
                'banner_text' => null,
                'banner_image' => null,
                'headline_title' => null,
                'headline_cards' => json_encode([]),
                'destinations_title' => null,
                'destinations_button_text' => null,
                'destinations_values' => json_encode([]),
            ];
        }
        return view('about', compact('aboutSetting'));
    }

    /**
     * Update the about page settings.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAbout(Request $request)
    {
        $request->validate([
            'hero_title' => 'required|string|max:255',
            'about_title' => 'required|string|max:255',
            'about_description' => 'required|string',
            'cards' => 'required|array',
            'cards.*.title' => 'required|string|max:255',
            'banner_text' => 'required|string|max:255',
            'headline_title' => 'required|string|max:255',
            'headline_cards' => 'required|array',
            'headline_cards.*.title' => 'required|string|max:255',
            'headline_cards.*.subtitle' => 'nullable|string|max:255',
            'headline_cards.*.degree' => 'nullable|string|max:255',
            'headline_cards.*.description' => 'nullable|string',
            'destinations_title' => 'required|string|max:255',
            'destinations_button_text' => 'required|string|max:255',
        ]);

        if (class_exists('App\\Models\\AboutSetting')) {
            $aboutSetting = \App\Models\AboutSetting::instance();
            $aboutSetting->hero_title = $request->input('hero_title');
            $aboutSetting->title = $request->input('about_title');
            $aboutSetting->description = $request->input('about_description');
            $aboutSetting->cards = json_encode($request->input('cards'));
            $aboutSetting->banner_text = $request->input('banner_text');
            // Banner image upload
            if ($request->hasFile('banner_image')) {
                $bannerImage = $request->file('banner_image');
                $bannerPath = $bannerImage->store('about', 'public');
                $aboutSetting->banner_image = $bannerPath;
            }
            $aboutSetting->headline_title = $request->input('headline_title');

            // Get old headline_cards from DB for fallback
            $oldHeadlineCards = [];
            if (!empty($aboutSetting->headline_cards)) {
                $oldHeadlineCards = json_decode($aboutSetting->headline_cards, true);
            }

            $headlineCards = $request->input('headline_cards');
            // Handle headline card images, preserve old if not uploaded
            foreach ($headlineCards as $i => &$card) {
                if ($request->hasFile("headline_cards.$i.image")) {
                    $imgFile = $request->file("headline_cards.$i.image");
                    $imgPath = $imgFile->store('about', 'public');
                    $card['image'] = $imgPath;
                } else if (isset($oldHeadlineCards[$i]['image'])) {
                    $card['image'] = $oldHeadlineCards[$i]['image'];
                } else {
                    $card['image'] = null;
                }
            }
            unset($card); // break reference
            $aboutSetting->headline_cards = json_encode($headlineCards);
            $aboutSetting->destinations_title = $request->input('destinations_title');
            $aboutSetting->destinations_button_text = $request->input('destinations_button_text');
            $aboutSetting->save();
        }

        return redirect()->route('admin.pages.edit-about')
            ->with('success', 'About page updated successfully!');
    }

    /**
     * Show the home page edit form.
     *
     * @return \Illuminate\View\View
     */
    public function editHome()
    {
        $homeSetting = HomeSetting::instance();
        return view('admin.pages.edit-home', compact('homeSetting'));
    }

    /**
     * Update the home page settings.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateHome(Request $request)
    {
        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_button_text' => 'required|string|max:255',
            'headline_title' => 'required|string|max:255',
            'headline_description' => 'required|string',
            'headline_coast_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:8192',
            'headline_andes_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:8192',
            'headline_amazon_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:8192',
            'destinations_title' => 'required|string|max:255',
            'destinations_description' => 'required|string',
            'dest_span_amazonia' => 'required|string|max:255',
            'dest_span_costa' => 'required|string|max:255',
            'dest_span_sierra' => 'required|string|max:255',
            'dest_span_galapagos' => 'required|string|max:255',
            'destinations_button_text' => 'required|string|max:255',
            'destinations_footer_text' => 'required|string|max:255',
            'hero_video' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:20480', // 20MB max
        ]);

        $homeSetting = HomeSetting::instance();
        
        $data = $request->only([
            'hero_title',
            'hero_button_text',
            'headline_title',
            'headline_description',
            'destinations_title',
            'destinations_description',
            'dest_span_amazonia',
            'dest_span_costa',
            'dest_span_sierra',
            'dest_span_galapagos',
            'destinations_button_text',
            'destinations_footer_text',
        ]);

        // Handle headline images upload if provided
        if ($request->hasFile('headline_coast_image')) {
            $coastImage = $request->file('headline_coast_image');
            $coastPath = $coastImage->store('headline', 'public');
            $data['headline_coast_image'] = $coastPath;
        }
        if ($request->hasFile('headline_andes_image')) {
            $andesImage = $request->file('headline_andes_image');
            $andesPath = $andesImage->store('headline', 'public');
            $data['headline_andes_image'] = $andesPath;
        }
        if ($request->hasFile('headline_amazon_image')) {
            $amazonImage = $request->file('headline_amazon_image');
            $amazonPath = $amazonImage->store('headline', 'public');
            $data['headline_amazon_image'] = $amazonPath;
        }

        // Handle video upload if provided
        if ($request->hasFile('hero_video')) {
            $videoFile = $request->file('hero_video');
            $videoPath = $videoFile->store('videos', 'public');
            $data['hero_video_path'] = $videoPath;
        }

        $homeSetting->update($data);

        return redirect()->route('admin.pages.edit-home')
            ->with('success', 'Homepage settings updated successfully!');
    }
    /**
     * Display homepage analytics stats (mock or real).
     * Only accessible by admins.
     */
    public function homeStats()
    {
        // Only show analytics if credentials and property ID are set
        if (config('analytics.property_id') && file_exists(config('analytics.credentials_json'))) {
            $analyticsData = \Spatie\Analytics\Analytics::fetchVisitorsAndPageViews(\Spatie\Analytics\Period::days(7));
            return view('admin.pages.home-stats', compact('analyticsData'));
        }
        // If not configured, show a message or redirect
        return view('admin.pages.home-stats-disabled');
    }

    /**
     * Show the products page edit form.
     *
     * @return \Illuminate\View\View
     */
    public function editProducts()
    {
        $productsSetting = null;
        if (class_exists('App\\Models\\ProductsSetting')) {
            $productsSetting = \App\Models\ProductsSetting::instance();
        }
        return view('admin.pages.edit-products', compact('productsSetting'));
    }

    /**
     * Update the products page settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProducts(Request $request)
    {
        $request->validate([
            'banner_title' => 'nullable|string|max:255',
            'banner_description' => 'nullable|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'section_title' => 'nullable|string|max:255',
            'section_description' => 'nullable|string',
        ]);

        // Create or get the ProductsSetting instance
        if (class_exists('App\\Models\\ProductsSetting')) {
            $setting = \App\Models\ProductsSetting::first() ?? new \App\Models\ProductsSetting();
        } else {
            // If the model doesn't exist, we'll just return with a success message
            return redirect()->route('admin.pages.edit-products')
                           ->with('success', 'Products page updated successfully! (Note: ProductsSetting model needs to be created for persistence)');
        }

        // Update banner and section fields only
        $setting->banner_title = $request->input('banner_title');
        $setting->banner_description = $request->input('banner_description');
        $setting->section_title = $request->input('section_title');
        $setting->section_description = $request->input('section_description');

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            // Delete old banner image if exists
            if ($setting->banner_image) {
                Storage::disk('public')->delete($setting->banner_image);
            }
            
            $bannerImage = $request->file('banner_image');
            $bannerImagePath = $bannerImage->store('products', 'public');
            $setting->banner_image = $bannerImagePath;
        }

        $setting->save();

        return redirect()->route('admin.pages.edit-products')
                        ->with('success', 'Products page content updated successfully! Individual products are managed through the Products Catalog.');
    }
}

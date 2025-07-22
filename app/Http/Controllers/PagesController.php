<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeSetting;

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
            $headlineCards = $request->input('headline_cards');
            // Handle headline card images
            foreach ($headlineCards as $i => &$card) {
                if ($request->hasFile("headline_cards.$i.image")) {
                    $imgFile = $request->file("headline_cards.$i.image");
                    $imgPath = $imgFile->store('about', 'public');
                    $card['image'] = $imgPath;
                }
            }
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
}

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
}

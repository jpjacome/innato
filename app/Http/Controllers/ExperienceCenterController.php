<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExperienceCenterSetting;

class ExperienceCenterController extends Controller
{
    public function edit()
    {
        $setting = ExperienceCenterSetting::first();
        return view('admin.pages.edit-experience-center', [
            'experienceCenterSetting' => $setting
        ]);
    }

    public function update(Request $request)
    {

        $validated = $request->validate([
            'banner_title' => 'nullable|string|max:255',
            'banner_description' => 'nullable|string',
            'banner_image' => 'nullable|image',
            'button_text' => 'nullable|string|max:255',
            'banner2_title' => 'nullable|string|max:255',
            'banner2_description' => 'nullable|string',
            'banner2_button_text' => 'nullable|string|max:255',
            'container2_video' => 'nullable|file|mimetypes:video/mp4,video/webm,video/ogg',
            'container3_image' => 'nullable|image',
        ]);

        $setting = ExperienceCenterSetting::first() ?? new ExperienceCenterSetting();

        if ($request->hasFile('banner_image')) {
            $path = $request->file('banner_image')->store('experience-center', 'public');
            $setting->banner_image = $path;
        }
        if ($request->hasFile('container2_video')) {
            $path = $request->file('container2_video')->store('experience-center', 'public');
            $setting->container2_video = $path;
        }
        if ($request->hasFile('container3_image')) {
            $path = $request->file('container3_image')->store('experience-center', 'public');
            $setting->container3_image = $path;
        }

        $setting->banner_title = $validated['banner_title'] ?? $setting->banner_title;
        $setting->banner_description = $validated['banner_description'] ?? $setting->banner_description;
        $setting->button_text = $validated['button_text'] ?? $setting->button_text;
        $setting->banner2_title = $validated['banner2_title'] ?? $setting->banner2_title;
        $setting->banner2_description = $validated['banner2_description'] ?? $setting->banner2_description;
        $setting->banner2_button_text = $validated['banner2_button_text'] ?? $setting->banner2_button_text;
        $setting->save();

        return redirect()->route('admin.experience-center.edit')->with('success', 'Experience Center page updated successfully.');
    }
}

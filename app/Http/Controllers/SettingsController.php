<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DashboardSettings;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = DashboardSettings::first();
        
        if (!$settings) {
            $settings = new DashboardSettings([
                'primary_color' => '#4F46E5',
                'secondary_color' => '#818CF8',
                'accent_color' => '#6366f1',
                'dark_primary_color' => '#6366f1',
                'dark_secondary_color' => '#818CF8',
                'dark_accent_color' => '#4F46E5',
                'dashboard_title' => 'Dashboard',
                'show_logo' => false
            ]);
        }
        
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'primary_color' => 'required|string',
            'secondary_color' => 'required|string',
            'accent_color' => 'required|string',
            'dark_primary_color' => 'required|string',
            'dark_secondary_color' => 'required|string',
            'dark_accent_color' => 'required|string',
            'text_color' => 'required|string',
            'dark_text_color' => 'required|string',
            'dashboard_title' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'show_logo' => 'nullable',
        ]);

        $settings = DashboardSettings::firstOrNew();
        $settings->primary_color = $validated['primary_color'];
        $settings->secondary_color = $validated['secondary_color'];
        $settings->accent_color = $validated['accent_color'];
        $settings->dark_primary_color = $validated['dark_primary_color'];
        $settings->dark_secondary_color = $validated['dark_secondary_color'];
        $settings->dark_accent_color = $validated['dark_accent_color'];
        $settings->text_color = $validated['text_color'];
        $settings->dark_text_color = $validated['dark_text_color'];
        $settings->dashboard_title = $validated['dashboard_title'];
        $settings->show_logo = $request->has('show_logo');

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($settings->logo && Storage::disk('public')->exists($settings->logo)) {
                Storage::disk('public')->delete($settings->logo);
            }
            
            // Store new logo
            $logoPath = $request->file('logo')->store('logos', 'public');
            $settings->logo = $logoPath;
        }

        $settings->save();

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
} 
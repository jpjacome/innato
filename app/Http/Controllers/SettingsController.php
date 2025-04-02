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
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'primary_color' => 'required|string',
            'secondary_color' => 'required|string',
            'accent_color' => 'required|string',
            'dashboard_title' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $settings = DashboardSettings::first() ?? new DashboardSettings();
        $settings->primary_color = $validated['primary_color'];
        $settings->secondary_color = $validated['secondary_color'];
        $settings->accent_color = $validated['accent_color'];
        $settings->dashboard_title = $validated['dashboard_title'];

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
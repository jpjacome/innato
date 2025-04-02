<?php

namespace App\Http\Controllers;

use App\Models\HeroSetting;
use Illuminate\Http\Request;

class HeroSettingController extends Controller
{
    public function index()
    {
        $settings = HeroSetting::first();
        return view('dashboard', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title_text' => 'required|string|max:255',
            'title_color' => 'required|string|max:7',
            'title_size' => 'required|string|in:2rem,3rem,4rem,5rem',
            'title_font' => 'required|string|in:Arial,Times New Roman,Helvetica,Verdana',
        ]);

        $settings = HeroSetting::first() ?? new HeroSetting();
        
        $settings->title_text = $request->title_text;
        $settings->title_color = $request->title_color;
        $settings->title_size = $request->title_size;
        $settings->title_font = $request->title_font;
        
        $settings->save();

        return redirect()->route('dashboard')->with('success', 'Hero settings updated successfully.');
    }
}

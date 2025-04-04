<?php

namespace App\Http\Controllers;

use App\Models\HeroSetting;
use Illuminate\Http\Request;

class HeroSettingsController extends Controller
{
    public function edit()
    {
        $settings = HeroSetting::first();
        if (!$settings) {
            $settings = new HeroSetting([
                'title_text' => 'WELCOME',
                'title_color' => '#FFFFFF',
                'title_size' => '4rem',
                'title_font' => 'Playfair Display',
                'background_color' => '#6366f1'
            ]);
        }
        return redirect()->route('admin.dashboard');
    }

    public function update(Request $request)
    {
        $request->validate([
            'title_text' => 'required|string|max:255',
            'title_color' => 'required|string|max:7',
            'title_size' => 'required|string|in:2rem,3rem,4rem,5rem',
            'title_font' => 'required|string|in:Playfair Display,Montserrat,Righteous,Pacifico,Orbitron',
            'background_color' => 'required|string|max:7',
        ]);

        $settings = HeroSetting::first();
        if (!$settings) {
            $settings = new HeroSetting();
        }

        $settings->title_text = $request->title_text;
        $settings->title_color = $request->title_color;
        $settings->title_size = $request->title_size;
        $settings->title_font = $request->title_font;
        $settings->background_color = $request->background_color;
        $settings->save();

        return redirect()->back()->with('success', 'Hero settings updated successfully!');
    }
} 
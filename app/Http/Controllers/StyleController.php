<?php

namespace App\Http\Controllers;

use App\Models\DashboardSettings;
use Illuminate\Http\Response;

class StyleController extends Controller
{
    public function controlPanel()
    {
        $settings = DashboardSettings::first();
        
        if (!$settings) {
            $settings = new DashboardSettings([
                'primary_color' => '#4F46E5',
                'secondary_color' => '#818CF8',
                'accent_color' => '#6366f1',
            ]);
        }

        $css = file_get_contents(public_path('css/control-panel.css'));
        
        // Replace the default colors with the ones from settings
        $css = str_replace('#4F46E5', $settings->primary_color, $css);
        $css = str_replace('#818CF8', $settings->secondary_color, $css);
        $css = str_replace('#6366f1', $settings->accent_color, $css);

        return response($css)
            ->header('Content-Type', 'text/css')
            ->header('Cache-Control', 'no-cache, must-revalidate');
    }
} 
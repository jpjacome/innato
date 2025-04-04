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
                'dark_primary_color' => '#6366f1',
                'dark_secondary_color' => '#818CF8',
                'dark_accent_color' => '#4F46E5',
                'text_color' => '#ffffff',
                'dark_text_color' => '#ffffff',
            ]);
        }

        $css = file_get_contents(public_path('css/control-panel.css'));
        
        // Remove any existing theme variables
        $css = preg_replace('/:root\s*{[^}]*}/', '', $css);
        $css = preg_replace('/\[data-theme="dark"\]\s*{[^}]*}/', '', $css);
        
        // Add theme variables at the start of the CSS
        $themeVariables = "
            :root {
                --primary-color: {$settings->primary_color};
                --secondary-color: {$settings->secondary_color};
                --accent-color: {$settings->accent_color};
                --text: {$settings->text_color};
                --black: #000000;
            }
            
            [data-theme='dark'] {
                --primary-color: {$settings->dark_primary_color};
                --secondary-color: {$settings->dark_secondary_color};
                --accent-color: {$settings->dark_accent_color};
                --text: {$settings->dark_text_color};
                --black: #000000;
            }
        ";
        
        $css = $themeVariables . $css;

        return response($css)
            ->header('Content-Type', 'text/css')
            ->header('Cache-Control', 'no-cache, must-revalidate');
    }
} 
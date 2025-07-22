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
                'primary_color' => '#645EA6',  // --color-3
                'secondary_color' => '#D6DF27', // --color-2
                'accent_color' => '#ED5934',   // --color-4
                'dark_primary_color' => '#645EA6',
                'dark_secondary_color' => '#D6DF27',
                'dark_accent_color' => '#ED5934',
                'text_color' => '#262622',     // --color-black
                'dark_text_color' => '#262622',
            ]);
        }

        $css = file_get_contents(public_path('css/control-panel.css'));
        
        // Remove any existing theme variables
        $css = preg_replace('/:root\s*{[^}]*}/', '', $css);
        $css = preg_replace('/\[data-theme="dark"\]\s*{[^}]*}/', '', $css);
        
        // Add theme variables at the start of the CSS
        $themeVariables = "
            :root {
                /* Base colors from general.css */
                --color-1: #F0E9DE;
                --color-2: #D6DF27; 
                --color-3: #645EA6; 
                --color-4: #ED5934;
                --color-5: #055029;
                --color-black: #262622;
                
                /* Control panel mappings */
                --primary-color: {$settings->primary_color};
                --secondary-color: {$settings->secondary_color};
                --accent-color: {$settings->accent_color};
                --text: {$settings->text_color};
                --black: var(--color-black);
                --control-panel-bg: var(--color-1);
                --control-panel-card-bg: #ffffff;
                --control-panel-text: var(--color-black);
                --control-panel-text-muted: #6b7280;
                --control-panel-border: #e5e7eb;
                --control-panel-hover-bg: rgba(0, 0, 0, 0.05);
            }
            
            [data-theme='dark'] {
                --primary-color: {$settings->dark_primary_color};
                --secondary-color: {$settings->dark_secondary_color};
                --accent-color: {$settings->dark_accent_color};
                --text: {$settings->dark_text_color};
                --black: var(--color-black);
                --control-panel-bg: var(--color-3);
                --control-panel-card-bg: #1f2937;
                --control-panel-text: #ffffff;
                --control-panel-text-muted: #9ca3af;
                --control-panel-border: #374151;
                --control-panel-hover-bg: rgba(255, 255, 255, 0.05);
            }
        ";
        
        $css = $themeVariables . $css;

        return response($css)
            ->header('Content-Type', 'text/css')
            ->header('Cache-Control', 'no-cache, must-revalidate');
    }
} 
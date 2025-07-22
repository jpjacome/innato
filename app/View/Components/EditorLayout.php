<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\DashboardSettings;

class EditorLayout extends Component
{
    public $settings;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->settings = DashboardSettings::first();
        
        if (!$this->settings) {
            $this->settings = new DashboardSettings([
                'primary_color' => '#4F46E5',
                'secondary_color' => '#818CF8',
                'accent_color' => '#6366f1',
                'dashboard_title' => 'Editor Dashboard',
                'show_logo' => false
            ]);
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.editor');
    }
}

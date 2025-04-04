<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\DashboardSettings;

class ControlPanelLayout extends Component
{
    public $settings;

    public function __construct()
    {
        $this->settings = DashboardSettings::first();
        
        if (!$this->settings) {
            $this->settings = new DashboardSettings([
                'primary_color' => '#4F46E5',
                'secondary_color' => '#818CF8',
                'accent_color' => '#6366f1',
                'dashboard_title' => 'Dashboard',
                'show_logo' => false
            ]);
        }
    }

    public function render()
    {
        return view('layouts.control-panel');
    }
} 
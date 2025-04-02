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
    }

    public function render()
    {
        return view('layouts.control-panel');
    }
} 
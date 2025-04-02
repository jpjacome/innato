<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DashboardSettings;

class DashboardSettingsSeeder extends Seeder
{
    public function run()
    {
        if (!DashboardSettings::exists()) {
            DashboardSettings::create([
                'primary_color' => '#4F46E5',
                'secondary_color' => '#818CF8',
                'dashboard_title' => 'Admin Dashboard',
            ]);
        }
    }
} 
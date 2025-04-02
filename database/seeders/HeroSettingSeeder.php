<?php

namespace Database\Seeders;

use App\Models\HeroSetting;
use Illuminate\Database\Seeder;

class HeroSettingSeeder extends Seeder
{
    public function run(): void
    {
        HeroSetting::create([
            'title_text' => 'WELCOME',
            'title_color' => '#FFFFFF',
            'title_size' => '4rem',
            'title_font' => 'Playfair Display'
        ]);
    }
} 